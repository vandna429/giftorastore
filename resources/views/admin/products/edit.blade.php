@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container py-5">
    <h2>Edit Product</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Price:</label>
            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
        </div>

       <div class="mb-3">
    <label>Category:</label>
    <select name="category_id" class="form-control" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>


        <div class="mb-3">
            <label>Image:</label>
            <input type="file" name="image" class="form-control">
            @if($product->image)
                <img src="{{ asset('uploads/products/'.$product->image) }}" width="50" class="mt-2">
            @endif
        </div>

        <button class="btn btn-success">Update Product</button>
    </form>
</div>
@endsection
