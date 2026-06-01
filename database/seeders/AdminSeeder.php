<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah admin sudah ada
        if (Admin::where('email', 'admin@mobitravel.com')->doesntExist()) {
            Admin::create([
                'name' => 'Super Admin',
                'email' => 'admin@mobitravel.com',
                'password' => Hash::make('password123'),
            ]);
        }
    }
}