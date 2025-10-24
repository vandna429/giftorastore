@extends('layouts.app')


@section('title', 'Gifts - Giftora')


@section('content')
<div class="py-5">
<div class="d-flex justify-content-between align-items-center mb-4">
<h2 class="fw-bold">Products</h2>
<form class="d-flex" method="GET" action="{{ route('products.index') }}">
<input name="query" class="form-control me-2" type="search" placeholder="Search products" aria-label="Search" value="{{ request('query') }}">
<button class="btn btn-outline-secondary" type="submit">Search</button>
</form>
</div>


<div class="row g-4">
@forelse($products as $product)
<div class="col-sm-6 col-md-4 col-lg-3">
<div class="card h-100 shadow-sm">
<img src="{{ asset('images/' . $product['image']) }}" class="card-img-top" alt="{{ $product['name'] }}" style="height: 180px; object-fit: contain;">
<div class="card-body d-flex flex-column">
<h5 class="card-title">{{ $product['name'] }}</h5>
<p class="card-text small text-muted">{{ $product['short'] }}</p>
<div class="mt-auto d-flex justify-content-between align-items-center">
<strong>PKR {{ number_format($product['price']) }}</strong>


<a href="{{ route('products.show', $product['slug']) }}" class="btn btn-sm btn-primary">View</a>
</div>
</div>
</div>
</div>
@empty
<p class="text-center">No products found.</p>
@endforelse
</div>
</div>
@endsection