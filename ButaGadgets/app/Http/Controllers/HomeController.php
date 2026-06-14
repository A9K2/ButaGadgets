<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
{
    $banners = Banner::where('is_active', true)->orderBy('sort_order')->get();

    $popularProducts  = Product::with('images')->where('is_popular', true)->latest()->take(4)->get();
    $actionProducts   = Product::with('images')->where('is_action', true)->latest()->take(4)->get();
    $categories       = Category::all();
    $featuredProducts = Product::with('images')->limit(3)->get();
    $products         = Product::with('images')->paginate(12);

    return view('index', compact('banners', 'popularProducts', 'actionProducts', 'categories', 'products', 'featuredProducts'));
}

public function category($id)
{
    $category  = \App\Models\Category::findOrFail($id);
    $minPrice  = request('min_price');
    $maxPrice  = request('max_price');
    $sort      = request('sort', 'newest');
    $brandIds  = request('brands', []);
    $attrFilter = request('attrs', []);

    $query = Product::with('images')->where('category_id', $id);

    if ($minPrice) $query->where('price', '>=', $minPrice);
    if ($maxPrice) $query->where('price', '<=', $maxPrice);
    if (!empty($brandIds)) $query->whereIn('brand_id', $brandIds);

    foreach ($attrFilter as $attributeId => $valueIds) {
        $valueIds = array_filter((array) $valueIds);
        if (!empty($valueIds)) {
            $query->whereHas('attributeValues', function($q) use ($attributeId, $valueIds) {
                $q->where('attribute_id', $attributeId)
                  ->whereIn('attribute_value_id', $valueIds);
            });
        }
    }

    match($sort) {
        'price_asc'  => $query->orderBy('price', 'asc'),
        'price_desc' => $query->orderBy('price', 'desc'),
        default      => $query->latest(),
    };

    $products   = $query->paginate(12)->withQueryString();
    $categories = \App\Models\Category::all();
    $priceMin   = Product::where('category_id', $id)->min('price');
    $priceMax   = Product::where('category_id', $id)->max('price');

    $brands = \App\Models\Brand::whereHas('products', function($q) use ($id) {
        $q->where('category_id', $id);
    })->get();

    $filterAttributes = \App\Models\Attribute::whereHas('values', function($q) use ($id) {
        $q->whereHas('productAttributeValues', function($pav) use ($id) {
            $pav->whereHas('product', fn($p) => $p->where('category_id', $id));
        });
    })->with(['values' => function($q) use ($id) {
        $q->whereHas('productAttributeValues', function($pav) use ($id) {
            $pav->whereHas('product', fn($p) => $p->where('category_id', $id));
        });
    }])->get();
    
    return view('category', compact(
        'category', 'products', 'categories',
        'brands', 'brandIds', 'priceMin', 'priceMax', 'sort',
        'filterAttributes', 'attrFilter' 
    ));
    
    return view('category', compact(
        'category', 'products', 'categories',
        'brands', 'brandIds', 'priceMin', 'priceMax', 'sort',
        'attributes', 'attrFilter'
    ));
}
}
