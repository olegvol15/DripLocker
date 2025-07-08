<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

    public function products($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category->products()->with('category')->get());
    }


    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string']);
        $category = Category::create($data);
        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate(['name' => 'required|string']);
        $category->update($data);
        return response()->json($category);
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}

