<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('destinations_images')->insert([
            // Fotos de Cataratas del Iguazú (destination_id: 1)
            [
                'destination_id' => 1,
                'image_path' => 'https://ejemplo.com/cataratas1.jpg',
                'caption' => 'Vista panorámica de las Cataratas',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'destination_id' => 1,
                'image_path' => 'https://ejemplo.com/cataratas2.jpg',
                'caption' => 'Garganta del Diablo',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Fotos de Glaciar Perito Moreno (destination_id: 2)
            [
                'destination_id' => 2,
                'image_path' => 'https://ejemplo.com/glaciar1.jpg',
                'caption' => 'Frente del Glaciar',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'destination_id' => 2,
                'image_path' => 'https://ejemplo.com/glaciar2.jpg',
                'caption' => 'Desprendimiento de hielo',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Fotos de Buenos Aires (destination_id: 3)
            [
                'destination_id' => 3,
                'image_path' => 'https://ejemplo.com/bsas1.jpg',
                'caption' => 'Obelisco de Buenos Aires',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}