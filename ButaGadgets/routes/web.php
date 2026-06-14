<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminProductController,
    AdminReviewController,
    AdminUserController,
    AdminDirectoryController,
    AdminSpecificationController,
    AdminBannerController
};
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/category/{id}', [App\Http\Controllers\HomeController::class, 'category'])->name('category.show');
Route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');


Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});


Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('products', AdminProductController::class);
        Route::resource('comments', AdminReviewController::class);
        Route::resource('users', AdminUserController::class);

        Route::prefix('directories')->name('directories.')->group(function () {

            Route::get('/', [AdminDirectoryController::class, 'index'])->name('index');
        
            Route::post('/brands', [AdminDirectoryController::class, 'storeBrand'])
                ->name('brands.store');
        
            Route::delete('/brands/{id}', [AdminDirectoryController::class, 'destroyBrand'])
                ->name('brands.destroy');
            Route::post('/categories', [AdminDirectoryController::class, 'storeCategory'])
                ->name('categories.store');
        
            Route::delete('/categories/{id}', [AdminDirectoryController::class, 'destroyCategory'])
                ->name('categories.destroy');

            Route::post('/subcategories', [AdminDirectoryController::class, 'storeSubcategory'])
                ->name('subcategories.store');
        
            Route::delete('/subcategories/{id}', [AdminDirectoryController::class, 'destroySubcategory'])
                ->name('subcategories.destroy');
        });

        Route::prefix('specifications')->name('specifications.')->group(function () {
            Route::get('/', [AdminSpecificationController::class, 'index'])->name('index');
            Route::post('/attribute/{id}', [AdminSpecificationController::class, 'storeAttribute'])->name('attribute.store');
            Route::post('/value/{attributeId}', [AdminSpecificationController::class, 'storeValue'])->name('value.store');
            Route::delete('/destroy/{id}', [AdminSpecificationController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('banners')->name('banners.')->group(function () {
            Route::get('/', [AdminBannerController::class, 'index'])->name('index');
            Route::post('/', [AdminBannerController::class, 'store'])->name('store');
            Route::delete('/{id}', [AdminBannerController::class, 'destroy'])->name('destroy');
        });
    });