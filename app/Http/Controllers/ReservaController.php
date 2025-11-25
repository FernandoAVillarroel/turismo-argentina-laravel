<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReservaController extends Controller
{
    /**
     * Listar todas las reservas
     */
    public function index(): JsonResponse
    {
        try {
            $reservas = Reserva::with(['cliente', 'paquete.destino'])->get();
            
            return response()->json([
                'success' => true,
                'data' => $reservas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las reservas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nueva reserva
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'package_id' => 'required|exists:packages,id',
                'booking_code' => 'nullable|string|max:255|unique:bookings,booking_code',
                'booking_date' => 'required|date',
                'travel_date' => 'required|date|after_or_equal:today',
                'return_date' => 'nullable|date|after:travel_date',
                'number_of_adults' => 'required|integer|min:1',
                'number_of_children' => 'nullable|integer|min:0',
                'total_price' => 'required|numeric|min:0',
                'status' => 'required|in:pending,confirmed,cancelled,completed',
                'payment_status' => 'nullable|in:pending,paid,refunded',
                'payment_method' => 'nullable|string|max:255',
                'special_requests' => 'nullable|string'
            ]);

            // Auto-generar booking_code si no se proporciona
            if (empty($validated['booking_code'])) {
                $validated['booking_code'] = 'BK-' . strtoupper(uniqid());
            }

            $reserva = Reserva::create($validated);
            $reserva->load(['cliente', 'paquete.destino']);

            return response()->json([
                'success' => true,
                'message' => 'Reserva creada exitosamente',
                'data' => $reserva
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la reserva',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar una reserva específica
     */
    public function show(string $id): JsonResponse
    {
        try {
            $reserva = Reserva::with(['cliente', 'paquete.destino'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $reserva
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reserva no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la reserva',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar una reserva
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $reserva = Reserva::findOrFail($id);

            $validated = $request->validate([
                'user_id' => 'sometimes|required|exists:users,id',
                'package_id' => 'sometimes|required|exists:packages,id',
                'booking_code' => 'sometimes|nullable|string|max:255|unique:bookings,booking_code,' . $id,
                'booking_date' => 'sometimes|required|date',
                'travel_date' => 'sometimes|required|date',
                'return_date' => 'nullable|date|after:travel_date',
                'number_of_adults' => 'sometimes|required|integer|min:1',
                'number_of_children' => 'nullable|integer|min:0',
                'total_price' => 'sometimes|required|numeric|min:0',
                'status' => 'sometimes|required|in:pending,confirmed,cancelled,completed',
                'payment_status' => 'nullable|in:pending,paid,refunded',
                'payment_method' => 'nullable|string|max:255',
                'special_requests' => 'nullable|string'
            ]);

            $reserva->update($validated);
            $reserva->load(['cliente', 'paquete.destino']);

            return response()->json([
                'success' => true,
                'message' => 'Reserva actualizada exitosamente',
                'data' => $reserva
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reserva no encontrada'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la reserva',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una reserva
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $reserva = Reserva::findOrFail($id);
            
            // Solo permitir eliminar si está en estado pendiente
            if ($reserva->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar reservas en estado pendiente'
                ], 409);
            }

            $reserva->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reserva eliminada exitosamente'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reserva no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la reserva',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}