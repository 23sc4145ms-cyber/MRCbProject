<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user account
        \App\Models\UserAccount::create([
            'username' => 'admin',
            'email' => 'admin@psu.edu.ph',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create teacher user account
        \App\Models\UserAccount::create([
            'username' => 'teacher',
            'email' => 'teacher@psu.edu.ph',
            'password' => Hash::make('teacher1234'),
            'role' => 'teacher',
            'is_active' => true,
        ]);

    }
}
