@extends('layouts.dashboard')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h4 class="card-title card-title-dash">Order #{{ $order->order_number }}</h4>
                            <p class="card-subtitle card-subtitle-dash">Order details and summary</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Order Information</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Date:</label>
                                                <div class="col-sm-8">
                                                    <p class="form-control-plaintext">{{ $order->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Status:</label>
                                                <div class="col-sm-8">
                                                    @if($order->status === 'pending')
                                                        <span class="badge badge-opacity-warning">Pending</span>
                                                    @elseif($order->status === 'processing')
                                                        <span class="badge badge-opacity-primary">Processing</span>
                                                    @elseif($order->status === 'completed')
                                                        <span class="badge badge-opacity-success">Completed</span>
                                                    @elseif($order->status === 'cancelled')
                                                        <span class="badge badge-opacity-danger">Cancelled</span>
                                                    @else
                                                        <span class="badge badge-opacity-secondary">{{ ucfirst($order->status) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Payment Status:</label>
                                                <div class="col-sm-8">
                                                    @if($order->payment_status === 'pending')
                                                        <span class="badge badge-opacity-warning">Pending</span>
                                                    @elseif($order->payment_status === 'paid')
                                                        <span class="badge badge-opacity-success">Paid</span>
                                                    @elseif($order->payment_status === 'failed')
                                                        <span class="badge badge-opacity-danger">Failed</span>
                                                    @else
                                                        <span class="badge badge-opacity-secondary">{{ ucfirst($order->payment_status) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Shipping Address:</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-plaintext">{{ $order->shipping_address }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Billing Address:</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-plaintext">{{ $order->billing_address }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Order Items</h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->orderItems as $item)
                                                <tr>
                                                    <td>{{ $item->product->name ?? '-' }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>₦{{ number_format($item->unit_price, 2) }}</td>
                                                    <td>₦{{ number_format($item->total_price, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Summary</h5>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span>₦{{ number_format($order->subtotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Tax:</span>
                                        <span>₦{{ number_format($order->tax, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Shipping:</span>
                                        <span>₦{{ number_format($order->shipping, 2) }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total:</span>
                                        <span>₦{{ number_format($order->total, 2) }}</span>
                                    </div>

                                    @if($order->canBeCancelled())
                                    <form action="{{ route('buyer.orders.cancel', $order) }}" method="POST" class="mt-3">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="mdi mdi-cancel"></i> Cancel Order
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection