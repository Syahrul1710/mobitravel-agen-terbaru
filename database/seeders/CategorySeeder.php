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
            ['name' => 'Pantai'],
            ['name' => 'Gunung'],
            ['name' => 'Budaya'],
            ['name' => 'Kuliner'],
            ['name' => 'Diving'],
            ['name' => 'Alam'],
            ['name' => 'Sejarah'],
            ['name' => 'Petualangan'],
            ['name' => 'Religi'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}