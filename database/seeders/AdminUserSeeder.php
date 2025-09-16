<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@ddreams.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'role' => 'staff',
                'email' => 'admin@ddreams.com',
                'password' => Hash::make('Letmein123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
