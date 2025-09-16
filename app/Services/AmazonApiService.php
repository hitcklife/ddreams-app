<?php

namespace App\Services;

use App\Models\AmazonSetting;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AmazonApiService
{
    protected $settings;

    public function __construct(AmazonSetting $settings)
    {
        $this->settings = $settings;
    }

    public function fetchLiveAuctions(array $filterOptions = []): ?array
    {
        if (!$this->settings->hasAllSettings()) {
            throw new \Exception('Amazon settings are not properly configured');
        }

        // Use the filterOptions directly - they already contain proper defaults from Livewire
        $payload = $filterOptions;

        // Log the payload to see what's being sent
        Log::info('Amazon API Payload', [
            'payload' => $payload,
            'filterOptions' => $filterOptions
        ]);

        try {
            $response = Http::withHeaders([
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'anti-csrftoken-a2z' => $this->settings->anti_csrf_token_a2z,
                'Content-Type' => 'application/json',
                'Cookie' => $this->settings->cookie,
                'Host' => 'relay.amazon.com',
                'Origin' => 'https://relay.amazon.com',
                'Referer' => 'https://relay.amazon.com/auctions?ref=owp_nav_auctions',
                'x-csrf-token' => $this->settings->x_csrf_token,
                'X-Page-Path' => '/auctions',
            ])->post('https://relay.amazon.com/api/auctions/fetchLiveAuctions', $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Amazon API request failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Amazon API request exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    public function loginAndGetCredentials(string $email, string $password): ?array
    {
        try {
            // Step 1: Start the OpenID flow to get the Amazon login page
            $openIdUrl = 'https://www.amazon.com/ap/signin?' . http_build_query([
                'openid.pape.max_auth_age' => '86400',
                'openid.return_to' => 'https://relay.amazon.com/',
                'openid.identity' => 'http://specs.openid.net/auth/2.0/identifier_select',
                'openid.assoc_handle' => 'amzn_relay_desktop_us',
                'openid.mode' => 'checkid_setup',
                'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select',
                'pageId' => 'amzn_relay_desktop_us',
                'openid.ns' => 'http://specs.openid.net/auth/2.0'
            ]);

            $loginPageResponse = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.9',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Upgrade-Insecure-Requests' => '1',
                'Sec-Fetch-Dest' => 'document',
                'Sec-Fetch-Mode' => 'navigate',
                'Sec-Fetch-Site' => 'none',
            ])->get($openIdUrl);

            if (!$loginPageResponse->successful()) {
                throw new \Exception('Failed to load Amazon login page: ' . $loginPageResponse->status());
            }

            $pageBody = $loginPageResponse->body();

            // Check if we actually got a login page (not an error page)
            if (strpos($pageBody, 'signin') === false && strpos($pageBody, 'password') === false) {
                Log::warning('Received unexpected page instead of login form', [
                    'status' => $loginPageResponse->status(),
                    'body_preview' => substr($pageBody, 0, 500),
                    'url' => $openIdUrl
                ]);
            }

            // Extract hidden form fields and cookies from login page
            $hiddenFields = $this->extractHiddenFields($pageBody);
            $cookies = $this->extractCookiesFromResponse($loginPageResponse);

            // If we don't have critical fields, try to get a fresh login page
            if (!isset($hiddenFields['appActionToken']) || !isset($hiddenFields['workflowState'])) {
                Log::warning('Missing critical hidden fields, attempting to get fresh login page', [
                    'missing_fields' => [
                        'appActionToken' => !isset($hiddenFields['appActionToken']),
                        'workflowState' => !isset($hiddenFields['workflowState']),
                        'aaToken' => !isset($hiddenFields['aaToken']),
                    ]
                ]);

                // Try a fresh request without any cookies
                $freshLoginResponse = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.9',
                    'Cache-Control' => 'no-cache',
                    'Pragma' => 'no-cache',
                ])->get($openIdUrl);

                if ($freshLoginResponse->successful()) {
                    $hiddenFields = $this->extractHiddenFields($freshLoginResponse->body());
                    $cookies = $this->extractCookiesFromResponse($freshLoginResponse);
                }
            }

            // Step 2: Submit login form to Amazon
            $loginData = $hiddenFields;
            $loginData['email'] = $email;
            $loginData['password'] = $password;

            // Don't override metadata1 if it's already in hidden fields
            if (!isset($loginData['metadata1'])) {
                $loginData['metadata1'] = $this->getDeviceMetadata();
            }

            // Ensure we don't override other critical fields
            if (!isset($loginData['create'])) {
                $loginData['create'] = '0';
            }

            Log::info('Amazon login attempt', [
                'email' => $email,
                'hidden_fields_count' => count($hiddenFields),
                'has_app_action_token' => isset($hiddenFields['appActionToken']),
                'has_workflow_state' => isset($hiddenFields['workflowState']),
                'has_aa_token' => isset($hiddenFields['aaToken']),
                'hidden_field_names' => array_keys($hiddenFields),
                'openid_url' => $openIdUrl,
                'page_response_status' => $loginPageResponse->status(),
            ]);

            $loginResponse = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Cookie' => $cookies,
                'Referer' => $openIdUrl,
                'Origin' => 'https://www.amazon.com',
                'Sec-Fetch-Dest' => 'document',
                'Sec-Fetch-Mode' => 'navigate',
                'Sec-Fetch-Site' => 'same-origin',
            ])->asForm()->post('https://www.amazon.com/ap/signin', $loginData);

            // Step 3: Handle the login response
            $sessionCookies = $this->mergeCookies($cookies, $this->extractCookiesFromResponse($loginResponse));

            Log::info('Amazon login response', [
                'status' => $loginResponse->status(),
                'has_location_header' => $loginResponse->hasHeader('Location'),
                'location' => $loginResponse->header('Location'),
                'body_preview' => substr($loginResponse->body(), 0, 500)
            ]);

            // Check for successful login (could be 200, 302, or other redirect)
            if ($loginResponse->successful() || in_array($loginResponse->status(), [302, 303, 301])) {
                $location = $loginResponse->header('Location');

                // If there's a redirect, follow it
                if ($location) {
                    Log::info('Following redirect', ['location' => $location]);

                    $redirectResponse = Http::withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                        'Cookie' => $sessionCookies,
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
                    ])->get($location);

                    if ($redirectResponse->successful()) {
                        $finalCookies = $this->mergeCookies($sessionCookies, $this->extractCookiesFromResponse($redirectResponse));
                    } else {
                        $finalCookies = $sessionCookies;
                    }
                } else {
                    $finalCookies = $sessionCookies;
                }

                // Try to get the access token from the API endpoint
                $tokenResponse = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Cookie' => $finalCookies,
                    'Accept' => '*/*',
                    'Referer' => 'https://relay.amazon.com/',
                    'Sec-Fetch-Dest' => 'empty',
                    'Sec-Fetch-Mode' => 'cors',
                    'Sec-Fetch-Site' => 'same-origin',
                ])->get('https://relay.amazon.com/api/token');

                $accessToken = null;
                if ($tokenResponse->successful()) {
                    $tokenData = $tokenResponse->json();
                    $accessToken = $tokenData['access_token'] ?? null;

                    Log::info('Got access token from API', [
                        'has_access_token' => !empty($accessToken),
                        'token_type' => $tokenData['token_type'] ?? null,
                        'expires_in' => $tokenData['expires_in'] ?? null,
                    ]);
                }

                // Now try to access the Relay auctions page to get CSRF tokens
                $dashboardResponse = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Cookie' => $finalCookies,
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
                ])->get('https://relay.amazon.com/auctions');

                Log::info('Dashboard access attempt', [
                    'status' => $dashboardResponse->status(),
                    'successful' => $dashboardResponse->successful(),
                    'body_preview' => substr($dashboardResponse->body(), 0, 500)
                ]);

                $tokens = [];
                if ($dashboardResponse->successful()) {
                    $tokens = $this->extractTokensFromPage($dashboardResponse->body());

                    Log::info('Extracted tokens from dashboard', [
                        'has_anti_csrf' => !empty($tokens['anti_csrf_token_a2z']),
                        'has_x_csrf' => !empty($tokens['x_csrf_token']),
                        'has_access_token' => !empty($accessToken),
                    ]);
                }

                return [
                    'anti_csrf_token_a2z' => $tokens['anti_csrf_token_a2z'] ?? '',
                    'cookie' => $finalCookies,
                    'x_csrf_token' => $tokens['x_csrf_token'] ?? '',
                    'access_token' => $accessToken ?? '',
                ];
            }

            Log::error('Amazon login failed', [
                'status' => $loginResponse->status(),
                'headers' => $loginResponse->headers(),
                'body' => substr($loginResponse->body(), 0, 1000) // Log first 1000 chars
            ]);

            // Try to extract specific error message from the response
            $errorMessage = $this->extractErrorMessage($loginResponse->body());
            if ($errorMessage) {
                throw new \Exception("Amazon login failed: {$errorMessage}");
            }

            throw new \Exception("Amazon login failed with status {$loginResponse->status()}. Check logs for details.");

        } catch (\Exception $e) {
            Log::error('Amazon login exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    private function extractCookiesFromResponse(Response $response): string
    {
        $cookies = [];
        $setCookieHeaders = $response->headers()['Set-Cookie'] ?? [];

        foreach ($setCookieHeaders as $cookieHeader) {
            $cookieParts = explode(';', $cookieHeader);
            $cookieNameValue = trim($cookieParts[0]);
            if (!empty($cookieNameValue) && strpos($cookieNameValue, '=') !== false) {
                $cookies[] = $cookieNameValue;
            }
        }

        return implode('; ', $cookies);
    }

    private function extractHiddenFields(string $html): array
    {
        $fields = [];

        // Extract all hidden input fields
        if (preg_match_all('/<input[^>]*type=["\']hidden["\'][^>]*>/i', $html, $matches)) {
            foreach ($matches[0] as $input) {
                if (preg_match('/name=["\']([^"\']*)["\']/', $input, $nameMatch) &&
                    preg_match('/value=["\']([^"\']*)["\']/', $input, $valueMatch)) {
                    $fields[$nameMatch[1]] = html_entity_decode($valueMatch[1]);
                }
            }
        }

        // Also extract any input fields that might not be explicitly type="hidden"
        if (preg_match_all('/<input[^>]*name=["\']([^"\']*)["\'][^>]*value=["\']([^"\']*)["\'][^>]*>/i', $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $name = $match[1];
                $value = html_entity_decode($match[2]);
                if (!isset($fields[$name])) {
                    $fields[$name] = $value;
                }
            }
        }

        // Specifically look for the aaToken which might be in a different format
        if (preg_match('/name=["\']aaToken["\'][^>]*value=["\']([^"\']*)["\']/', $html, $matches)) {
            $fields['aaToken'] = html_entity_decode($matches[1]);
        }

        // Look for aaToken in script tags (common in modern Amazon pages)
        if (preg_match('/"aaToken"\s*:\s*"([^"]*)"/', $html, $matches)) {
            $fields['aaToken'] = $matches[1];
        }

        // Alternative aaToken extraction
        if (preg_match('/window\.aaToken\s*=\s*"([^"]*)"/', $html, $matches)) {
            $fields['aaToken'] = $matches[1];
        }

        return $fields;
    }

    private function mergeCookies(string $existing, string $new): string
    {
        if (empty($existing)) return $new;
        if (empty($new)) return $existing;

        $existingCookies = [];
        foreach (explode('; ', $existing) as $cookie) {
            $parts = explode('=', $cookie, 2);
            if (count($parts) === 2) {
                $existingCookies[$parts[0]] = $parts[1];
            }
        }

        foreach (explode('; ', $new) as $cookie) {
            $parts = explode('=', $cookie, 2);
            if (count($parts) === 2) {
                $existingCookies[$parts[0]] = $parts[1];
            }
        }

        $result = [];
        foreach ($existingCookies as $name => $value) {
            $result[] = $name . '=' . $value;
        }

        return implode('; ', $result);
    }

    private function extractTokensFromPage(string $html): array
    {
        $tokens = [];

        // Extract anti-csrf-token-a2z from various sources
        $antiCsrfPatterns = [
            '/name=["\']anti-csrftoken-a2z["\'][^>]*value=["\']([^"\']*)["\']/',
            '/content=["\']([^"\']*)["\'][^>]*name=["\']anti-csrftoken-a2z["\']/',
            '/"antiCsrfTokenA2Z":\s*"([^"]*)"/',
            '/window\.antiCsrfTokenA2Z\s*=\s*["\']([^"\']*)["\']/',
            '/<meta[^>]*name=["\']anti-csrftoken-a2z["\'][^>]*content=["\']([^"\']*)["\']/',
        ];

        foreach ($antiCsrfPatterns as $pattern) {
            if (preg_match($pattern, $html, $matches)) {
                $tokens['anti_csrf_token_a2z'] = $matches[1];
                break;
            }
        }

        // Extract x-csrf-token from various sources
        $xCsrfPatterns = [
            '/name=["\']x-csrf-token["\'][^>]*value=["\']([^"\']*)["\']/',
            '/"csrfToken":\s*"([^"]*)"/',
            '/window\.csrfToken\s*=\s*["\']([^"\']*)["\']/',
            '/<meta[^>]*name=["\']csrf-token["\'][^>]*content=["\']([^"\']*)["\']/',
            '/<meta[^>]*name=["\']x-csrf-token["\'][^>]*content=["\']([^"\']*)["\']/',
            '/CSRF_TOKEN\s*:\s*["\']([^"\']*)["\']/',
            '/_token["\']:\s*["\']([^"\']*)["\']/',
        ];

        foreach ($xCsrfPatterns as $pattern) {
            if (preg_match($pattern, $html, $matches)) {
                $tokens['x_csrf_token'] = $matches[1];
                break;
            }
        }

        return $tokens;
    }

    private function extractErrorMessage(string $html): ?string
    {
        // Look for common Amazon error messages
        $errorPatterns = [
            '/class="[^"]*alert[^"]*"[^>]*>.*?<[^>]*>([^<]+)/',
            '/class="[^"]*error[^"]*"[^>]*>.*?<[^>]*>([^<]+)/',
            '/data-a-alert-type="error"[^>]*>.*?<[^>]*>([^<]+)/',
            '/<div[^>]*auth-error[^>]*>.*?<[^>]*>([^<]+)/',
            '/We cannot find an account/',
            '/Your password is incorrect/',
            '/Enter a valid email/',
            '/Sorry, we could not find your account/',
        ];

        foreach ($errorPatterns as $pattern) {
            if (preg_match($pattern, $html, $matches)) {
                return isset($matches[1]) ? trim(strip_tags($matches[1])) : trim(strip_tags($matches[0]));
            }
        }

        // Look for generic error divs
        if (preg_match('/<div[^>]*class="[^"]*error[^"]*"[^>]*>(.*?)<\/div>/is', $html, $matches)) {
            $errorText = strip_tags($matches[1]);
            if (!empty(trim($errorText))) {
                return trim($errorText);
            }
        }

        return null;
    }

    private function getDeviceMetadata(): string
    {
        return json_encode([
            'ubid-main' => 'ubi-' . strtoupper(bin2hex(random_bytes(8))),
            'device-type' => 'web',
            'os-type' => 'web',
        ]);
    }

    public static function createForUser($userId): ?self
    {
        $settings = AmazonSetting::where('user_id', $userId)->first();

        if (!$settings) {
            return null;
        }

        return new self($settings);
    }
}
