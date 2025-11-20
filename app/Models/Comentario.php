<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'destination_id',
        'user_id',
        'rating',
        'comment',
        'is_approved'
    ];

    // Relación: Un comentario pertenece a un destino
    public function destino()
    {
        return $this->belongsTo(Destino::class, 'destination_id');
    }

    // Relación: Un comentario pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}