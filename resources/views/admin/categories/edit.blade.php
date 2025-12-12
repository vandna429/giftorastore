@extends('admin.layouts.admin')



@section('title', 'Edit Category')

@section('content')
<h2>Edit Category</h2>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
           <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
    </div>
    <button class="btn btn-primary">Update Category</button>
</form>
@endsection
