<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth.split')]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        try {
            \Log::info('Login attempt started', [
                'email' => $this->email,
                'has_password' => !empty($this->password),
                'remember' => $this->remember,
                'session_id' => session()->getId(),
                'csrf_token' => session()->token(),
            ]);

            $this->validate();

            \Log::info('Validation passed');

            $this->ensureIsNotRateLimited();

            \Log::info('Rate limiting check passed');

            $attemptResult = Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember);

            \Log::info('Auth attempt result', [
                'success' => $attemptResult,
                'user_found' => \App\Models\User::where('email', $this->email)->exists(),
            ]);

            if (!$attemptResult) {
                RateLimiter::hit($this->throttleKey());

                \Log::warning('Login failed - invalid credentials', [
                    'email' => $this->email,
                    'throttle_key' => $this->throttleKey(),
                ]);

                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }

            RateLimiter::clear($this->throttleKey());
            Session::regenerate();

            \Log::info('Login successful', [
                'user_id' => auth()->id(),
                'email' => $this->email,
            ]);

            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

        } catch (\Exception $e) {
            \Log::error('Login exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'email' => $this->email,
            ]);

            // Re-throw validation exceptions so they show to the user
            if ($e instanceof ValidationException) {
                throw $e;
            }

            // For other exceptions, show a generic error
            throw ValidationException::withMessages([
                'email' => 'An error occurred during login. Please try again.',
            ]);
        }
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
