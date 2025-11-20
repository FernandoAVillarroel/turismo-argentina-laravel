<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bookings')->insert([
            // Reserva 1: Escapada a las Cataratas (package_id: 1)
            [
                'user_id' => 1,
                'package_id' => 1,
                'booking_code' => 'BK-2025-001',
                'booking_date' => now(),
                'travel_date' => now()->addDays(30),
                'return_date' => now()->addDays(33),
                'number_of_adults' => 2,
                'number_of_children' => 0,
                'total_price' => 150000.00,
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_method' => 'credit_card',
                'special_requests' => 'Habitación con vista al río',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Reserva 2: Aventura en el Glaciar (package_id: 2)
            [
                'user_id' => 2,
                'package_id' => 2,
                'booking_code' => 'BK-2025-002',
                'booking_date' => now(),
                'travel_date' => now()->addDays(45),
                'return_date' => now()->addDays(49),
                'number_of_adults' => 2,
                'number_of_children' => 2,
                'total_price' => 320000.00,
                'status' => 'confirmed',
                'payment_status' => 'pending',
                'payment_method' => 'bank_transfer',
                'special_requests' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Reserva 3: Buenos Aires Tango & Cultura (package_id: 3)
            [
                'user_id' => 1,
                'package_id' => 3,
                'booking_code' => 'BK-2025-003',
                'booking_date' => now(),
                'travel_date' => now()->addDays(15),
                'return_date' => now()->addDays(20),
                'number_of_adults' => 2,
                'number_of_children' => 0,
                'total_price' => 100000.00,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => null,
                'special_requests' => 'Cena vegetariana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Reserva 4: Bariloche Montaña y Lagos (package_id: 4)
            [
                'user_id' => 2,
                'package_id' => 4,
                'booking_code' => 'BK-2024-099',
                'booking_date' => now()->subDays(60),
                'travel_date' => now()->subDays(30),
                'return_date' => now()->subDays(24),
                'number_of_adults' => 2,
                'number_of_children' => 1,
                'total_price' => 210000.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'payment_method' => 'credit_card',
                'special_requests' => null,
                'created_at' => now()->subDays(60),
                'updated_at' => now()->subDays(30),
            ],
        ]);
    }
}