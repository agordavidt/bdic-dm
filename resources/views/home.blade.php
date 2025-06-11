@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle"></i>
            <strong>Welcome, {{ $user->name }}!</strong> 
            You are logged in as a <strong>{{ ucfirst($user->role) }}</strong>.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
</div>

@if($user->role == 'admin')
    <!-- Admin Dashboard -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Users</h5>
                            <h2>{{ $dashboardData['total_users'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-people fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Vendors</h5>
                            <h2>{{ $dashboardData['total_vendors'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-shop fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Buyers</h5>
                            <h2>{{ $dashboardData['total_buyers'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-person-check fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Devices</h5>
                            <h2>0</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-device-hdd fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent User Registrations</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
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
                                @forelse($dashboardData['recent_registrations'] as $registration)
                                <tr>
                                    <td>{{ $registration->name }}</td>
                                    <td>{{ $registration->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $registration->role == 'vendor' ? 'success' : 'info' }}">
                                            {{ ucfirst($registration->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $registration->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No recent registrations</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" disabled>
                            <i class="bi bi-people-fill"></i> Manage Users
                        </button>
                        <button class="btn btn-success" disabled>
                            <i class="bi bi-device-hdd"></i> View All Devices
                        </button>
                        <button class="btn btn-info" disabled>
                            <i class="bi bi-bar-chart"></i> Analytics Dashboard
                        </button>
                        <button class="btn btn-warning" disabled>
                            <i class="bi bi-exclamation-triangle"></i> System Reports
                        </button>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="bi bi-info-circle"></i> Features will be enabled in upcoming batches
                    </small>
                </div>
            </div>
        </div>
    </div>

@elseif($user->role == 'vendor')
    <!-- Vendor Dashboard -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Devices</h5>
                            <h2>{{ $dashboardData['total_devices'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-device-hdd fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Devices Sold</h5>
                            <h2>{{ $dashboardData['devices_sold'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-cart-check fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Pending Reports</h5>
                            <h2>{{ $dashboardData['pending_reports'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-exclamation-triangle fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Monthly Sales</h5>
                            <h2>₦{{ number_format($dashboardData['monthly_sales']) }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-currency-dollar fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Activities</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2">No recent activities</p>
                        <small class="text-muted">Device management features coming in next batch</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" disabled>
                            <i class="bi bi-plus-circle"></i> Register Device
                        </button>
                        <button class="btn btn-success" disabled>
                            <i class="bi bi-list"></i> View My Devices
                        </button>
                        <button class="btn btn-info" disabled>
                            <i class="bi bi-bar-chart"></i> Sales Analytics
                        </button>
                        <button class="btn btn-warning" disabled>
                            <i class="bi bi-exclamation-triangle"></i> View Reports
                        </button>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="bi bi-info-circle"></i> Features will be enabled in upcoming batches
                    </small>
                </div>
            </div>
        </div>
    </div>

@elseif($user->role == 'buyer')
    <!-- Buyer Dashboard -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Owned Devices</h5>
                            <h2>{{ $dashboardData['owned_devices'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-device-hdd fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Active Reports</h5>
                            <h2>{{ $dashboardData['active_reports'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-exclamation-triangle fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Resolved Reports</h5>
                            <h2>{{ $dashboardData['resolved_reports'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-check-circle fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">My Devices</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="bi bi-device-hdd fs-1 text-muted"></i>
                        <p class="text-muted mt-2">No devices registered</p>
                        <small class="text-muted">Device management features coming in next batch</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" disabled>
                            <i class="bi bi-plus-circle"></i> Register Device
                        </button>
                        <button class="btn btn-danger" disabled>
                            <i class="bi bi-exclamation-triangle"></i> Report Fault
                        </button>
                        <button class="btn btn-warning" disabled>
                            <i class="bi bi-shield-exclamation"></i> Report Stolen
                        </button>
                        <button class="btn btn-info" disabled>
                            <i class="bi bi-cart"></i> Browse Devices
                        </button>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="bi bi-info-circle"></i> Features will be enabled in upcoming batches
                    </small>
                </div>
            </div>
        </div>
    </div>

@else
    <!-- Manufacturer Dashboard -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Devices</h5>
                            <h2>{{ $dashboardData['total_devices'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-device-hdd fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Fault Reports</h5>
                            <h2>{{ $dashboardData['fault_reports'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-exclamation-triangle fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Performance</h5>
                            <h2>95%</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-graph-up fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Fault Reports</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2">No recent fault reports</p>
                        <small class="text-muted">Reporting features coming in next batch</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" disabled>
                            <i class="bi bi-bar-chart"></i> View Analytics
                        </button>
                        <button class="btn btn-warning" disabled>
                            <i class="bi bi-exclamation-triangle"></i> Fault Dashboard
                        </button>
                        <button class="btn btn-info" disabled>
                            <i class="bi bi-geo-alt"></i> Tracking Dashboard
                        </button>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="bi bi-info-circle"></i> Features will be enabled in upcoming batches
                    </small>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
