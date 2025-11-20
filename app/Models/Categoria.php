<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categories';

    // Cambiar a inglés
    protected $fillable = [
        'name',        // ← Cambió de 'nombre'
        'slug',
        'icon',
        'description'  // ← Cambió de 'descripcion'
    ];

    public function paquetes()
    {
        return $this->hasMany(Paquete::class, 'categoria_id');
    }
}