@extends('layouts.app')

@section('title', 'Products - Giftora')

@section('content')
<div class="py-5 container">

    <!-- 🔍 Title + Live Search -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold mb-0">
            @if(request('category'))
                {{ ucfirst(request('category')) }} Gifts
            @else
                All Products
            @endif
        </h2>

        <!-- 🔍 ONLY LIVE AJAX SEARCH BAR -->
        <div class="position-relative" style="width: 250px;">
            <input type="text" id="liveSearch" class="form-control" placeholder="Search by name or category...">

            <!-- Live Dropdown -->
            <div id="searchResults"
                class="list-group position-absolute w-100 shadow-sm"
                style="max-height: 250px; overflow-y: auto; display: none; z-index: 999;">
            </div>
        </div>
    </div>

    <!-- 🟩 Category Filter Buttons -->
    <div class="mb-4 text-center">
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm mx-1 {{ !request('category') ? 'active' : '' }}">All</a>
        @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
               class="btn btn-outline-primary btn-sm mx-1 {{ request('category') == $category->slug ? 'active' : '' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <!-- 🛍️ Product Cards -->
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm border-0">
                @php
                    $imagePath = $product['image'];
                    if (!str_contains($imagePath, '/')) {
                        $imagePath = 'images/' . $imagePath;
                    }
                @endphp
                <img src="{{ asset($imagePath) }}"
                     class="card-img-top" alt="{{ $product['name'] }}"
                     style="height: 200px; object-fit: contain; background: #f8f9fa;">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product['name'] }}</h5>
                    <p class="card-text small text-muted">{{ $product['short'] ?? 'Beautifully crafted gift for your loved ones.' }}</p>

                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <strong>PKR {{ number_format($product['price']) }}</strong>
                        <a href="{{ route('products.show', $product['slug']) }}" class="btn btn-sm btn-primary">View</a>
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

<!-- 🔁 AJAX Live Search Script -->
<script>
document.getElementById('liveSearch').addEventListener('keyup', function () {
    let query = this.value;

    if (query.length < 1) {
        document.getElementById('searchResults').style.display = "none";
        document.getElementById('searchResults').innerHTML = "";
        return;
    }

    fetch("{{ route('products.liveSearch') }}?query=" + query)
        .then(res => res.json())
        .then(data => {
            let resultsBox = document.getElementById('searchResults');

            if (data.length > 0) {
                let html = "";
                data.forEach(item => {
                    html += `
                        <a href="/products/${item.slug}" class="list-group-item list-group-item-action">
                            <strong>${item.name}</strong><br>
                            <small class="text-muted">${item.category_name}</small>
                        </a>
                    `;
                });
                resultsBox.innerHTML = html;
                resultsBox.style.display = "block";
            } else {
                resultsBox.innerHTML = `<div class="list-group-item">No results found</div>`;
                resultsBox.style.display = "block";
            }
        });
});
</script>


@endsection
