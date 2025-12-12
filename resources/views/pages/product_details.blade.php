@extends('layouts.app')

@section('title', $product['name'] . ' - Giftora')

@section('content')
<div class="container py-5">

    <!--  Success / Error Alerts -->
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    <div class="row g-4 align-items-center">

        <!--  Product Image -->
        <div class="col-md-6 text-center">
            @php
                $imagePath = $product['image'];
                // If image path does not contain '/', assume old image in public/images/
                if (!str_contains($imagePath, '/')) {
                    $imagePath = 'images/' . $imagePath;
                }
            @endphp
            <img src="{{ asset($imagePath) }}" 
                 alt="{{ $product['name'] }}" 
                 class="img-fluid rounded shadow-sm" 
                 style="max-height: 420px; object-fit: contain;">
        </div>

        <!--  Product Details -->
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $product['name'] }}</h2>
            <p class="text-muted small">{{ $product['description'] }}</p>
            <h3 class="mt-3 text-primary">PKR {{ number_format($product['price']) }}</h3>

            <hr>

            <h5 class="fw-semibold">Product Description</h5>
            <p>{{ $product['description'] }}</p>

            <!-- Add to Cart Form -->
            <form action="{{ route('cart.add', $product['slug']) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>

            <!--  Back Button -->
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                &larr; Back to Products
            </a>

        </div>
    </div>
</div>
@endsection
