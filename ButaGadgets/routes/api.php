<?php

use Illuminate\Support\Facades\Route;

Route::get('/products/search', function(\Illuminate\Http\Request $request) {
    $q = $request->q ?? '';
    $words = array_filter(explode(' ', $q));

    $products = \App\Models\Product::with(['brand', 'category', 'images'])
        ->where(function($query) use ($words) {
            foreach ($words as $word) {
                $query->where(function($q) use ($word) {
                    $q->where('name', 'like', "%{$word}%")
                      ->orWhere('description', 'like', "%{$word}%")
                      ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$word}%"))
                      ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$word}%"));
                });
            }
        })
        ->take(5)
        ->get()
        ->map(fn($p) => [
            'name'     => $p->name,
            'price'    => number_format($p->price, 0) . ' грн',
            'category' => $p->category->name ?? '',
            'brand'    => $p->brand->name ?? '',
            'url'      => url('/products/' . $p->id),
            'in_stock' => $p->quantity > 0 ? 'В наявності' : 'Немає в наявності',
        ]);

    return response()->json($products, 200, [], JSON_UNESCAPED_UNICODE);
});