@extends('layouts.app')

@section('title', 'My Cart')
@section('page-title', 'Shopping Cart')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Shopping Cart</h2>
    <div class="card">
        <div class="card-body">
            @if($cartItems->count())
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item->product->name ?? '-' }}</td>
                            <td>₦{{ number_format($item->product->price ?? 0, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₦{{ number_format($item->total_price, 2) }}</td>
                            <td>
                                <form action="{{ route('buyer.cart.remove', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <div class="card" style="min-width: 300px;">
                    <div class="card-body">
                        <h5>Summary</h5>
                        <p>Subtotal: <strong>₦{{ number_format($total, 2) }}</strong></p>
                        <p>Tax: <strong>₦{{ number_format($total * 0.1, 2) }}</strong></p>
                        <p>Total: <strong>₦{{ number_format($total * 1.1, 2) }}</strong></p>
                        <a href="{{ route('buyer.orders.checkout') }}" class="btn btn-primary w-100 mt-2">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-info">Your cart is empty.</div>
            @endif
        </div>
    </div>
</div>
@endsection 