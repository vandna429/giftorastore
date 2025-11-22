@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container py-5">
    <h2>All Products</h2>

    <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">Add Product</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Category</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->slug }}</td>
                <td>{{ $product->category }}</td>
                <td>{{ $product->price }}</td>
                <td>
                    @if($product->image)
                        
   @if($product->image && file_exists(public_path('images/'.$product->image)))
    <img src="{{ asset('images/'.$product->image) }}" width="50" alt="{{ $product->name }}">
@else
    <span>No image</span>
@endif

</td>

                    @endif
                </td>
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
</div>
@endsection
