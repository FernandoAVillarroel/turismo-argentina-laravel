<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'destinations_images';

    protected $fillable = [
        'destination_id',
        'image_url',
        'caption',
        'is_primary',
        'sort_order'
    ];

    // Relación: Una foto pertenece a un destino
    public function destino()
    {
        return $this->belongsTo(Destino::class, 'destination_id');
    }
}