@extends('layouts.app')

@section('title', 'Admin - Product Catalog')
@section('page-title', 'Product Catalog Management')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <!-- Statistics as a simple list -->
        <ul class="list-group mb-4">
            <li class="list-group-item">Total Products: <strong>{{ $stats['total'] }}</strong></li>
            <li class="list-group-item">Active Products: <strong>{{ $stats['active'] }}</strong></li>
            <li class="list-group-item">Low Stock: <strong>{{ $stats['lowStock'] }}</strong></li>
            <li class="list-group-item">Active Vendors: <strong>{{ $stats['activeVendors'] }}</strong></li>
        </ul>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">All Products</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <select class="form-select form-select-sm" id="vendorFilter">
                        <option value="">All Vendors</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Search products...">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="productsTable">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Vendor</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($product->main_image)
                                                <img src="{{ asset('storage/' . $product->main_image) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="me-2" 
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="me-2 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px; background: #f0f0f0;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $product->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $product->vendor->name }}
                                    </td>
                                    <td>
                                        @if($product->category)
                                            {{ $product->category->name }}
                                        @else
                                            <span class="text-muted">No category</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>${{ number_format($product->price, 2) }}</strong>
                                    </td>
                                    <td>
                                        {{ $product->stock_quantity }}
                                    </td>
                                    <td>
                                        {{ ucfirst($product->status) }}
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $product->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.products.show', $product) }}" 
                                               class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-secondary"
                                                    onclick="toggleProductStatus({{ $product->id }})">
                                                <i class="fas fa-{{ $product->status === 'active' ? 'pause' : 'play' }}"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No products found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('statusFilter');
    const vendorFilter = document.getElementById('vendorFilter');
    const searchInput = document.getElementById('searchInput');
    
    function filterProducts() {
        const status = statusFilter.value;
        const vendor = vendorFilter.value;
        const search = searchInput.value;
        
        const url = new URL(window.location);
        if (status) url.searchParams.set('status', status);
        else url.searchParams.delete('status');
        
        if (vendor) url.searchParams.set('vendor', vendor);
        else url.searchParams.delete('vendor');
        
        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');
        
        window.location.href = url.toString();
    }
    
    statusFilter.addEventListener('change', filterProducts);
    vendorFilter.addEventListener('change', filterProducts);
    
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(filterProducts, 500);
    });
});

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