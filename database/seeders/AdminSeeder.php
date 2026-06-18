<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@bpa.telkomuniversity.ac.id'],
            [
                'name' => 'Petugas BPA',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
    }
}