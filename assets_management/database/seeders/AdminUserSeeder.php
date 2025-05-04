<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Create student user
        User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'role' => 'student',
            'password' => Hash::make('password'),
        ]);
    }
}