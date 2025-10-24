@extends('layouts.app')

@section('title', 'Home - Giftora')

@section('content')

<!-- ✅ Hero Section with Background -->
<div class="hero-section d-flex align-items-center justify-content-center text-center"
     style="height: 80vh; background: url('{{ asset('images/hero-bg.jpg') }}') center/cover no-repeat;">
    <div class="bg-dark bg-opacity-50 p-5 rounded">
        <h1 class="display-4 text-white fw-bold">Gifts Crafted with Grace and Heart</h1>
        <p class="text-light fs-5">Because the best gifts aren’t expensive — they’re meaningful and beautifully made.</p>
        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">Discover Gifts</a>
    </div>
</div>

<!-- ✅ Your Existing Content Starts Here -->
<div class="py-5">
    <hr class="my-5">

    <h2 class="text-center mb-4">Popular Categories</h2>
    <div class="d-flex justify-content-center flex-wrap gap-4">

        <div class="card p-3 text-center" style="width: 200px;">
            <img src="{{ asset('images/chocolates-icon.jpg') }}" alt="Chocolates" class="img-fluid mb-2" style="height: 90px; object-fit: contain;">
            <h6 class="fw-semibold">Chocolates</h6>
        </div>

        <div class="card p-3 text-center" style="width: 200px;">
            <img src="{{ asset('images/roses-icon.jpg') }}" alt="Roses" class="img-fluid mb-2" style="height: 90px; object-fit: contain;">
            <h6 class="fw-semibold">Roses</h6>
        </div>

        <div class="card p-3 text-center" style="width: 200px;">
            <img src="{{ asset('images/candles-icon.jpg') }}" alt="Candles" class="img-fluid mb-2" style="height: 90px; object-fit: contain;">
            <h6 class="fw-semibold">Candles</h6>
        </div>

        <div class="card p-3 text-center" style="width: 200px;">
            <img src="{{ asset('images/mugs-icon.jpg') }}" alt="Mugs" class="img-fluid mb-2" style="height: 90px; object-fit: contain;">
            <h6 class="fw-semibold">Mugs</h6>
        </div>

    </div>
</div>
@endsection
