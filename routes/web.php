<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Models\Category;


/*
|-------------------------------------------------------------------------- 
| FRONTEND ROUTES
|-------------------------------------------------------------------------- 
*/

// 🔍 LIVE AJAX SEARCH ROUTE
Route::get('/products/live-search', [ProductController::class, 'liveSearch'])
     ->name('products.liveSearch');

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/products', [ProductController::class, 'indexFrontend'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'showFrontend'])->name('products.show');

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

Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('cart.processCheckout');

/*
|-------------------------------------------------------------------------- 
| ADMIN LOGIN / LOGOUT
|-------------------------------------------------------------------------- 
*/
Route::prefix('admin')->group(function () {

    Route::get('/login', function () {
        return view('admin.login');
    })->name('admin.login');

    Route::post('/login', function (Request $request) {
        $email = $request->email;
        $password = $request->password;

        if ($email === 'admin@example.com' && $password === 'password123') {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid email or password!');
    })->name('admin.login.submit');

    Route::post('/logout', function (Request $request) {
        session()->forget('admin_logged_in');
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    })->name('admin.logout');
    
    // Fallback GET route for logout (redirects to home if accessed directly)
    Route::get('/logout', function () {
        return redirect()->route('home');
    });

});

/*
|-------------------------------------------------------------------------- 
| ADMIN ROUTES (SESSION PROTECTED)
|-------------------------------------------------------------------------- 
*/
Route::prefix('admin')->group(function () {

    // Inline session check for admin
    $checkAdmin = function ($next) {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Please login first!');
        }
        return $next();
    };

    // Dashboard
 

Route::get('/dashboard', function () use ($checkAdmin) {
    return $checkAdmin(function () {
        $categories = Category::all();  // 🔥 Load categories
        return view('admin.dashboard', compact('categories'));
    });
})->name('admin.dashboard');

    /*
    |----------------------------
    | Products CRUD
    |----------------------------
    */
    Route::get('/products', function () use ($checkAdmin) {
        return $checkAdmin(fn() => app(AdminProductController::class)->index());
    })->name('admin.products.index');

    Route::get('/products/create', function () use ($checkAdmin) {
        return $checkAdmin(fn() => app(AdminProductController::class)->create());
    })->name('admin.products.create');

    Route::post('/products', function (Request $request) use ($checkAdmin) {
        return $checkAdmin(fn() => app(AdminProductController::class)->store($request));
    })->name('admin.products.store');

    Route::get('/products/{id}/edit', function ($id) use ($checkAdmin) {
        return $checkAdmin(fn() => app(AdminProductController::class)->edit($id));
    })->name('admin.products.edit');

    Route::put('/products/{id}', function (Request $request, $id) use ($checkAdmin) {
        return $checkAdmin(fn() => app(AdminProductController::class)->update($request, $id));
    })->name('admin.products.update');

    Route::put('/products/{id}/stock', function (Request $request, $id) use ($checkAdmin) {
        return $checkAdmin(fn() => app(AdminProductController::class)->updateStock($request, $id));
    })->name('admin.products.updateStock');

    Route::delete('/products/{id}', function ($id) use ($checkAdmin) {
        return $checkAdmin(fn() => app(AdminProductController::class)->destroy($id));
    })->name('admin.products.destroy');

    /*
    |----------------------------
    | Orders (Admin view & update status)
    |----------------------------
    */
    Route::get('/orders', function () use ($checkAdmin) {
        return $checkAdmin(fn() => app(OrderController::class)->index());
    })->name('admin.orders.index');

    Route::get('/orders/{id}', function ($id) use ($checkAdmin) {
        return $checkAdmin(fn() => app(OrderController::class)->show($id));
    })->name('admin.orders.show');

    Route::post('/orders/{id}/update-status', function (Request $request, $id) use ($checkAdmin) {
        return $checkAdmin(fn() => app(OrderController::class)->updateStatus($request, $id));
    })->name('admin.orders.updateStatus');

    /*
    |----------------------------
    | Categories CRUD (Updated)
    |----------------------------
    */
    Route::get('/categories', function () use ($checkAdmin) {
        return $checkAdmin(fn() => app(CategoryController::class)->index());
    })->name('admin.categories.index');

    Route::get('/categories/create', function () use ($checkAdmin) {
        return $checkAdmin(fn() => app(CategoryController::class)->create());
    })->name('admin.categories.create');

    Route::post('/categories', function (Request $request) use ($checkAdmin) {
        return $checkAdmin(fn() => app(CategoryController::class)->store($request));
    })->name('admin.categories.store');

    Route::get('/categories/{category}/edit', function ($category) use ($checkAdmin) {
    $category = Category::findOrFail($category); // 🔹 fetch model manually
    return $checkAdmin(fn() => app(CategoryController::class)->edit($category));
})->name('admin.categories.edit');


   Route::put('/categories/{category}', function (Request $request, $category) use ($checkAdmin) {
    $category = Category::findOrFail($category);
    return $checkAdmin(fn() => app(CategoryController::class)->update($request, $category));
})->name('admin.categories.update');

Route::delete('/categories/{category}', function ($category) use ($checkAdmin) {
    $category = Category::findOrFail($category);
    return $checkAdmin(fn() => app(CategoryController::class)->destroy($category));
})->name('admin.categories.destroy');


});
