@extends('layouts.app')

@section('title', 'Admin - Order Details')
@section('page-title', 'Order Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Order Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Order Details</h6>
                        <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                        <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ 
                                $order->status === 'delivered' ? 'success' : 
                                ($order->status === 'shipped' ? 'info' : 
                                ($order->status === 'processing' ? 'warning' : 
                                ($order->status === 'cancelled' ? 'danger' : 'secondary'))) 
                            }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                        <p><strong>Payment Status:</strong> 
                            <span class="badge bg-{{ 
                                $order->payment_status === 'paid' ? 'success' : 
                                ($order->payment_status === 'failed' ? 'danger' : 
                                ($order->payment_status === 'refunded' ? 'warning' : 'secondary')) 
                            }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Customer Information</h6>
                        <p><strong>Name:</strong> {{ $order->buyer->name }}</p>
                        <p><strong>Email:</strong> {{ $order->buyer->email }}</p>
                        <p><strong>Phone:</strong> {{ $order->buyer->phone ?? 'N/A' }}</p>
                        <p><strong>Role:</strong> {{ ucfirst($order->buyer->role) }}</p>
                    </div>
                </div>
                
                <hr>
                
                <h6>Order Items</h6>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Vendor</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="me-2" 
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary me-2 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-image text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $item->product->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($item->product->description, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $item->product->vendor->name }}</span>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td><strong>${{ number_format($item->quantity * $item->price, 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Order Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" 
                            class="btn btn-outline-info"
                            onclick="updateOrderStatus({{ $order->id }})">
                        <i class="fas fa-edit"></i> Update Status
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Items</small>
                        <div><strong>{{ $order->orderItems->count() }}</strong></div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Total Amount</small>
                        <div><strong>${{ number_format($order->total, 2) }}</strong></div>
                    </div>
                </div>
                
                <div class="row mt-2">
                    <div class="col-6">
                        <small class="text-muted">Vendors</small>
                        <div><strong>{{ $order->orderItems->groupBy('product.vendor_id')->count() }}</strong></div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Created</small>
                        <div><strong>{{ $order->created_at->format('M d, Y') }}</strong></div>
                    </div>
                </div>
            </div>
        </div>
        
        @if($order->status === 'cancelled')
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cancellation Details</h5>
                </div>
                <div class="card-body">
                    <p><strong>Reason:</strong> {{ $order->cancellation_reason ?? 'No reason provided' }}</p>
                    <p><strong>Cancelled At:</strong> {{ $order->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Order Timeline -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Order Timeline</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Order Placed</h6>
                            <small class="text-muted">{{ $order->created_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                    
                    @if($order->status !== 'pending')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Order Processing</h6>
                                <small class="text-muted">{{ $order->updated_at->format('M d, Y H:i') }}</small>
                            </div>
                        </div>
                    @endif
                    
                    @if(in_array($order->status, ['shipped', 'delivered']))
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Order Shipped</h6>
                                <small class="text-muted">{{ $order->updated_at->format('M d, Y H:i') }}</small>
                            </div>
                        </div>
                    @endif
                    
                    @if($order->status === 'delivered')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Order Delivered</h6>
                                <small class="text-muted">{{ $order->updated_at->format('M d, Y H:i') }}</small>
                            </div>
                        </div>
                    @endif
                    
                    @if($order->status === 'cancelled')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Order Cancelled</h6>
                                <small class="text-muted">{{ $order->updated_at->format('M d, Y H:i') }}</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline::before {
    content: '';
    position: absolute;
    left: -29px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e9ecef;
}
</style>
@endpush

@push('scripts')
<script>
function updateOrderStatus(orderId) {
    const newStatus = prompt('Enter new status (pending, processing, shipped, delivered, cancelled):');
    if (newStatus && ['pending', 'processing', 'shipped', 'delivered', 'cancelled'].includes(newStatus.toLowerCase())) {
        fetch(`/admin/orders/${orderId}/status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ status: newStatus.toLowerCase() })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating order status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating order status');
        });
    }
}
</script>
@endpush 