@extends('admin.layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="products-table p-4">
    <h2 class="page-title mb-4">Edit Product</h2>

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
            <input type="text" name="price" class="form-control" pattern="[0-9]+(\.[0-9]{1,2})?" value="{{ $product->price }}" placeholder="e.g., 900 or 900.50" required>
        </div>

        <div class="mb-3">
            <label>Stock Quantity:</label>
            <input type="number" name="stock" class="form-control" value="{{ $product->stock ?? 0 }}" min="0" required>
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
            <input type="file" name="image" class="form-control" id="image" accept="image/*">
            @php
                $imagePath = null;
                if ($product->image) {
                    if (str_contains($product->image, '/')) {
                        $imagePath = $product->image;
                    } else {
                        $imagePath = 'images/' . $product->image;
                    }
                }
            @endphp
            @if($imagePath && file_exists(public_path($imagePath)))
                <div class="mt-2">
                    <img src="{{ asset($imagePath) }}" width="100" class="img-thumbnail" id="currentImage">
                    <p class="text-muted small mt-1">Current image</p>
                </div>
            @endif
            <img id="imagePreview" src="#" alt="Image Preview" style="display:none; max-width:200px; margin-top:10px;">
        </div>

        <button class="btn btn-success">Update Product</button>
    </form>
</div>

<script>
    // Show preview of selected image
    document.getElementById('image').addEventListener('change', function(event) {
        const [file] = event.target.files;
        const preview = document.getElementById('imagePreview');
        const currentImage = document.getElementById('currentImage');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            if (currentImage) {
                currentImage.style.display = 'none';
            }
        } else {
            preview.src = '';
            preview.style.display = 'none';
            if (currentImage) {
                currentImage.style.display = 'block';
            }
        }
    });
</script>
@endsection
