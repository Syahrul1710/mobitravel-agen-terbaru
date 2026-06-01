<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Agent;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first agent, or create one if none exists
        $agent = Agent::first();
        
        if (!$agent) {
            $agent = Agent::create([
                'nik' => '1234567890123456',
                'agency_name' => 'Travel Agent Indonesia',
                'email' => 'agent@mobitravel.com',
                'password' => bcrypt('password123'),
                'phone' => '0812-3456-7890',
                'whatsapp' => '0812-3456-7890',
                'address' => 'Jln. Wisata No. 123, Jakarta',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'status' => 'verified',
                'verified_at' => now(),
            ]);
        }

        // Create sample destinations
        $destinations = [
            [
                'name' => 'Pantai Kuta',
                'slug' => 'pantai-kuta',
                'description' => 'Pantai indah dengan pasir putih dan ombak yang cocok untuk surfing',
                'location' => 'Denpasar, Bali',
            ],
            [
                'name' => 'Gunung Bromo',
                'slug' => 'gunung-bromo',
                'description' => 'Gunung berapi aktif dengan pemandangan yang spektakuler di Taman Nasional Bromo Tengger Semeru',
                'location' => 'Probolinggo, Jawa Timur',
            ],
            [
                'name' => 'Candi Borobudur',
                'slug' => 'candi-borobudur',
                'description' => 'Candi Buddha terbesar di dunia dengan arsitektur yang menakjubkan',
                'location' => 'Magelang, Jawa Tengah',
            ],
            [
                'name' => 'Raja Ampat',
                'slug' => 'raja-ampat',
                'description' => 'Kepulauan eksotis dengan keanekaragaman hayati laut terbaik di dunia',
                'location' => 'Waisai, Papua Barat',
            ],
            [
                'name' => 'Tana Toraja',
                'slug' => 'tana-toraja',
                'description' => 'Daerah dengan budaya unik dan tradisi pemakaman yang menarik',
                'location' => 'Rantepao, Sulawesi Selatan',
            ],
        ];

        foreach ($destinations as $dest) {
            Destination::updateOrCreate(
                ['slug' => $dest['slug']],
                [
                    'agent_id' => $agent->id,
                    ...$dest
                ]
            );
        }
    }
}
