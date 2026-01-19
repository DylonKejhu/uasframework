<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create owner account
        User::create([
            'name' => 'Owner',
            'email' => 'keju@keju.com',
            'password' => Hash::make('rawr'),
            'role' => 'owner',
        ]);

        // Create admin account
        User::create([
            'name' => 'Admin',
            'email' => 'admin@paramfresh.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create regular user account
        User::create([
            'name' => 'User',
            'email' => 'user@paramfresh.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}