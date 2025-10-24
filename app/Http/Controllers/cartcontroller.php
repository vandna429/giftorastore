<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // ✅ Local product data (same as ProductController)
    private function products()
    {
        return [
            [
                'slug' => 'luxury-chocolate-box',
                'name' => 'Luxury Chocolate Box',
                'price' => 2500,
                'image' => 'luxury-chocolate-box.jpg',
            ],
            [
                'slug' => 'flower-bouquet-roses',
                'name' => 'Rose Bouquet',
                'price' => 3200,
                'image' => 'rose-bouquet.jpg',
            ],
            [
                'slug' => 'personalized-mug',
                'name' => 'Personalized Mug',
                'price' => 900,
                'image' => 'personalized-mug.jpg',
            ],
        ];
    }

    // ✅ Show cart page
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.index', compact('cart', 'total'));
    }

    // ✅ Add product to cart (by slug)
    public function add(Request $request, $slug)
    {
        $product = collect($this->products())->firstWhere('slug', $slug);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$slug])) {
            $cart[$slug]['quantity']++;
        } else {
            $cart[$slug] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // ✅ Remove one item
    public function remove($slug)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$slug])) {
            unset($cart[$slug]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed!');
    }

    // ✅ Clear all items
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }

    // ✅ Checkout page
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('cart.checkout', compact('cart', 'total'));
    }


    public function update(Request $request, $id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        if ($request->action === 'increase') {
            $cart[$id]['quantity']++;
        } elseif ($request->action === 'decrease' && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        }
        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'Cart updated successfully!');
}


public function processCheckout(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'address' => 'required',
    ]);

    // ✅ Clear cart after checkout
    session()->forget('cart');

    // ✅ Return with success message
    return redirect()->back()->with('success', '🎉 Thank you! Your order has been confirmed.');
}


   
}
