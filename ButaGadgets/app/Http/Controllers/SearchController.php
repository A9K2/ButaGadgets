<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    public function index()
    {
        $query = request('q', '');
        $categories = Category::all();

        $products = Product::with('images')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->paginate(12)
            ->withQueryString();

        return view('search', compact('products', 'query', 'categories'));
    }
}