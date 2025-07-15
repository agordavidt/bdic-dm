@extends('layouts.app')

@section('title', 'Admin - Product Details')
@section('page-title', 'Product Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid rounded">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center rounded" 
                                 style="height: 200px;">
                                <i class="fas fa-image text-white fa-3x"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h4>{{ $product->name }}</h4>
                        <p class="text-muted">{{ $product->description }}</p>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <strong>Price:</strong> ${{ number_format($product->price, 2) }}
                            </div>
                            <div class="col-md-6">
                                <strong>Stock:</strong> 
                                <span class="badge bg-{{ $product->stock_quantity > 10 ? 'success' : ($product->stock_quantity > 0 ? 'warning' : 'danger') }}">
                                    {{ $product->stock_quantity }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <strong>Status:</strong> 
                                <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ $product->status === 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <strong>Category:</strong> 
                                @if($product->category)
                                    <span class="badge bg-info">{{ $product->category->name }}</span>
                                @else
                                    <span class="text-muted">No category</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <strong>Created:</strong> {{ $product->created_at->format('M d, Y H:i') }}
                            </div>
                            <div class="col-md-6">
                                <strong>Updated:</strong> {{ $product->updated_at->format('M d, Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Vendor Information</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                         style="width: 50px; height: 50px;">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $product->vendor->name }}</h6>
                        <small class="text-muted">{{ $product->vendor->email }}</small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Role</small>
                        <div><strong>{{ ucfirst($product->vendor->role) }}</strong></div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Joined</small>
                        <div><strong>{{ $product->vendor->created_at->format('M d, Y') }}</strong></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" 
                            class="btn btn-{{ $product->status === 'active' ? 'warning' : 'success' }}"
                            onclick="toggleProductStatus({{ $product->id }})">
                        <i class="fas fa-{{ $product->status === 'active' ? 'pause' : 'play' }}"></i>
                        {{ $product->status === 'active' ? 'Deactivate' : 'Activate' }} Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales History -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Sales History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Order Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product->orderItems as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $item->order) }}" 
                                           class="text-decoration-none">
                                            #{{ $item->order->id }}
                                        </a>
                                    </td>
                                    <td>{{ $item->order->buyer->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $item->order->status === 'delivered' ? 'success' : 
                                            ($item->order->status === 'shipped' ? 'info' : 
                                            ($item->order->status === 'processing' ? 'warning' : 
                                            ($item->order->status === 'cancelled' ? 'danger' : 'secondary'))) 
                                        }}">
                                            {{ ucfirst($item->order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $item->order->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No sales history available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleProductStatus(productId) {
    if (confirm('Are you sure you want to change this product\'s status?')) {
        fetch(`/admin/products/${productId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating product status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating product status');
        });
    }
}
</script>
@endpush 