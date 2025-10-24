@extends('layouts.app')

@section('title', $product['name'] . ' - Giftora')

@section('content')
<div class="container py-5">
    <div class="row g-4 align-items-center">
        <!-- 🖼️ Product Image -->
        <div class="col-md-6 text-center">
            <img src="{{ asset('images/' . $product['image']) }}" 
                 alt="{{ $product['name'] }}" 
                 class="img-fluid rounded shadow-sm" 
                 style="max-height: 420px; object-fit: contain;">
        </div>

        <!-- 🛍️ Product Details -->
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $product['name'] }}</h2>
            <p class="text-muted small">{{ $product['short'] }}</p>
            <h3 class="mt-3 text-primary">PKR {{ number_format($product['price']) }}</h3>

            <hr>

            <h5 class="fw-semibold">Product Description</h5>
            <p>{{ $product['description'] }}</p>

            <!-- ✅ Add to Cart Button -->
            <form action="{{ route('cart.add', $product['slug']) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-lg mt-3">
                    🛒 Add to Cart
                </button>
            </form>

            <!-- 🔙 Back Button -->
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mt-3">
                ← Back to Products
            </a>
        </div>
    </div>
</div>
@endsection
