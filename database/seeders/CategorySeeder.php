<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Gunung', 'icon' => '🏔️'],
            ['name' => 'Pantai', 'icon' => '🏖️'],
            ['name' => 'Budaya', 'icon' => '🏛️'],
            ['name' => 'Kuliner', 'icon' => '🍜'],
            ['name' => 'Alam', 'icon' => '🌲'],
            ['name' => 'Sejarah', 'icon' => '📜'],
            ['name' => 'Petualangan', 'icon' => '🧗'],
            ['name' => 'Religi', 'icon' => '🕌'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}