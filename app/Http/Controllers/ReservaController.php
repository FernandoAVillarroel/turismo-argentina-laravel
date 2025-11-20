<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las reservas de la base de datos
        $reservas = Reserva::all();
        
        // Devolver las reservas como JSON
        return response()->json($reservas);
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
        // Buscar la reserva por ID
        $reserva = Reserva::find($id);
        
        // Si no existe, devolver error 404
        if (!$reserva) {
            return response()->json([
                'error' => 'Reserva no encontrada'
            ], 404);
        }
        
        // Si existe, devolverla como JSON
        return response()->json($reserva);
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