<?php
namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function index()
    {
        $favoriteIds = auth()->user()->favorites()->pluck('product_id');
        $products    = Product::with('images')->whereIn('id', $favoriteIds)->get();

        return view('favorites', compact('products'));
    }

    public function toggle(Product $product)
    {
        $deleted = Favorite::where('user_id', auth()->id())
                        ->where('product_id', $product->id)
                        ->delete();

        if (!$deleted) {
            Favorite::create([
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
            ]);
        }

        return back();
    }
}