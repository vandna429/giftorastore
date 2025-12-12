 <!-- @extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="container py-5">
    <h2>Order #{{ $order->id }}</h2>

    <p><strong>User:</strong> {{ $order->user->name }}</p>
    <p><strong>Address:</strong> {{ $order->address }}</p>
    <p><strong>Total Price:</strong> ${{ $order->total_price }}</p>

     Only admin can change status 
     <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Status:</label>
            <select name="status" class="form-control">
                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update Status</button>
    </form>

    <h4 class="mt-4">Order Items</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 

  -->


  <!-- {{-- resources/views/admin/orders/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Order Details - Giftora')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Order #{{ $order->id }} Details</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Customer Information --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Customer Information</h5>
        </div>
        <div class="card-body">
            <p><strong>User:</strong> {{ $order->user?->name ?? $order->name ?? 'Guest' }}</p>
            <p><strong>Email:</strong> {{ $order->user?->email ?? $order->email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $order->phone ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>
            <p><strong>Status:</strong> 
                <span class="badge 
                    @if($order->status == 'Pending') bg-warning
                    @elseif($order->status == 'Processing') bg-info
                    @elseif($order->status == 'Completed') bg-success
                    @elseif($order->status == 'Cancelled') bg-danger
                    @else bg-secondary @endif">
                    {{ $order->status }}
                </span>
            </p>

            {{-- Status Update Form (POST) --}}
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mt-3">
                @csrf
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <select name="status" class="form-select">
                            <option value="Pending" @selected($order->status == 'Pending')>Pending</option>
                            <option value="Processing" @selected($order->status == 'Processing')>Processing</option>
                            <option value="Completed" @selected($order->status == 'Completed')>Completed</option>
                            <option value="Cancelled" @selected($order->status == 'Cancelled')>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success">Update Status</button>
                    </div>
                </div>
            </form>

            <p class="mt-3"><strong>Placed At:</strong> {{ $order->created_at->format('d M, Y H:i') }}</p>
        </div>
    </div>

    {{-- Ordered Items --}}
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Ordered Items</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0 text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price (PKR)</th>
                        <th>Subtotal (PKR)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($order->items as $item)
                        @php 
                            $subtotal = $item->price * $item->quantity; 
                            $total += $subtotal; 
                        @endphp
                        <tr>
                            <td>{{ $item->product?->name ?? 'Product Deleted' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="fw-bold">
                        <td colspan="3">Total</td>
                        <td>{{ number_format($total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Back Button --}}
    <div class="mt-3">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            &laquo; Back to Orders
        </a>
    </div>
</div>
@endsection -->


{{-- resources/views/admin/orders/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Order Details - Giftora')

@section('content')
<div class="container py-5">

    <h2 class="mb-4">Order #{{ $order->id }} Details</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Customer Information --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Customer Information</h5>
        </div>

        <div class="card-body">

            <p><strong>User:</strong> {{ $order->user?->name ?? $order->name ?? 'Guest' }}</p>
            <p><strong>Email:</strong> {{ $order->user?->email ?? $order->email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $order->phone ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>

            <p>
                <strong>Status:</strong>
                <span class="badge 
                    @if($order->status == 'Pending') bg-warning
                    @elseif($order->status == 'Processing') bg-info
                    @elseif($order->status == 'Completed') bg-success
                    @elseif($order->status == 'Cancelled') bg-danger
                    @else bg-secondary @endif">
                    {{ $order->status }}
                </span>
            </p>

            {{-- Update Status Form --}}
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mt-3">
                @csrf
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <select class="form-select" name="status">
                            <option value="Pending" @selected($order->status == 'Pending')>Pending</option>
                            <option value="Processing" @selected($order->status == 'Processing')>Processing</option>
                            <option value="Completed" @selected($order->status == 'Completed')>Completed</option>
                            <option value="Cancelled" @selected($order->status == 'Cancelled')>Cancelled</option>
                        </select>
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-success" type="submit">Update Status</button>
                    </div>
                </div>
            </form>

            <p class="mt-3"><strong>Placed At:</strong> {{ $order->created_at->format('d M, Y H:i') }}</p>

        </div>
    </div>

    {{-- Ordered Items --}}
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Ordered Items</h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered text-center mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Product Name</th>
                        <th>Qty</th>
                        <th>Price (PKR)</th>
                        <th>Subtotal (PKR)</th>
                    </tr>
                </thead>

                <tbody>
                    @php $total = 0; @endphp

                    @foreach($order->items as $item)
                        @php 
                            $subtotal = $item->price * $item->quantity;
                            $total += $subtotal;
                        @endphp

                        <tr>
                            <td>{{ optional($item->product)->name ?? 'Product Deleted' }}</td>

                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endforeach

                    <tr class="fw-bold">
                        <td colspan="3">Total</td>
                        <td>{{ number_format($total, 2) }}</td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>

    {{-- Back Button --}}
    <div class="mt-3">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            &laquo; Back to Orders
        </a>
    </div>

</div>
@endsection
