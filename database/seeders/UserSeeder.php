<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin PDAM',
            'email' => 'admin@pdam.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Pelanggan
        User::create([
            'name' => 'Khalisa',
            'email' => 'khalisa@pdam.com',
            'password' => Hash::make('khalisa123'),
            'role' => 'pelanggan',
        ]);
        User::create([
            'name' => 'Angga',
            'email' => 'angga@pdam.com',
            'password' => Hash::make('angga123'),
            'role' => 'pelanggan',
        ]);
    }
}
