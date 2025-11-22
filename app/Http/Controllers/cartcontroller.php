<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    //  Show cart
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.index', compact('cart', 'total'));
    }

    //  Add product to cart
    public function add(Request $request, $slug)
    {
        //  Get all products from ProductController
        $products = (new ProductController())->allProducts();
        $product = collect($products)->firstWhere('slug', $slug);

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
        return redirect()->route('cart.index')->with('success', '✅ Product added to cart!');
    }

    // 🔼 Update quantity (increase/decrease)
    public function update(Request $request, $slug)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$slug])) {
            return redirect()->back()->with('error', 'Item not found in cart!');
        }

        if ($request->action === 'increase') {
            $cart[$slug]['quantity']++;
        } elseif ($request->action === 'decrease') {
            $cart[$slug]['quantity']--;
            if ($cart[$slug]['quantity'] <= 0) {
                unset($cart[$slug]);
            }
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Cart updated!');
    }

    // ❌ Remove one item
    public function remove($slug)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$slug])) {
            unset($cart[$slug]);
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item removed!');
    }

    // 🧹 Clear all
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared!');
    }

    // 💳 Checkout page
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.checkout', compact('cart', 'total'));
    }

    // ✅ Fake checkout process
    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'address' => 'required|string|max:255',
        ]);

        session()->forget('cart');
        return redirect()->route('cart.checkout')->with('success', '🎉 Order placed successfully!');
    }
}
