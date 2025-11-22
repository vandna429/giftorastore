<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/products', [ProductController::class, 'indexFrontend'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'showFrontend'])->name('products.show');

// Static pages
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/about', 'pages.about')->name('about');

/*
|--------------------------------------------------------------------------
| CART ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{slug}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{slug}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{slug}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('cart.processCheckout');

/*
|--------------------------------------------------------------------------
| ADMIN LOGIN (SESSION BASED, HARD-CODED)
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', function () {
    return view('admin.login'); // Create resources/views/admin/login.blade.php
})->name('admin.login');

Route::post('/admin/login', function (Request $request) {
    $email = $request->email;
    $password = $request->password;

    // Hardcoded admin credentials
    if ($email === 'admin@example.com' && $password === 'password123') {
        session(['admin_logged_in' => true]);
        return redirect()->route('admin.dashboard');
    }

    return back()->with('error', 'Invalid email or password!');
})->name('admin.login.submit');

Route::get('/admin/logout', function () {
    session()->forget('admin_logged_in');
    return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
})->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (SESSION PROTECTED)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Please login first!');
        }
        return app(AdminProductController::class)->index();
    })->name('admin.dashboard');

    // Products CRUD
    Route::get('/products', function () {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Please login first!');
        }
        return app(AdminProductController::class)->index();
    })->name('admin.products.index');

    Route::get('/products/create', function () {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Please login first!');
        }
        return app(AdminProductController::class)->create();
    })->name('admin.products.create');

    Route::post('/products', function (Request $request) {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Please login first!');
        }
        return app(AdminProductController::class)->store($request);
    })->name('admin.products.store');

    Route::get('/products/{id}/edit', function ($id) {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Please login first!');
        }
        return app(AdminProductController::class)->edit($id);
    })->name('admin.products.edit');

    Route::put('/products/{id}', function (Request $request, $id) {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Please login first!');
        }
        return app(AdminProductController::class)->update($request, $id);
    })->name('admin.products.update');

    Route::delete('/products/{id}', function ($id) {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Please login first!');
        }
        return app(AdminProductController::class)->destroy($id);
    })->name('admin.products.destroy');
});
