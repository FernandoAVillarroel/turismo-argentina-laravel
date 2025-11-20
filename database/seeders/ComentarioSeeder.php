<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            // Comentarios del Paquete 1 (Escapada a las Cataratas)
            [
                'user_id' => 1,
                'package_id' => 1,
                'rating' => 5,
                'title' => 'Experiencia inolvidable',
                'comment' => '¡Increíble experiencia! Las cataratas son aún más impresionantes en persona. Totalmente recomendable.',
                'photos' => null,
                'is_verified' => true,
                'is_approved' => true,
                'helpful_count' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'package_id' => 1,
                'rating' => 5,
                'title' => 'Maravilla natural',
                'comment' => 'Una maravilla natural que todos deberían ver al menos una vez en la vida.',
                'photos' => null,
                'is_verified' => true,
                'is_approved' => true,
                'helpful_count' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Comentario del Paquete 2 (Glaciar Perito Moreno)
            [
                'user_id' => 1,
                'package_id' => 2,
                'rating' => 5,
                'title' => 'Espectacular',
                'comment' => 'Espectacular. Ver el desprendimiento de hielo fue inolvidable.',
                'photos' => null,
                'is_verified' => true,
                'is_approved' => true,
                'helpful_count' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Comentario del Paquete 3 (Buenos Aires)
            [
                'user_id' => 2,
                'package_id' => 3,
                'rating' => 4,
                'title' => 'Ciudad hermosa',
                'comment' => 'Ciudad hermosa con mucha vida cultural. La comida es excelente.',
                'photos' => null,
                'is_verified' => true,
                'is_approved' => true,
                'helpful_count' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Comentario del Paquete 4 (Bariloche)
            [
                'user_id' => 1,
                'package_id' => 4,
                'rating' => 5,
                'title' => 'Paisajes increíbles',
                'comment' => 'Paisajes de montaña increíbles y el chocolate es delicioso. Perfecto para vacaciones.',
                'photos' => null,
                'is_verified' => true,
                'is_approved' => true,
                'helpful_count' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}