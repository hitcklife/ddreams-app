<?php

use App\Livewire\AmazonAuctions;
use App\Livewire\AmazonSettings;
use App\Livewire\DriverDashboard;
use App\Livewire\DriverProfile;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', function () {
    if (auth()->user()->isDriver()) {
        return redirect()->route('driver.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('amazon', function () {
    return view('amazon');
})->middleware(['auth', 'verified'])->name('amazon');

Route::get('amazon/settings', AmazonSettings::class)->middleware(['auth', 'verified'])->name('amazon.settings');

Route::get('amazon/auctions', AmazonAuctions::class)->middleware(['auth', 'verified'])->name('amazon.auctions');

// Driver Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('driver/dashboard', DriverDashboard::class)->name('driver.dashboard');
    Route::get('driver/profile', DriverProfile::class)->name('driver.profile');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Legal Pages
Route::get('privacy-policy', function () {
    return view('legal.privacy-policy');
})->name('privacy.policy');

Route::get('terms-conditions', function () {
    return view('legal.terms-conditions');
})->name('terms.conditions');

require __DIR__.'/auth.php';
