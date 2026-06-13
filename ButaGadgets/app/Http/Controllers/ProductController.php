<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function show($id)
    {
        $product    = Product::with(['images', 'brand', 'category', 'attributeValues.attribute', 'attributeValues.value'])->findOrFail($id);
        $categories = Category::all();
        $related    = Product::with('images')
                        ->where('category_id', $product->category_id)
                        ->where('id', '!=', $id)
                        ->take(4)
                        ->get();

        return view('product', compact('product', 'categories', 'related'));
    }
}