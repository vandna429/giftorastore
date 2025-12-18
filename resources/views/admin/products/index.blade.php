@extends('admin.layouts.admin')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="add-btn">
        <i class="bi bi-plus-circle"></i>
        Add New Product
    </a>
</div>

<div class="products-table">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock Quantity</th>
                <th style="width: 80px; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <strong>{{ $product->name }}</strong>
                </td>
                <td>
                    <span style="color: #333; font-weight: 500;">${{ number_format($product->price, 0) }}</span>
                </td>
                <td>
                    @php
                        $stockValue = $product->stock !== null ? (int)$product->stock : 0;
                        $stockColor = $stockValue > 0 ? '#28a745' : '#dc3545';
                    @endphp
                    <div class="d-flex align-items-center gap-2">
                        <span id="stock-display-{{ $product->id }}" style="color: {{ $stockColor }}; font-weight: 500; min-width: 40px;">{{ $stockValue }}</span>
                        <button type="button" 
                                class="btn btn-sm btn-outline-primary" 
                                onclick="openStockModal({{ $product->id }}, '{{ $product->name }}', {{ $stockValue }})"
                                style="padding: 2px 8px; font-size: 0.75rem;">
                            <i class="bi bi-pencil"></i> Update
                        </button>
                    </div>
                </td>
                <td style="text-align: center;">
                    <div class="action-menu">
                        <button class="action-btn" type="button">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <div class="action-dropdown">
                            <a href="{{ route('admin.products.edit', $product->id) }}">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <a href="#" onclick="if(confirm('Delete this product?')) this.closest('form').submit(); return false;" style="color: #dc3545;">
                                    <i class="bi bi-trash me-2"></i>Delete
                                </a>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-5 text-muted">
                    No products found. <a href="{{ route('admin.products.create') }}">Add your first product</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Stock Update Modal -->
<div class="modal fade" id="stockUpdateModal" tabindex="-1" aria-labelledby="stockUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockUpdateModalLabel">Update Stock Quantity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="stockUpdateForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="stock-product-id" name="product_id">
                    <div class="mb-3">
                        <label for="stock-product-name" class="form-label">Product:</label>
                        <input type="text" class="form-control" id="stock-product-name" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="stock-quantity" class="form-label">Stock Quantity:</label>
                        <input type="number" class="form-control" id="stock-quantity" name="stock" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openStockModal(productId, productName, currentStock) {
    document.getElementById('stock-product-id').value = productId;
    document.getElementById('stock-product-name').value = productName;
    document.getElementById('stock-quantity').value = currentStock;
    document.getElementById('stockUpdateForm').action = '/admin/products/' + productId + '/stock';
    
    const modal = new bootstrap.Modal(document.getElementById('stockUpdateModal'));
    modal.show();
}

// Handle form submission
document.getElementById('stockUpdateForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const productId = document.getElementById('stock-product-id').value;
    const stockValue = document.getElementById('stock-quantity').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch(form.action, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            stock: parseInt(stockValue)
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update the display
            const stockDisplay = document.getElementById('stock-display-' + productId);
            if (stockDisplay) {
                stockDisplay.textContent = data.data.new_stock;
                stockDisplay.style.color = data.data.new_stock > 0 ? '#28a745' : '#dc3545';
            }
            
            // Close modal
            const modalElement = document.getElementById('stockUpdateModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
            
            // Show success message
            alert('Stock updated successfully!');
        } else {
            alert('Error: ' + (data.message || 'Failed to update stock'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const errorMsg = error.message || error.error || 'An error occurred while updating stock';
        alert('Error: ' + errorMsg);
    });
});
</script>
@endsection
