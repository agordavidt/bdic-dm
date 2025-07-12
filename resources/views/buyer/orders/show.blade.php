@extends('layouts.app')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Order #{{ $order->order_number }}</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Order Information</h5>
                    <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                    <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Billing Address:</strong> {{ $order->billing_address }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5>Order Items</h5>
                    <ul class="list-group">
                        @foreach($order->orderItems as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $item->product->name ?? '-' }} x{{ $item->quantity }}
                            <span>₦{{ number_format($item->total_price, 2) }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Summary</h5>
                    <p>Subtotal: <strong>₦{{ number_format($order->subtotal, 2) }}</strong></p>
                    <p>Tax: <strong>₦{{ number_format($order->tax, 2) }}</strong></p>
                    <p>Shipping: <strong>₦{{ number_format($order->shipping, 2) }}</strong></p>
                    <p>Total: <strong>₦{{ number_format($order->total, 2) }}</strong></p>
                    @if($order->canBeCancelled())
                    <form action="{{ route('buyer.orders.cancel', $order) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Cancel Order</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 