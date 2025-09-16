<?php

namespace App\Livewire;

use App\Models\AmazonSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AmazonSettings extends Component
{
    public $amazon_email = '';
    public $amazon_password = '';
    public $anti_csrf_token_a2z = '';
    public $cookie = '';
    public $x_csrf_token = '';

    public function mount()
    {
        $settings = auth()->user()->amazonSetting;

        if ($settings) {
            $this->amazon_email = $settings->amazon_email ?? '';
            $this->amazon_password = $settings->amazon_password ?? '';
            $this->anti_csrf_token_a2z = $settings->anti_csrf_token_a2z ?? '';
            $this->cookie = $settings->cookie ?? '';
            $this->x_csrf_token = $settings->x_csrf_token ?? '';
        }
    }

    public function save()
    {
        $this->validate([
            'amazon_email' => 'required|email',
            'amazon_password' => 'required|string|min:6',
            'anti_csrf_token_a2z' => 'nullable|string',
            'cookie' => 'nullable|string',
            'x_csrf_token' => 'nullable|string',
        ]);

        AmazonSetting::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'amazon_email' => $this->amazon_email,
                'amazon_password' => $this->amazon_password,
                'anti_csrf_token_a2z' => $this->anti_csrf_token_a2z,
                'cookie' => $this->cookie,
                'x_csrf_token' => $this->x_csrf_token,
            ]
        );

        session()->flash('message', 'Amazon settings saved successfully!');
    }

    public function loginToAmazon()
    {
        $this->validate([
            'amazon_email' => 'required|email',
            'amazon_password' => 'required|string|min:6',
        ]);

        try {
            $apiService = new \App\Services\AmazonApiService(new AmazonSetting());
            $loginResult = $apiService->loginAndGetCredentials($this->amazon_email, $this->amazon_password);

            if ($loginResult) {
                $this->anti_csrf_token_a2z = $loginResult['anti_csrf_token_a2z'] ?? '';
                $this->cookie = $loginResult['cookie'] ?? '';
                $this->x_csrf_token = $loginResult['x_csrf_token'] ?? '';

                // Update the save method to include access_token
                AmazonSetting::updateOrCreate(
                    ['user_id' => auth()->id()],
                    [
                        'amazon_email' => $this->amazon_email,
                        'amazon_password' => $this->amazon_password,
                        'anti_csrf_token_a2z' => $this->anti_csrf_token_a2z,
                        'cookie' => $this->cookie,
                        'x_csrf_token' => $this->x_csrf_token,
                        'access_token' => $loginResult['access_token'] ?? '',
                    ]
                );

                session()->flash('message', 'Successfully logged in and retrieved Amazon credentials!');
            } else {
                session()->flash('error', 'Failed to login to Amazon. Please check your credentials.');
            }
        } catch (\Exception $e) {
            \Log::error('Amazon login error in component', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Login failed: ' . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.amazon-settings');
    }
}
