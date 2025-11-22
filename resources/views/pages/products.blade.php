@extends('layouts.app')

@section('title', 'Products - Giftora')

@section('content')
<div class="py-5 container">

    <!-- 🔍 Search Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold mb-0">
            @if(request('category'))
                {{ ucfirst(request('category')) }} Gifts
            @else
                All Products
            @endif
        </h2>
        <form class="d-flex" method="GET" action="{{ route('products.index') }}">
            <input name="query" class="form-control me-2" type="search"
                   placeholder="Search products" aria-label="Search"
                   value="{{ request('query') }}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </form>
    </div>

    <!-- 🟩 Category Filter Buttons -->
    <div class="mb-4 text-center">
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm mx-1 {{ !request('category') ? 'active' : '' }}">All</a>
        <a href="{{ route('products.index', ['category' => 'chocolates']) }}" class="btn btn-outline-primary btn-sm mx-1 {{ request('category') == 'chocolates' ? 'active' : '' }}">Chocolates</a>
        <a href="{{ route('products.index', ['category' => 'roses']) }}" class="btn btn-outline-primary btn-sm mx-1 {{ request('category') == 'roses' ? 'active' : '' }}">Roses</a>
        <a href="{{ route('products.index', ['category' => 'candles']) }}" class="btn btn-outline-primary btn-sm mx-1 {{ request('category') == 'candles' ? 'active' : '' }}">Candles</a>
        <a href="{{ route('products.index', ['category' => 'mugs']) }}" class="btn btn-outline-primary btn-sm mx-1 {{ request('category') == 'mugs' ? 'active' : '' }}">Mugs</a>
    </div>

    <!-- 🛍️ Product Cards -->
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm border-0">
                <img src="{{ asset('images/' . $product['image']) }}"
                     class="card-img-top" alt="{{ $product['name'] }}"
                     style="height: 200px; object-fit: contain; background: #f8f9fa;">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product['name'] }}</h5>
                    <p class="card-text small text-muted">{{ $product['short'] ?? 'Beautifully crafted gift for your loved ones.' }}</p>

                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <strong>PKR {{ number_format($product['price']) }}</strong>
                        <a href="{{ route('products.show', $product['slug']) }}" class="btn btn-sm btn-primary">
                            View
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <h5>No products found in this category.</h5>
        </div>
        @endforelse
    </div>
</div>
@endsection
