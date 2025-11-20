<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'package_id',
        'booking_date',
        'start_date',
        'number_of_people',
        'total_price',
        'status',
        'special_requests'
    ];

    // Relación: Una reserva pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Una reserva pertenece a un paquete
    public function paquete()
    {
        return $this->belongsTo(Paquete::class, 'package_id');
    }
}