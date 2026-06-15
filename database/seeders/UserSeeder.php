<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@cuacatani.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name'     => 'Petani',
            'email'    => 'user@cuacatani.com',
            'password' => Hash::make('password123'),
        ]);
    }
}