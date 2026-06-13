<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category; 
use App\Models\Banner;
use App\Models\Product;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // View::composer('index', function ($view) {
        //     $view->with([
        //         'categories'       => Category::all(),
        //         'banners'          => Banner::all(),
        //         'popularProducts'  => Product::latest()->take(4)->get(),
        //         'featuredProducts' => Product::latest()->take(4)->get(),
        //     ]);
        // });

        // Передаємо $categories у ваш компонент сайдбару
        View::composer('components.sidebar.categories', function ($view) {
            $view->with('categories', Category::all
            ());
            
        });
    }
}
