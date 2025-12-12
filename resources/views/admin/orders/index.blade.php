@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">All Orders</h2>

    {{-- Success & Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($orders->count() > 0)
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
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
                    <td>{{ $order->user?->name ?? 'Guest' }}</td>
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
    @else
        <div class="text-center py-5">
            <p class="fs-5">No orders found.</p>
        </div>
    @endif
</div>
@endsection
