<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // List all orders
    public function index() {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
{
    $order = Order::with(['items.product', 'user'])->findOrFail($id);

    return view('admin.orders.show', compact('order'));
}

    // Update order status only
     public function updateStatus(Request $request, $id) {
        // Find the order by ID
        $order = Order::findOrFail($id);

        // Validate status
        $request->validate([
            'status' => 'required|in:Pending,Processing,Completed,Cancelled'
        ]);

        // Update the order
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated!');
    }
}
