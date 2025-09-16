<?php

namespace App\Services;

use App\Models\AmazonSetting;
use App\Models\AutoBid;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BidService
{
    protected $settings;

    public function __construct(AmazonSetting $settings)
    {
        $this->settings = $settings;
    }

    public function submitBid(string $auctionId, float $bidAmount): bool
    {
        if (!$this->settings->hasAllSettings()) {
            throw new \Exception('Amazon settings are not properly configured');
        }

        $payload = [
            'auctionId' => $auctionId,
            'bidAmount' => [
                'amount' => $bidAmount,
                'currency' => 'USD',
                'type' => 'PER_LOAD'
            ]
        ];

        Log::info('Submitting bid', [
            'auctionId' => $auctionId,
            'bidAmount' => $bidAmount,
            'payload' => $payload
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
            ])->post('https://relay.amazon.com/api/auctions/submitBid', $payload);

            if ($response->successful()) {
                Log::info('Bid submitted successfully', [
                    'auctionId' => $auctionId,
                    'bidAmount' => $bidAmount,
                    'response' => $response->json()
                ]);
                return true;
            }

            Log::error('Bid submission failed', [
                'auctionId' => $auctionId,
                'bidAmount' => $bidAmount,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Bid submission exception', [
                'auctionId' => $auctionId,
                'bidAmount' => $bidAmount,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    public function calculateCompetitiveBid(array $auctionData, AutoBid $autoBid): ?float
    {
        // Get current winning bid from auction data
        $currentWinningBid = $this->getCurrentWinningBid($auctionData);
        
        if (!$currentWinningBid) {
            // No bids yet, bid at minimum price
            return $autoBid->minimum_bid_price;
        }

        // Calculate bid that's lower than current winning bid
        $competitiveBid = $currentWinningBid - 1; // $1 lower

        // Apply 6% reduction rule if user has bid before
        if ($autoBid->last_bid_amount) {
            $sixPercentReduction = $autoBid->last_bid_amount * 0.06;
            $minimumAllowedBid = $autoBid->last_bid_amount - $sixPercentReduction;
            
            // Use the higher of the competitive bid or the 6% reduced bid
            $competitiveBid = max($competitiveBid, $minimumAllowedBid);
        }

        // Don't bid below minimum price
        if ($competitiveBid < $autoBid->minimum_bid_price) {
            Log::info('Calculated bid below minimum, not bidding', [
                'auctionId' => $autoBid->auction_id,
                'calculatedBid' => $competitiveBid,
                'minimumPrice' => $autoBid->minimum_bid_price
            ]);
            return null;
        }

        return $competitiveBid;
    }

    private function getCurrentWinningBid(array $auctionData): ?float
    {
        // Extract current winning bid from auction data
        // This depends on the Amazon API response structure
        $bids = $auctionData['bidderAuctionView']['bids'] ?? [];
        
        if (empty($bids)) {
            return null;
        }

        // For reverse auctions, the winning bid is the lowest
        $winningBid = collect($bids)->min('bidAmount.amount');
        
        return $winningBid ? (float) $winningBid : null;
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