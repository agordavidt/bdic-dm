@extends('layouts.dashboard')

@section('title', 'Checkout')
@section('page-title', 'Checkout')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Checkout</h4>
                            <p class="card-subtitle card-subtitle-dash">Complete your order details</p>
                        </div>
                    </div>

                    <form action="{{ route('buyer.orders.store') }}" method="POST" class="mt-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title">Shipping Address</h5>
                                        <div class="form-group mb-3">
                                            <label for="shipping_address" class="form-label">Address</label>
                                            <input type="text" class="form-control" name="shipping_address" id="shipping_address" required>
                                        </div>
                                        
                                        <h5 class="card-title">Billing Address</h5>
                                        <div class="form-group mb-3">
                                            <label for="billing_address" class="form-label">Address</label>
                                            <input type="text" class="form-control" name="billing_address" id="billing_address" required>
                                        </div>
                                        
                                        <h5 class="card-title">Payment Method</h5>
                                        <div class="form-group mb-3">
                                            <select class="form-select" name="payment_method" required>
                                                <option value="">Select Payment Method</option>
                                                <option value="credit_card">Credit Card</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                                <option value="cash_on_delivery">Cash on Delivery</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="notes" class="form-label">Order Notes (optional)</label>
                                            <textarea class="form-control" name="notes" id="notes" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Order Summary</h5>
                                        <ul class="list-group mb-3">
                                            @foreach($cartItems as $item)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $item->product->name ?? '-' }} x{{ $item->quantity }}
                                                <span>₦{{ number_format($item->total_price, 2) }}</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span>₦{{ number_format($total, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Tax:</span>
                                            <span>₦{{ number_format($tax, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Shipping:</span>
                                            <span>₦{{ number_format($shipping, 2) }}</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total:</span>
                                            <span>₦{{ number_format($grandTotal, 2) }}</span>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 mt-3">
                                            <i class="mdi mdi-check-circle"></i> Place Order
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection