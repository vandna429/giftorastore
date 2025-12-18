@extends('admin.layouts.admin')



@section('title', 'Add Category')

@section('content')
<div class="products-table p-4">
    <h2 class="page-title mb-4">Add New Category</h2>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
           <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Category Image:</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="text-muted">Upload an image for this category (optional, max 2MB)</small>
    </div>
    <button class="btn btn-success">Save Category</button>
</form>
</div>
@endsection
