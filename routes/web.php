<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

// 🏠 Home page
Route::get('/', [PageController::class, 'home'])->name('home');

// 🛍️ Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// 📞 Static pages
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/about', 'pages.about')->name('about');

// 🛒 Cart Routes
Route::post('/cart/add/{slug}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{slug}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');

// 💳 Checkout Routes
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
