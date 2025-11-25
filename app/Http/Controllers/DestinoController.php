<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DestinoController extends Controller
{
    /**
     * Listar todos los destinos
     */
    public function index(): JsonResponse
    {
        try {
            $destinos = Destino::with(['fotos', 'paquetes'])
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $destinos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los destinos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo destino
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:destination,slug',
                'country' => 'required|string|max:100',
                'city' => 'required|string|max:100',
                'description' => 'required|string',
                'short_description' => 'nullable|string|max:500',
                'featured_image' => 'nullable|string|max:255',
                'gallery' => 'nullable|array',
                'highlights' => 'nullable|array',
                'best_time_to_visit' => 'nullable|string|max:100',
                'is_active' => 'boolean'
            ]);

            // Auto-generar slug si no se proporciona
            if (empty($validated['slug'])) {
                $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
            }

            $destino = Destino::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Destino creado exitosamente',
                'data' => $destino
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
                'message' => 'Error al crear el destino',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un destino específico
     */
    public function show(string $id): JsonResponse
    {
        try {
           $destino = Destino::with(['fotos', 'paquetes.comentarios'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $destino
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Destino no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el destino',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un destino
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $destino = Destino::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'slug' => 'sometimes|nullable|string|max:255|unique:destination,slug,' . $id,
                'country' => 'sometimes|required|string|max:100',
                'city' => 'sometimes|required|string|max:100',
                'description' => 'sometimes|required|string',
                'short_description' => 'nullable|string|max:500',
                'featured_image' => 'nullable|string|max:255',
                'gallery' => 'nullable|array',
                'highlights' => 'nullable|array',
                'best_time_to_visit' => 'nullable|string|max:100',
                'is_active' => 'boolean'
            ]);

            // Auto-generar slug si se actualiza el nombre
            if (isset($validated['name']) && !isset($validated['slug'])) {
                $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
            }

            $destino->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Destino actualizado exitosamente',
                'data' => $destino
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Destino no encontrado'
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
                'message' => 'Error al actualizar el destino',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un destino
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $destino = Destino::findOrFail($id);
            
            // Verificar si tiene paquetes asociados
            if ($destino->paquetes()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el destino porque tiene paquetes turísticos asociados'
                ], 409);
            }

            $destino->delete();

            return response()->json([
                'success' => true,
                'message' => 'Destino eliminado exitosamente'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Destino no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el destino',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}