@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<div class="container py-5">
    <h2>Your Shopping Cart</h2>

    @if(session('cart') && count(session('cart')) > 0)
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Price (PKR)</th>
                    <th>Quantity</th>
                    <th>Subtotal (PKR)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php 
                        $subtotal = $item['price'] * $item['quantity']; 
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ number_format($item['price']) }}</td>
                        <td class="text-center">
                            <!-- Quantity controls -->
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <!-- Decrease -->
                                <form action="{{ route('cart.update', $id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="action" value="decrease">
                                    <button class="btn btn-sm btn-outline-secondary">-</button>
                                </form>

                                <span class="fw-bold">{{ $item['quantity'] }}</span>

                                <!-- Increase -->
                                <form action="{{ route('cart.update', $id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="action" value="increase">
                                    <button class="btn btn-sm btn-outline-secondary">+</button>
                                </form>
                            </div>
                        </td>
                        <td>{{ number_format($subtotal) }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.remove', $id) }}">
                                @csrf
                                <button class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="text-end">Total: <span class="text-primary">PKR {{ number_format($total) }}</span></h4>

        <div class="d-flex justify-content-between mt-4">
            <form method="POST" action="{{ route('cart.clear') }}">
                @csrf
                <button class="btn btn-outline-danger">Clear Cart</button>
            </form>

            <a href="{{ route('cart.checkout') }}" class="btn btn-success">
                Proceed to Checkout →
            </a>
        </div>

    @else
        <p>Your cart is empty. <a href="{{ route('products.index') }}">Shop now</a></p>
    @endif
</div>
@endsection
