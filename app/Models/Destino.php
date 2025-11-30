<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $table = 'destination';  // ← SINGULAR

    protected $fillable = [
        // Campos originales en inglés
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
        'is_active',
        // Campos nuevos en español
        'nombre',
        'descripcion',
        'ubicacion',
        'imagen_url',
        'categoria_id'
    ];

    protected $casts = [
        'gallery' => 'array',
        'highlights' => 'array',
        'is_active' => 'boolean'
    ];

    // Relación: Un destino pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

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

    // Relación: Un destino tiene muchos comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'destination_id');
    }
}