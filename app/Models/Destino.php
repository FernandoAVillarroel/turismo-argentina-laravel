<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $table = 'destination';

    protected $fillable = [
        'name',
        'slug',
        'country',
        'city',
        'description',
        'short_description',
        'featured_image',
        'gallery',
        'highlights',
        'best_time_to_visit',
        'is_active'
    ];

    // Relación: Un destino tiene muchos paquetes
    public function paquetes()
    {
        return $this->hasMany(Paquete::class, 'destination_id');
    }

    // Relación: Un destino tiene muchas fotos
    public function fotos()
    {
        return $this->hasMany(Foto::class, 'destination_id');
    }

    // Relación: Un destino tiene muchos comentarios (reviews)
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'destination_id');
    }
}