<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Destino;
use Illuminate\Http\Request;

class DestinoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los destinos de la base de datos
        $destinos = Destino::all();
        
        // Devolver los destinos como JSON (para que Vue.js lo use)
        return response()->json($destinos);
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
        // Validar los datos que llegan
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:destination,slug',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'best_time_to_visit' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Crear el nuevo destino en la base de datos
        $destino = Destino::create($validatedData);

        // Devolver el destino creado con código 201 (Created)
        return response()->json($destino, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el destino por ID
        $destino = Destino::find($id);
        
        // Si no existe, devolver error 404
        if (!$destino) {
            return response()->json([
                'error' => 'Destino no encontrado'
            ], 404);
        }
        
        // Si existe, devolverlo como JSON
        return response()->json($destino);
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
        // Buscar el destino por ID
        $destino = Destino::find($id);

        // Si no existe, devolver error 404
        if (!$destino) {
            return response()->json([
                'error' => 'Destino no encontrado'
            ], 404);
        }

        // Validar los datos que llegan
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|unique:destination,slug,' . $id,
            'country' => 'sometimes|required|string|max:100',
            'city' => 'sometimes|required|string|max:100',
            'description' => 'sometimes|required|string',
            'short_description' => 'nullable|string|max:500',
            'best_time_to_visit' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Actualizar el destino
        $destino->update($validatedData);

        // Devolver el destino actualizado
        return response()->json($destino);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar el destino por ID
        $destino = Destino::find($id);

        // Si no existe, devolver error 404
        if (!$destino) {
            return response()->json([
                'error' => 'Destino no encontrado'
            ], 404);
        }

        // Eliminar el destino
        $destino->delete();

        // Devolver respuesta exitosa sin contenido (204)
        return response()->json([
            'message' => 'Destino eliminado exitosamente'
        ], 200);
    }
}    