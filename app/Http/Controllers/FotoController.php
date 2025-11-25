<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FotoController extends Controller
{
    /**
     * Listar todas las fotos
     */
    public function index(): JsonResponse
    {
        try {
            $fotos = Foto::with('destino')->orderBy('order')->get();
            
            return response()->json([
                'success' => true,
                'data' => $fotos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las fotos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nueva foto
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'destination_id' => 'required|exists:destination,id',
                'image_path' => 'required|string|max:255',
                'caption' => 'nullable|string|max:255',
                'order' => 'nullable|integer|min:0'
            ]);

            $foto = Foto::create($validated);
            $foto->load('destino');

            return response()->json([
                'success' => true,
                'message' => 'Foto creada exitosamente',
                'data' => $foto
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
                'message' => 'Error al crear la foto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar una foto específica
     */
    public function show(string $id): JsonResponse
    {
        try {
            $foto = Foto::with('destino')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $foto
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Foto no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la foto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar una foto
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $foto = Foto::findOrFail($id);

            $validated = $request->validate([
                'destination_id' => 'sometimes|required|exists:destination,id',
                'image_path' => 'sometimes|required|string|max:255',
                'caption' => 'nullable|string|max:255',
                'order' => 'nullable|integer|min:0'
            ]);

            $foto->update($validated);
            $foto->load('destino');

            return response()->json([
                'success' => true,
                'message' => 'Foto actualizada exitosamente',
                'data' => $foto
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Foto no encontrada'
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
                'message' => 'Error al actualizar la foto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una foto
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $foto = Foto::findOrFail($id);
            $foto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Foto eliminada exitosamente'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Foto no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la foto',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}