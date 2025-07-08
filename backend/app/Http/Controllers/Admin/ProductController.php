<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('category', 'images')->get();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'description' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
                'images.*' => 'image|max:10240',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
        

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        return response()->json($product->load('category', 'images'), 201);
    }

    public function show(string $id)
    {
        $product = Product::with('category', 'images')->findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|max:2048',
        ]);

        $product->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        return response()->json($product->load('category', 'images'));
    }


    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Удалить изображения
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}
