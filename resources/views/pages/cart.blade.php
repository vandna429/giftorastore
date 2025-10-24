@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<div class="container py-5">
    <h2>Your Shopping Cart</h2>

    @if(session('cart') && count(session('cart')) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>PKR {{ $item['price'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>PKR {{ $item['price'] * $item['quantity'] }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Total: PKR {{ $total }}</h4>

        <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger btn-sm">Clear Cart</button>
        </form>

    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
