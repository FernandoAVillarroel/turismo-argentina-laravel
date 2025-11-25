<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'package_id',
        'booking_code',
        'booking_date',
        'travel_date',
        'return_date',
        'number_of_adults',
        'number_of_children',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'special_requests'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'travel_date' => 'date',
        'return_date' => 'date',
        'total_price' => 'decimal:2',
        'number_of_adults' => 'integer',
        'number_of_children' => 'integer'
    ];

    // Relación: Una reserva pertenece a un usuario
    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación: Una reserva pertenece a un paquete
    public function paquete()
    {
        return $this->belongsTo(Paquete::class, 'package_id');
    }
}