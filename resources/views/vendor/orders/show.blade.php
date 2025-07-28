@extends('layouts.dashboard')

@section('title', 'Order Details')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active ps-0" id="order-tab" data-bs-toggle="tab" href="#order" role="tab" aria-controls="order" aria-selected="true">
              Order #{{ $order->order_number }}
            </a>
          </li>
        </ul>
        <div>
          <a href="{{ route('vendor.orders.index') }}" class="btn btn-primary text-white me-0">
            <i class="mdi mdi-arrow-left"></i> Back to Orders
          </a>
        </div>
      </div>

      <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="order" role="tabpanel" aria-labelledby="order">
          <div class="row">
            <div class="col-lg-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Order Information</h4>
                  <div class="row">
                    <div class="col-md-6">
                      <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                      <p><strong>Status:</strong> 
                        <span class="badge badge-opacity-{{ 
                          $order->status == 'pending' ? 'warning' : 
                          ($order->status == 'completed' ? 'success' : 'primary')
                        }}">
                          {{ ucfirst($order->status) }}
                        </span>
                      </p>
                    </div>
                    <div class="col-md-6">
                      <p><strong>Payment Status:</strong> 
                        <span class="badge badge-opacity-{{ 
                          $order->payment_status == 'paid' ? 'success' : 'danger'
                        }}">
                          {{ ucfirst($order->payment_status) }}
                        </span>
                      </p>
                      <p><strong>Buyer:</strong> {{ $order->buyer->name ?? '-' }}</p>
                    </div>
                  </div>
                  
                  <div class="row mt-4">
                    <div class="col-md-6">
                      <h5 class="mb-3">Shipping Address</h5>
                      <p>{{ $order->shipping_address }}</p>
                    </div>
                    <div class="col-md-6">
                      <h5 class="mb-3">Billing Address</h5>
                      <p>{{ $order->billing_address }}</p>
                    </div>
                  </div>
                  
                  <h4 class="card-title mt-4">Order Items</h4>
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
            
            <div class="col-lg-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Order Summary</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>Subtotal</td>
                          <td>₦{{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                          <td>Tax</td>
                          <td>₦{{ number_format($order->tax, 2) }}</td>
                        </tr>
                        <tr>
                          <td>Shipping</td>
                          <td>₦{{ number_format($order->shipping, 2) }}</td>
                        </tr>
                        <tr class="border-top">
                          <td><strong>Total</strong></td>
                          <td><strong>₦{{ number_format($order->total, 2) }}</strong></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  
                  @if($order->status == 'pending')
                  <div class="mt-4">
                    <button class="btn btn-success me-2">Mark as Completed</button>
                    <button class="btn btn-danger">Cancel Order</button>
                  </div>
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