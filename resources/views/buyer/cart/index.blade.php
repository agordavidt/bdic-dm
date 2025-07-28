@extends('layouts.dashboard')

@section('title', 'My Cart')
@section('page-title', 'Shopping Cart')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Shopping Cart</h4>
                            <p class="card-subtitle card-subtitle-dash">Review your items before checkout</p>
                        </div>
                    </div>

                    @if($cartItems->count())
                    <div class="table-responsive mt-4">
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
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="mdi mdi-delete"></i> Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Order Summary</h5>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span>₦{{ number_format($total, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Tax (10%):</span>
                                        <span>₦{{ number_format($total * 0.1, 2) }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total:</span>
                                        <span>₦{{ number_format($total * 1.1, 2) }}</span>
                                    </div>
                                    <a href="{{ route('buyer.orders.checkout') }}" class="btn btn-primary w-100 mt-3">
                                        <i class="mdi mdi-cart-arrow-right"></i> Proceed to Checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info mt-4">
                        <i class="mdi mdi-cart-off me-2"></i> Your cart is empty.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection