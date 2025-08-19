<?php

namespace App\Livewire;

use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DriverDashboard extends Component
{
    public $driver;
    public $completionPercentage = 0;
    public $isProfileComplete = false;

    public function mount()
    {
        $user = Auth::user();
        
        // Redirect if not a driver
        if (!$user->isDriver()) {
            return redirect()->route('dashboard');
        }

        // Get or create driver profile
        $this->driver = $user->driver ?? $user->driver()->create(['user_id' => $user->id]);
        $this->completionPercentage = $this->driver->getCompletionPercentage();
        $this->isProfileComplete = $this->driver->isProfileComplete();
    }

    public function render()
    {
        return view('livewire.driver-dashboard')
            ->layout('components.layouts.app', ['title' => 'Driver Dashboard']);
    }
}
