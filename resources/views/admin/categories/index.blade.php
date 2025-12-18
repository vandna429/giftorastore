@extends('admin.layouts.admin')



@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="add-btn">
        <i class="bi bi-plus-circle"></i>
        Add New Category
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif


<div class="products-table">
    <table class="table table-hover mb-0">
    <thead>
        <tr>
            <th>Name</th>
            <th>Slug</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>
                @php
                    $imagePath = $category->image;
                    $imageUrl = null;
                    
                    // First, try to use image from database
                    if (!empty($imagePath)) {
                        // Normalize path - remove leading slash if present
                        $imagePath = ltrim($imagePath, '/');
                        
                        // Check if file exists
                        $fullPath = public_path($imagePath);
                        if (file_exists($fullPath)) {
                            $imageUrl = asset($imagePath);
                        } else {
                            // Try alternative paths
                            $alternatives = [
                                '/' . $imagePath,
                                'uploads/categories/' . basename($imagePath),
                                '/' . 'uploads/categories/' . basename($imagePath)
                            ];
                            
                            foreach ($alternatives as $altPath) {
                                $altFullPath = public_path(ltrim($altPath, '/'));
                                if (file_exists($altFullPath)) {
                                    $imageUrl = asset(ltrim($altPath, '/'));
                                    break;
                                }
                            }
                        }
                    }
                    
                    // Fallback: Check for icon images in public/images/ folder
                    if (!$imageUrl) {
                        $iconMappings = [
                            'chocolates' => 'chocolates-icon.jpg',
                            'roses' => 'roses-icon.jpg',
                            'candles' => 'candles-icon.jpg',
                            'mugs' => 'mugs-icon.jpg',
                        ];
                        
                        if (isset($iconMappings[$category->slug])) {
                            $iconPath = 'images/' . $iconMappings[$category->slug];
                            $fullIconPath = public_path($iconPath);
                            if (file_exists($fullIconPath)) {
                                $imageUrl = asset($iconPath);
                            }
                        }
                    }
                @endphp
                
                @if($imageUrl)
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $category->name }}" 
                         width="50" 
                         height="50" 
                         class="img-thumbnail rounded" 
                         style="object-fit: cover; border: 1px solid #ddd; cursor: pointer;"
                         onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='inline';"
                         onclick="window.open('{{ $imageUrl }}', '_blank')"
                         title="Click to view full size">
                    <span class="text-muted" style="font-size: 0.9em; display: none;">No image</span>
                @else
                    <span class="text-muted" style="font-size: 0.9em;">
                        <i class="bi bi-image"></i> No image
                    </span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this category?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
</div>
@endsection
