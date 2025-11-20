<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use Illuminate\Http\Request;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las fotos de la base de datos
        $fotos = Foto::all();
        
        // Devolver las fotos como JSON
        return response()->json($fotos);
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
        // Buscar la foto por ID
        $foto = Foto::find($id);
        
        // Si no existe, devolver error 404
        if (!$foto) {
            return response()->json([
                'error' => 'Foto no encontrada'
            ], 404);
        }
        
        // Si existe, devolverla como JSON
        return response()->json($foto);
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