<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Change ce mot de passe
            'is_admin' => true,
        ]);

        // Utilisateur normal
        User::create([
            'name' => 'Utilisateur',
            'email' => 'user@example.com',
            'password' => Hash::make('password'), // Change ce mot de passe
            'is_admin' => false,
        ]);
    }
}
