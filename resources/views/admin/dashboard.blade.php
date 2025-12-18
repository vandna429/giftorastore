@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div>
    <h1 class="page-title mb-4">Welcome Admin 🎉</h1>

    <div class="row g-4">
        <!-- Products Card -->
        <div class="col-md-4">
            <div class="products-table p-4 text-center d-flex flex-column" style="height: 100%; min-height: 280px;">
                <h3 class="mb-3" style="font-size: 20px; font-weight: 600; color: #333333;">Product Management</h3>
                <p class="text-muted mb-4 flex-grow-1">Manage all products</p>
                <a href="{{ route('admin.products.index') }}" class="add-btn">
                    <i class="bi bi-box-seam"></i>
                    Go to Products
                </a>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-md-4">
            <div class="products-table p-4 text-center d-flex flex-column" style="height: 100%; min-height: 280px;">
                <h3 class="mb-3" style="font-size: 20px; font-weight: 600; color: #333333;">Category Management</h3>
                <p class="text-muted mb-4 flex-grow-1">Manage product categories</p>
                <a href="{{ route('admin.categories.index') }}" class="add-btn">
                    <i class="bi bi-tags"></i>
                    Go to Categories
                </a>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-md-4">
            <div class="products-table p-4 text-center d-flex flex-column" style="height: 100%; min-height: 280px;">
                <h3 class="mb-3" style="font-size: 20px; font-weight: 600; color: #333333;">Order Management</h3>
                <p class="text-muted mb-4 flex-grow-1">View and manage orders</p>
                <a href="{{ route('admin.orders.index') }}" class="add-btn">
                    <i class="bi bi-cart-check"></i>
                    Go to Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
