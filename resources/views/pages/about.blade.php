@extends('layouts.app')

@section('title', 'About Us - Giftora')

@section('content')
<style>
    /* Page background and overlay */
    .about-hero {
        background-image: url('{{ asset('images/about-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        position: relative;
        color: white;
        padding: 120px 0;
    }

    .about-hero::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.5); /* dark overlay for readability */
    }

    .about-hero .container {
        position: relative;
        z-index: 2;
    }

    .about-section {
        background-color: #fff;
        margin-top: -50px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 50px;
    }
</style>

<!-- Hero Section -->
<div class="about-hero text-center">
    <div class="container">
        <h1 class="fw-bold display-5">About Giftora</h1>
        <p class="lead">Bringing joy, love, and smiles — one gift at a time.</p>
    </div>
</div>

<!-- About Content -->
<div class="container about-section">
    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="{{ asset('images/about-giftora.jpg') }}" class="img-fluid rounded shadow" alt="About Giftora">
        </div>
        <div class="col-md-6">
            <h4 class="fw-bold">Who We Are</h4>
            <p class="text-muted">
                Giftora is Pakistan’s favorite online gift destination — offering thoughtful, personalized, and creative gifts for every occasion.
                From birthdays to anniversaries, our mission is simple: to make every moment special and unforgettable.
            </p>
            <p class="text-muted">
                Established in 2025, we have delivered thousands of smiles across the country. Each product we offer is handpicked with care
                and wrapped with love, because every gift should tell a story.
            </p>
        </div>
    </div>

    <div class="row text-center mt-5">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 p-4 h-100">
                <i class="bi bi-gift-fill fs-1 text-primary mb-3"></i>
                <h5 class="fw-bold">Our Mission</h5>
                <p class="text-muted">To make gifting easier, meaningful, and memorable — connecting people through thoughtful surprises.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 p-4 h-100">
                <i class="bi bi-heart-fill fs-1 text-danger mb-3"></i>
                <h5 class="fw-bold">Our Vision</h5>
                <p class="text-muted">To become the most trusted online gifting platform in Pakistan through creativity and customer care.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 p-4 h-100">
                <i class="bi bi-people-fill fs-1 text-success mb-3"></i>
                <h5 class="fw-bold">Our Values</h5>
                <p class="text-muted">We value happiness, creativity, and quality — because every gift matters.</p>
            </div>
        </div>
    </div>

    
</div>
@endsection
