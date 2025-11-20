<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DestinoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ReservaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas API Resource - Cada línea crea 7 rutas automáticamente
Route::apiResource('destinos', DestinoController::class);
Route::apiResource('categorias', CategoriaController::class);
Route::apiResource('paquetes', PaqueteController::class);
Route::apiResource('fotos', FotoController::class);
Route::apiResource('comentarios', ComentarioController::class);
Route::apiResource('reservas', ReservaController::class);