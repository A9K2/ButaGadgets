<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
->name('index');


// Товари 
Route::get('/phones', function(){
    return view ('products/phones');
})->name('phones');

Route::get('/laptops', function(){
    return view ('products/laptops');
})->name('laptops');

Route::get('/gaming', function(){
    return view ('products/gaming');
})->name('gaming');

Route::get('/home', function(){
    return view ('products/home');
})->name('home');

Route::get('/householdAppliances', function(){
    return view ('products/householdAppliances');
})->name('householdAppliances');

// Реєстрація
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Вхід  
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login']);

//Вихід
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('products', AdminProductController::class);

        Route::resource('comments', AdminReviewController::class);

        Route::resource('users', AdminUserController::class);

    });