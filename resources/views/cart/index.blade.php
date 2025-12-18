@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')



<div class="container py-5">
    <h2 class="fw-bold mb-4"> Your Shopping Cart</h2>

    {{-- Success & Error Alerts --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if(!empty($cart) && count($cart) > 0)
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Product</th>
                    <th>Price (PKR)</th>
                    <th>Quantity</th>
                    <th>Subtotal (PKR)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $slug => $item)
                    @php 
                        $subtotal = $item['price'] * $item['quantity']; 
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @php
                                    $imagePath = $item['image'];
                                    // If image path does not contain '/', assume old image in public/images/
                                    if (!str_contains($imagePath, '/')) {
                                        $imagePath = 'images/' . $imagePath;
                                    }
                                @endphp
                                <img src="{{ asset($imagePath) }}" 
                                     alt="{{ $item['name'] }}" 
                                     width="60" class="rounded shadow-sm">
                                <span class="fw-semibold">{{ $item['name'] }}</span>
                            </div>
                        </td>

                        <td class="text-center">{{ number_format($item['price']) }}</td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <!-- Decrease -->
                                <form action="{{ route('cart.update', $slug) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="action" value="decrease">
                                    <button class="btn btn-sm btn-outline-secondary">−</button>
                                </form>

                                <span class="fw-bold">{{ $item['quantity'] }}</span>

                                <!-- Increase -->
                                <form action="{{ route('cart.update', $slug) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="action" value="increase">
                                    <button class="btn btn-sm btn-outline-secondary">+</button>
                                </form>
                            </div>
                        </td>

                        <td class="text-center">{{ number_format($subtotal) }}</td>

                        <td class="text-center">
                            <form action="{{ route('cart.remove', $slug) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Remove this item?');">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="text-end mt-4">
            <strong>Total:</strong> 
            <span class="text-primary">PKR {{ number_format($total) }}</span>
        </h4>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger">
                 Clear Cart
            </a>

            <a href="{{ route('cart.checkout') }}" class="btn btn-success">
                Proceed to Checkout →
            </a>
        </div>

    @else
        <div class="text-center py-5">
            <p class="fs-5"> Your cart is empty.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection
