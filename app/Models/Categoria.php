<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description'
    ];

    // Relación: Una categoría tiene muchos paquetes
    public function paquetes()
    {
        return $this->hasMany(Paquete::class, 'category_id');
    }

    // Relación: Una categoría tiene muchos destinos (si destination tiene category_id)
    public function destinos()
    {
        return $this->hasMany(Destino::class, 'category_id');
    }
}