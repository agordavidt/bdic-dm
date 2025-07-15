@extends('layouts.app')

@section('title', 'Admin - Analytics')
@section('page-title', 'Marketplace Analytics')

@section('content')
<!-- Key Metrics -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-left-primary shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total GMV</h6>
                <h3 class="mb-1">₦{{ number_format($metrics['totalGMV'], 2) }}</h3>
                <small class="text-muted">{{ $metrics['gmvGrowth'] > 0 ? '+' : '' }}{{ number_format($metrics['gmvGrowth'], 1) }}% vs last month</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-success shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Orders</h6>
                <h3 class="mb-1">{{ number_format($metrics['totalOrders']) }}</h3>
                <small class="text-muted">{{ $metrics['orderGrowth'] > 0 ? '+' : '' }}{{ number_format($metrics['orderGrowth'], 1) }}% vs last month</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-info shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Active Products</h6>
                <h3 class="mb-1">{{ number_format($metrics['activeProducts']) }}</h3>
                <small class="text-muted">{{ $metrics['productGrowth'] > 0 ? '+' : '' }}{{ number_format($metrics['productGrowth'], 1) }}% vs last month</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-warning shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Active Vendors</h6>
                <h3 class="mb-1">{{ number_format($metrics['activeVendors']) }}</h3>
                <small class="text-muted">{{ $metrics['vendorGrowth'] > 0 ? '+' : '' }}{{ number_format($metrics['vendorGrowth'], 1) }}% vs last month</small>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Revenue Trend (Last 12 Months)</h5>
                <canvas id="revenueChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Top Selling Categories</h5>
                <canvas id="categoriesChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Top Performers -->
<div class="row mb-4">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Top Vendors</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Vendor</th>
                                <th>Products</th>
                                <th>Orders</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topVendors as $vendor)
                                <tr>
                                    <td>
                                        <div>{{ $vendor->name }}</div>
                                        <small class="text-muted">{{ $vendor->email }}</small>
                                    </td>
                                    <td>{{ $vendor->products_count }}</td>
                                    <td>{{ $vendor->orders_count }}</td>
                                    <td>₦{{ number_format($vendor->total_revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No vendor data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Top Products</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Vendor</th>
                                <th>Sales</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $product)
                                <tr>
                                    <td>
                                        <div>{{ $product->name }}</div>
                                        <small class="text-muted">{{ Str::limit($product->description, 30) }}</small>
                                    </td>
                                    <td>{{ $product->vendor->name ?? 'N/A' }}</td>
                                    <td>{{ $product->sales_count }}</td>
                                    <td>₦{{ number_format($product->total_revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No product data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Charts -->
<div class="row mb-4">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Orders by Status</h5>
                <canvas id="orderStatusChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Monthly Growth</h5>
                <canvas id="growthChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Performance Metrics -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Performance Metrics</h5>
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <div class="h4">{{ number_format($metrics['averageOrderValue'], 2) }}</div>
                            <small class="text-muted">Avg Order Value</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <div class="h4">{{ number_format($metrics['conversionRate'], 1) }}%</div>
                            <small class="text-muted">Conversion Rate</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <div class="h4">{{ number_format($metrics['customerRetention'], 1) }}%</div>
                            <small class="text-muted">Customer Retention</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded">
                            <div class="h4">{{ number_format($metrics['productsPerVendor'], 1) }}</div>
                            <small class="text-muted">Products per Vendor</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Natural color palette
    const colors = {
        blue: '#3498db',
        green: '#2ecc71',
        yellow: '#f1c40f',
        red: '#e74c3c',
        purple: '#9b59b6',
        orange: '#e67e22',
        teal: '#1abc9c'
    };

    // Revenue Trend Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: @json($revenueData['labels']),
            datasets: [{
                label: 'Revenue',
                data: @json($revenueData['data']),
                borderColor: colors.blue,
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₦' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
    
    // Categories Chart
    new Chart(document.getElementById('categoriesChart'), {
        type: 'doughnut',
        data: {
            labels: @json($categoriesData['labels']),
            datasets: [{
                data: @json($categoriesData['data']),
                backgroundColor: [
                    colors.blue,
                    colors.green,
                    colors.yellow,
                    colors.red,
                    colors.purple
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
    
    // Order Status Chart
    new Chart(document.getElementById('orderStatusChart'), {
        type: 'bar',
        data: {
            labels: ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
            datasets: [{
                data: @json($orderStatusData),
                backgroundColor: [
                    colors.yellow,
                    colors.blue,
                    colors.purple,
                    colors.green,
                    colors.red
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
    
    // Growth Chart
    new Chart(document.getElementById('growthChart'), {
        type: 'line',
        data: {
            labels: @json($growthData['labels']),
            datasets: [
                {
                    label: 'Orders Growth',
                    data: @json($growthData['orders']),
                    borderColor: colors.green,
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    tension: 0.3
                },
                {
                    label: 'Revenue Growth',
                    data: @json($growthData['revenue']),
                    borderColor: colors.blue,
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: value => value + '%' }
                }
            }
        }
    });
});
</script>
@endpush