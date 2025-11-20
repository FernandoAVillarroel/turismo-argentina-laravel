<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $table = 'packages';

    protected $fillable = [
        'destination_id',
        'category_id',
        'title',
        'slug',
        'description',
        'duration_days',
        'price',
        'discount_price',
        'included_services',
        'excluded_services',
        'itinerary',
        'max_people',
        'min_people',
        'available_spots',
        'difficulty_level',
        'is_featured',
        'is_active'
    ];

    // Relación: Un paquete pertenece a un destino
    public function destino()
    {
        return $this->belongsTo(Destino::class, 'destination_id');
    }

    // Relación: Un paquete pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'category_id');
    }

    // Relación: Un paquete tiene muchas reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'package_id');
    }
}