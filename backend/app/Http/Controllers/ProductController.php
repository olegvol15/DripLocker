<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Получить все товары, или отфильтрованные по категории
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        return response()->json($query->get());
    }

    // Показать один товар
    public function show($id)
    {
        return Product::with('category', 'images')->findOrFail($id);
    }

    // Создание нового товара
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);
    
        $product = Product::create($validated);
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path]);
            }
        }
    
        return response()->json($product->load('images'), 201);
    }

    // Обновление товара
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'category_id' => 'sometimes|exists:categories,id',
            'description' => 'sometimes|string',
            'image' => 'sometimes|string',
        ]);

        $product->update($data);
        return response()->json($product);
    }

    // Удаление товара
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function search(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('brand')) {
            $brand = strtolower($request->brand);
            $brandSingular = Str::singular($brand);
            $brandPlural = Str::plural($brand);

            $query->where(function ($q) use ($brand, $brandSingular, $brandPlural) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%$brand%"])
                ->orWhereRaw('LOWER(name) LIKE ?', ["%$brandSingular%"])
                ->orWhereRaw('LOWER(name) LIKE ?', ["%$brandPlural%"]);
            });
        }

        if ($request->has('type')) {
            $type = strtolower($request->type);
            $typeSingular = Str::singular($type);
            $typePlural = Str::plural($type);

            $query->where(function ($q) use ($type, $typeSingular, $typePlural) {
                $q->whereRaw('LOWER(description) LIKE ?', ["%$type%"])
                ->orWhereRaw('LOWER(description) LIKE ?', ["%$typeSingular%"])
                ->orWhereRaw('LOWER(description) LIKE ?', ["%$typePlural%"]);
            });
        }

        return response()->json($query->get());
    }

}


