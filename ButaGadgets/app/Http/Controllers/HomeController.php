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

        // 2. Популярні товари (Навушники, пралки, PS5 із вашого скріншоту)
        $popularProducts = Product::where('is_popular', true)->latest()->take(4)->get();

        // 3. Акційні товари (із закресленими цінами)
        $actionProducts = Product::where('is_action', true)->latest()->take(4)->get();

        // 4. Категорії для лівого меню
        $categories = Category::all();

        return view('index', compact('banners', 'popularProducts', 'actionProducts', 'categories'));
    }
}
