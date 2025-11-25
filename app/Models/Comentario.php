<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'package_id',
        'rating',
        'title',
        'comment',
        'photos',
        'is_verified',
        'is_approved',
        'helpful_count'
    ];

    protected $casts = [
        'rating' => 'integer',
        'photos' => 'array',
        'is_verified' => 'boolean',
        'is_approved' => 'boolean',
        'helpful_count' => 'integer'
    ];

    // Relación: Un comentario pertenece a un paquete
    public function paquete()
    {
        return $this->belongsTo(Paquete::class, 'package_id');
    }

    // Relación: Un comentario pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}