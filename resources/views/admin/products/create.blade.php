@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="container py-5">
    <h2>Add New Product</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Price:</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Category:</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach(App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Updated Image Section with Preview -->
        <div class="mb-3">
            <label>Image:</label>
            <input type="file" name="image" class="form-control" id="image" accept="image/*">
            <!-- Image preview -->
            <img id="imagePreview" src="#" alt="Image Preview" style="display:none; max-width:200px; margin-top:10px;">
        </div>

        <button class="btn btn-success">Save Product</button>
    </form>
</div>

<script>
    // Show preview of selected image
    document.getElementById('image').addEventListener('change', function(event) {
        const [file] = event.target.files;
        const preview = document.getElementById('imagePreview');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
</script>
@endsection
