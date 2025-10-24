@extends('layouts.app')

@section('title', 'Checkout - Giftora')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4 text-center">🛍️ Checkout</h2>

    {{-- ✅ Show success message --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            🎉 {{ session('success') }}
        </div>
    @endif

    @php
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    @endphp

    {{-- ✅ Show empty cart message only when no success message --}}
    @if(count($cart) == 0 && !session('success'))
        <div class="alert alert-warning text-center">
            Your cart is empty. <a href="{{ route('products.index') }}">Browse products</a>
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="row g-5">
            <!-- 🛒 Cart Summary -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white fw-semibold">
                        Your Order Summary
                    </div>
                    <div class="card-body">
                        @foreach($cart as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                                <span>PKR {{ number_format($item['price'] * $item['quantity']) }}</span>
                            </div>
                        @endforeach
                        <hr>
                        <h5 class="fw-bold text-end">Total: PKR {{ number_format($total) }}</h5>
                    </div>
                </div>
            </div>

            <!-- 👤 Customer Details -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white fw-semibold">
                        Customer Information
                    </div>
                    <div class="card-body">
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Shipping Address</label>
                                <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100 mt-2">
                                ✅ Confirm & Place Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
