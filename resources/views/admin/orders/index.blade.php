@extends('admin.layouts.admin')

@section('title', 'Orders')

@section('content')
<div>
    <h1 class="page-title mb-4">Orders</h1>

    {{-- Success & Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($orders->count() > 0)
        <div class="products-table">
            <table class="table table-hover mb-0">
            <thead class="table-light text-center">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Address</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Placed At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="text-center">
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->name ?? $order->user?->name ?? 'Guest' }}</td>
                    <td class="text-start">
                        <small>
                            {{ $order->address ?? 'N/A' }}<br>
                            @if($order->phone)
                                <span class="text-muted"><i class="bi bi-telephone"></i> {{ $order->phone }}</span>
                            @endif
                            @if($order->email)
                                <br><span class="text-muted"><i class="bi bi-envelope"></i> {{ $order->email }}</span>
                            @endif
                        </small>
                    </td>
                    <td>PKR {{ number_format($order->total_price, 2) }}</td>
                    <td>
                        <span class="badge 
                            @if($order->status == 'Pending') bg-warning
                            @elseif($order->status == 'Processing') bg-info
                            @elseif($order->status == 'Completed') bg-success
                            @elseif($order->status == 'Cancelled') bg-danger
                            @else bg-secondary @endif">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                    <td class="d-flex justify-content-center gap-2">
                        {{-- Update Status Form --}}
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            <select name="status" class="form-select form-select-sm me-2">
                                <option value="Pending" @selected($order->status == 'Pending')>Pending</option>
                                <option value="Processing" @selected($order->status == 'Processing')>Processing</option>
                                <option value="Completed" @selected($order->status == 'Completed')>Completed</option>
                                <option value="Cancelled" @selected($order->status == 'Cancelled')>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                        </form>

                        {{-- Optional View Button --}}
                        <!-- <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">View</a> -->
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-5">
            <p class="fs-5">No orders found.</p>
        </div>
    @endif
</div>
@endsection
