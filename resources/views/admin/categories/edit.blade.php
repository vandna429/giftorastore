@extends('admin.layouts.admin')



@section('title', 'Edit Category')

@section('content')
<div class="products-table p-4">
    <h2 class="page-title mb-4">Edit Category</h2>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
           <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
    </div>
    <div class="mb-3">
        <label>Category Image:</label>
        @php
            $hasValidImage = false;
            if ($category->image && str_contains($category->image, '/') && file_exists(public_path($category->image))) {
                $hasValidImage = true;
            }
        @endphp
        @if($hasValidImage)
            <div class="mb-2">
                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" width="100" class="img-thumbnail">
                <p class="text-muted small mt-1">Current image</p>
            </div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="text-muted">Upload a new image to replace the current one (optional, max 2MB)</small>
    </div>
    <button class="btn btn-primary">Update Category</button>
</form>
</div>
@endsection
