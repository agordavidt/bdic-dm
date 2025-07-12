@extends('layouts.app')

@section('title', 'Checkout')
@section('page-title', 'Checkout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Checkout</h2>
    <form action="{{ route('buyer.orders.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Shipping Address</h5>
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="shipping_address" id="shipping_address" required>
                        </div>
                        <h5>Billing Address</h5>
                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="billing_address" id="billing_address" required>
                        </div>
                        <h5>Payment Method</h5>
                        <div class="mb-3">
                            <select class="form-select" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cash_on_delivery">Cash on Delivery</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Order Notes (optional)</label>
                            <textarea class="form-control" name="notes" id="notes" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Order Summary</h5>
                        <ul class="list-group mb-3">
                            @foreach($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $item->product->name ?? '-' }} x{{ $item->quantity }}
                                <span>₦{{ number_format($item->total_price, 2) }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <p>Subtotal: <strong>₦{{ number_format($total, 2) }}</strong></p>
                        <p>Tax: <strong>₦{{ number_format($tax, 2) }}</strong></p>
                        <p>Shipping: <strong>₦{{ number_format($shipping, 2) }}</strong></p>
                        <p>Total: <strong>₦{{ number_format($grandTotal, 2) }}</strong></p>
                        <button type="submit" class="btn btn-primary w-100 mt-2">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection 