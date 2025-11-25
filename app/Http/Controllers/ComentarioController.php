<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ComentarioController extends Controller
{
    /**
     * Listar todos los comentarios
     */
    public function index(): JsonResponse
    {
        try {
            $comentarios = Comentario::with(['paquete.destino', 'usuario'])->get();
            
            return response()->json([
                'success' => true,
                'data' => $comentarios
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los comentarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo comentario
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'package_id' => 'required|exists:packages,id',
                'rating' => 'required|integer|min:1|max:5',
                'title' => 'nullable|string|max:255',
                'comment' => 'required|string',
                'photos' => 'nullable|array',
                'is_verified' => 'boolean',
                'is_approved' => 'boolean'
            ]);

            $comentario = Comentario::create($validated);
            $comentario->load(['paquete', 'usuario']);

            return response()->json([
                'success' => true,
                'message' => 'Comentario creado exitosamente',
                'data' => $comentario
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
                'message' => 'Error al crear el comentario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un comentario específico
     */
    public function show(string $id): JsonResponse
    {
        try {
            $comentario = Comentario::with(['paquete.destino', 'usuario'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $comentario
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Comentario no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el comentario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un comentario
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $comentario = Comentario::findOrFail($id);

            $validated = $request->validate([
                'user_id' => 'sometimes|required|exists:users,id',
                'package_id' => 'sometimes|required|exists:packages,id',
                'rating' => 'sometimes|required|integer|min:1|max:5',
                'title' => 'nullable|string|max:255',
                'comment' => 'sometimes|required|string',
                'photos' => 'nullable|array',
                'is_verified' => 'boolean',
                'is_approved' => 'boolean',
                'helpful_count' => 'nullable|integer|min:0'
            ]);

            $comentario->update($validated);
            $comentario->load(['paquete', 'usuario']);

            return response()->json([
                'success' => true,
                'message' => 'Comentario actualizado exitosamente',
                'data' => $comentario
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Comentario no encontrado'
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
                'message' => 'Error al actualizar el comentario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un comentario
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $comentario = Comentario::findOrFail($id);
            $comentario->delete();

            return response()->json([
                'success' => true,
                'message' => 'Comentario eliminado exitosamente'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Comentario no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el comentario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}