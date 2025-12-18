<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\ProductController;

class CartController extends Controller
{
    // Show cart
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.index', compact('cart', 'total'));
    }

    // Add product to cart
    public function add(Request $request, $slug)
    {
        // First, try to get product from static array
        $products = (new ProductController())->allProducts();
        $product = collect($products)->firstWhere('slug', $slug);

        // If not found in static, check database
        if (!$product) {
            $dbProduct = Product::where('slug', $slug)->first();
            
            if (!$dbProduct) {
                return redirect()->back()->with('error', 'Product not found!');
            }

            // Convert database product to array format
            $product = [
                'name' => $dbProduct->name,
                'price' => $dbProduct->price,
                'image' => $dbProduct->image,
                'slug' => $dbProduct->slug,
            ];
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

    // Update quantity
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

    // Remove one item
    public function remove($slug)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$slug])) {
            unset($cart[$slug]);
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item removed!');
    }

    // Clear all
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared!');
    }

    // Checkout page
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.checkout', compact('cart', 'total'));
    }

    // Process checkout and save order
    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Calculate total price
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Save order in database
        Order::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'total_price' => $total,
            'status' => 'Pending',
        ]);

        // Clear cart
        session()->forget('cart');

        return redirect()->route('cart.checkout')->with('success', '🎉 Order placed successfully!');
    }
}
