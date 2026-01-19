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
            'email' => 'admin@keju.com',
            'password' => Hash::make('rawr'),
            'role' => 'admin',
        ]);

        // Kelompok 1
        User::create([
            'name' => 'Kelompok 1',
            'email' => 'kelompok@1.com',
            'password' => Hash::make('kelompok'),
            'role' => 'user',
        ]);

        // Kelompok 3
        User::create([
            'name' => 'Kelompok 3',
            'email' => 'kelompok@3.com',
            'password' => Hash::make('kelompok'),
            'role' => 'user',
        ]);

        // Kelompok 4
        User::create([
            'name' => 'Kelompok 4',
            'email' => 'kelompok@4.com',
            'password' => Hash::make('kelompok'),
            'role' => 'user',
        ]);

        // Kelompok 5
        User::create([
            'name' => 'Kelompok 5',
            'email' => 'kelompok@5.com',
            'password' => Hash::make('kelompok'),
            'role' => 'user',
        ]);
        // Kelompok 6
        User::create([
            'name' => 'Kelompok 6',
            'email' => 'kelompok@6.com',
            'password' => Hash::make('kelompok'),
            'role' => 'user',
        ]);
        // Kelompok 7
        User::create([
            'name' => 'Kelompok 7',
            'email' => 'kelompok@7.com',
            'password' => Hash::make('kelompok'),
            'role' => 'user',
        ]);
        // Kelompok 8
        User::create([
            'name' => 'Kelompok 8',
            'email' => 'kelompok@8.com',
            'password' => Hash::make('kelompok'),
            'role' => 'user',
        ]);
    }
}