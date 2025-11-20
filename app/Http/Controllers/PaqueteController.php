<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Paquete;
use Illuminate\Http\Request;

class PaqueteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los paquetes de la base de datos
        $paquetes = Paquete::all();
        
        // Devolver los paquetes como JSON
        return response()->json($paquetes);
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
        // Buscar el paquete por ID
        $paquete = Paquete::find($id);
        
        // Si no existe, devolver error 404
        if (!$paquete) {
            return response()->json([
                'error' => 'Paquete no encontrado'
            ], 404);
        }
        
        // Si existe, devolverlo como JSON
        return response()->json($paquete);
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