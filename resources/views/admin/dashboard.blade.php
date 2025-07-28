@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="content-wrapper">
    <!-- User Statistics Section -->
    <div class="row">
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="statistics-title">Total Users</p>
                            <h3 class="rate-percentage">{{ $totalUsers }}</h3>
                        </div>
                        <div>
                            <i class="mdi mdi-account-multiple text-primary icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="statistics-title">Vendors</p>
                            <h3 class="rate-percentage">{{ $totalVendors }}</h3>
                        </div>
                        <div>
                            <i class="mdi mdi-store text-info icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="statistics-title">Buyers</p>
                            <h3 class="rate-percentage">{{ $totalBuyers }}</h3>
                        </div>
                        <div>
                            <i class="mdi mdi-account-outline text-success icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="statistics-title">Total Devices</p>
                            <h3 class="rate-percentage">{{ $totalDevices }}</h3>
                        </div>
                        <div>
                            <i class="mdi mdi-devices text-warning icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- E-commerce Analytics Section -->
    <div class="row">
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-rounded bg-primary-gradient">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="statistics-title">Total Products</p>
                            <h3 class="rate-percentage text-white">{{ $totalProducts }}</h3>
                        </div>
                        <div>
                            <i class="mdi mdi-package-variant-closed text-white icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-rounded bg-success-gradient">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="statistics-title">Total Orders</p>
                            <h3 class="rate-percentage text-white">{{ $totalOrders }}</h3>
                        </div>
                        <div>
                            <i class="mdi mdi-cart-outline text-white icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-rounded bg-info-gradient">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="statistics-title">Total GMV</p>
                            <h3 class="rate-percentage text-white">${{ number_format($totalGMV, 2) }}</h3>
                        </div>
                        <div>
                            <i class="mdi mdi-currency-usd text-white icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-rounded bg-warning-gradient">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="statistics-title">Active Vendors</p>
                            <h3 class="rate-percentage text-white">{{ $activeVendors }}</h3>
                        </div>
                        <div>
                            <i class="mdi mdi-store-check text-white icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Recent User Registrations</h4>
                            <p class="card-subtitle card-subtitle-dash">Newly registered users</p>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRegistrations as $registration)
                                <tr>
                                    <td>{{ $registration->name }}</td>
                                    <td>{{ $registration->email }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($registration->role === 'admin') badge-opacity-danger
                                            @elseif($registration->role === 'vendor') badge-opacity-info
                                            @else badge-opacity-success @endif">
                                            {{ ucfirst($registration->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $registration->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No recent registrations</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Recent Orders</h4>
                            <p class="card-subtitle card-subtitle-dash">Latest customer orders</p>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->buyer->name }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($order->status === 'delivered') badge-opacity-success
                                            @elseif($order->status === 'pending') badge-opacity-warning
                                            @else badge-opacity-secondary @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No recent orders</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Selling Categories -->
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Top Selling Categories</h4>
                            <p class="card-subtitle card-subtitle-dash">Most popular product categories</p>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Products</th>
                                    <th>Orders</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topCategories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->products_count }}</td>
                                    <td>0</td>
                                    <td>$0.00</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No category data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection