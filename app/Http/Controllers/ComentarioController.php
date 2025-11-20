<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los comentarios de la base de datos
        $comentarios = Comentario::all();
        
        // Devolver los comentarios como JSON
        return response()->json($comentarios);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el comentario por ID
        $comentario = Comentario::find($id);
        
        // Si no existe, devolver error 404
        if (!$comentario) {
            return response()->json([
                'error' => 'Comentario no encontrado'
            ], 404);
        }
        
        // Si existe, devolverlo como JSON
        return response()->json($comentario);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}