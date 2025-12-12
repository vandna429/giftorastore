@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>All Products</h2>
    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning">Logout</button>
    </form>
</div>

<a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">Add Product</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <!-- Display product name instead of slug -->
            <td>{{ $product->name }}</td>

            <!-- Display category name -->
            <td>{{ $product->category->name ?? 'N/A' }}</td>

            <!-- Price -->
            <td>{{ $product->price }}</td>

            <!-- Image handling -->
            <td>
                @php
                    $imagePath = null;

                    // Check if image exists in new uploads folder
                    if ($product->image && file_exists(public_path($product->image))) {
                        $imagePath = $product->image;
                    }
                    // Fallback to old images folder
                    elseif ($product->image && file_exists(public_path('images/' . $product->image))) {
                        $imagePath = 'images/' . $product->image;
                    }
                @endphp

                @if($imagePath)
                    <img src="{{ asset($imagePath) }}" width="50" alt="{{ $product->name }}">
                @else
                    <span>No image</span>
                @endif
            </td>

            <!-- Actions -->
            <td>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
