@extends('admin.layouts.admin')



@section('title', 'Add Category')

@section('content')
<h2>Add New Category</h2>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
           <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <button class="btn btn-success">Save Category</button>
</form>
@endsection
