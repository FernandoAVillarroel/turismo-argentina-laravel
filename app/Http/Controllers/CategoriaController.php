<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\support\Str;


class CategoriaController extends Controller
{
    /**
     * Listar todas las categorías
     */
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }

    /**
     * Crear nueva categoría
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',  
            'slug' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ]);
        $validatedData['slug'] = Str::slug($validatedData['name']);

        $categoria = Categoria::create($validatedData);

        return response()->json([
            'message' => 'Categoría creada exitosamente',
            'data' => $categoria
        ], 201);
    }

    /**
     * Ver una categoría específica
     */
    public function show(string $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        return response()->json($categoria);
    }

    /**
     * Actualizar categoría
     */
    public function update(Request $request, string $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,  // ← Cambió
            'slug' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string'  // ← Cambió
        ]);

        if (isset($validatedData['name'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        $categoria->update($validatedData);

        return response()->json([
            'message' => 'Categoría actualizada exitosamente',
            'data' => $categoria
        ]);
    }

    /**
     * Eliminar categoría
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        $categoria->delete();

        return response()->json([
            'message' => 'Categoría eliminada exitosamente'
        ]);
    }
}