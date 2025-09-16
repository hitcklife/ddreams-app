<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SimpleAuthController extends Controller
{
    public function showLogin()
    {
        return view('simple-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Try to find user by email
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.'])->withInput();
        }

        // Check password
        if (!Hash::check($password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid password.'])->withInput();
        }

        // Manually log in the user
        Auth::login($user, $request->has('remember'));

        // Redirect to dashboard
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/simple-login');
    }

    public function createTestUser()
    {
        // Create a test user if it doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'test@test.com'],
            [
                'first_name' => 'Test',
                'last_name' => 'User',
                'role' => 'staff',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        return response()->json([
            'message' => 'Test user created/verified',
            'email' => 'test@test.com',
            'password' => 'password123'
        ]);
    }
}
