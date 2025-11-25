<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaqueteController extends Controller
{
    /**
     * Listar todos los paquetes
     */
    public function index(): JsonResponse
    {
        try {
            $paquetes = Paquete::with(['destino', 'categoria', 'reservas', 'comentarios'])->get();
            
            return response()->json([
                'success' => true,
                'data' => $paquetes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los paquetes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo paquete
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'destination_id' => 'required|exists:destination,id',
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:packages,slug',
                'description' => 'required|string',
                'duration_days' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'included_services' => 'nullable|array',
                'excluded_services' => 'nullable|array',
                'itinerary' => 'nullable|array',
                'max_people' => 'nullable|integer|min:1',
                'min_people' => 'nullable|integer|min:1',
                'available_spots' => 'nullable|integer|min:0',
                'difficulty_level' => 'nullable|in:easy,moderate,challenging,difficult',
                'is_featured' => 'boolean',
                'is_active' => 'boolean'
            ]);

            // Auto-generar slug si no se proporciona
            if (empty($validated['slug'])) {
                $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);
            }

            $paquete = Paquete::create($validated);
            $paquete->load(['destino', 'categoria']);

            return response()->json([
                'success' => true,
                'message' => 'Paquete creado exitosamente',
                'data' => $paquete
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
                'message' => 'Error al crear el paquete',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un paquete específico
     */
    public function show(string $id): JsonResponse
    {
        try {
            $paquete = Paquete::with(['destino', 'categoria', 'reservas', 'comentarios.usuario'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $paquete
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Paquete no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el paquete',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un paquete
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $paquete = Paquete::findOrFail($id);

            $validated = $request->validate([
                'destination_id' => 'sometimes|required|exists:destination,id',
                'category_id' => 'sometimes|required|exists:categories,id',
                'title' => 'sometimes|required|string|max:255',
                'slug' => 'sometimes|nullable|string|max:255|unique:packages,slug,' . $id,
                'description' => 'sometimes|required|string',
                'duration_days' => 'sometimes|required|integer|min:1',
                'price' => 'sometimes|required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'included_services' => 'nullable|array',
                'excluded_services' => 'nullable|array',
                'itinerary' => 'nullable|array',
                'max_people' => 'nullable|integer|min:1',
                'min_people' => 'nullable|integer|min:1',
                'available_spots' => 'nullable|integer|min:0',
                'difficulty_level' => 'nullable|in:easy,moderate,challenging,difficult',
                'is_featured' => 'boolean',
                'is_active' => 'boolean'
            ]);

            // Auto-generar slug si se actualiza el título
            if (isset($validated['title']) && !isset($validated['slug'])) {
                $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);
            }

            $paquete->update($validated);
            $paquete->load(['destino', 'categoria']);

            return response()->json([
                'success' => true,
                'message' => 'Paquete actualizado exitosamente',
                'data' => $paquete
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Paquete no encontrado'
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
                'message' => 'Error al actualizar el paquete',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un paquete
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $paquete = Paquete::findOrFail($id);
            
            // Verificar si tiene reservas asociadas
            if ($paquete->reservas()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el paquete porque tiene reservas asociadas'
                ], 409);
            }

            $paquete->delete();

            return response()->json([
                'success' => true,
                'message' => 'Paquete eliminado exitosamente'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Paquete no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el paquete',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}