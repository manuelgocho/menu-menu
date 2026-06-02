<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Product::where('is_active', true)
                ->orderBy('category')
                ->get(),
            'message' => 'Productos obtenidos exitosamente'
        ]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_usd' => 'required|numeric|min:0',
            'price_bs' => 'nullable|numeric|min:0',
            'category' => 'required|string|max:100',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Producto creado exitosamente'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price_usd' => 'sometimes|numeric|min:0',
            'price_bs' => 'nullable|numeric|min:0',
            'category' => 'sometimes|string|max:100',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $product->update($validated);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Producto actualizado exitosamente'
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente'
        ]);
    }

    public function byCategory($category)
    {
        return response()->json([
            'success' => true,
            'data' => Product::where('category', $category)
                ->where('is_active', true)
                ->get(),
            'message' => "Productos de la categoría '{$category}' obtenidos"
        ]);
    }
}
