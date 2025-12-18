<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Products API
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('api.products.index');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('api.products.show');
    Route::get('/category/{categorySlug}', [ProductController::class, 'byCategory'])->name('api.products.byCategory');
    Route::get('/search/{query}', [ProductController::class, 'search'])->name('api.products.search');
    Route::put('/{identifier}/stock', [ProductController::class, 'updateStock'])->name('api.products.updateStock');
    Route::patch('/{identifier}/stock', [ProductController::class, 'updateStock'])->name('api.products.updateStock.patch');
});

// Categories API
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('api.categories.index');
    Route::get('/{slug}', [CategoryController::class, 'show'])->name('api.categories.show');
    Route::get('/{slug}/products', [CategoryController::class, 'products'])->name('api.categories.products');
});

// Orders API
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('api.orders.index');
    Route::get('/{id}', [OrderController::class, 'show'])->name('api.orders.show');
});

