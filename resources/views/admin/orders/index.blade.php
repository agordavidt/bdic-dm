@extends('layouts.app')

@section('title', 'Order Management')
@section('page-title', 'Order Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">All Orders</h5>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm" id="statusFilter">
                                <option value="">All Status</option>
                                @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            <select class="form-select form-select-sm" id="paymentFilter">
                                <option value="">All Payment Status</option>
                                @foreach(['pending', 'paid', 'failed', 'refunded'] as $status)
                                    <option value="{{ $status }}" {{ request('payment_status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control form-control-sm" id="searchInput" 
                                   placeholder="Search..." value="{{ request('search') }}">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Vendor</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>
                                            <div>{{ $order->buyer->name }}</div>
                                            <small class="text-muted">{{ $order->buyer->email }}</small>
                                        </td>
                                        <td>{{ $order->vendor->name ?? 'N/A' }}</td>
                                        <td>{{ $order->orderItems->count() }}</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>{{ ucfirst($order->status) }}</td>
                                        <td>{{ ucfirst($order->payment_status) }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No orders found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($orders->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @foreach($stats as $key => $value)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="card-subtitle mb-2 text-muted">{{ ucfirst(str_replace('_', ' ', $key)) }}</h6>
                        <h3 class="card-title">
                            @if($key === 'totalRevenue')
                                ${{ number_format($value, 2) }}
                            @else
                                {{ $value }}
                            @endif
                        </h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('statusFilter');
    const paymentFilter = document.getElementById('paymentFilter');
    const searchInput = document.getElementById('searchInput');
    
    function updateFilters() {
        const params = new URLSearchParams();
        
        if (statusFilter.value) params.set('status', statusFilter.value);
        if (paymentFilter.value) params.set('payment_status', paymentFilter.value);
        if (searchInput.value) params.set('search', searchInput.value);
        
        window.location.href = window.location.pathname + '?' + params.toString();
    }
    
    statusFilter.addEventListener('change', updateFilters);
    paymentFilter.addEventListener('change', updateFilters);
    
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(updateFilters, 500);
    });
});
</script>
@endpush