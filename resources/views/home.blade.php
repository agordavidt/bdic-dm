@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Welcome, {{ $user->name }}! You are logged in as a {{ ucfirst($user->role) }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
</div>

@if($user->role == 'admin')
    <!-- Admin Dashboard -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <h2>{{ $dashboardData['total_users'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Vendors</h5>
                    <h2>{{ $dashboardData['total_vendors'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Buyers</h5>
                    <h2>{{ $dashboardData['total_buyers'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Devices</h5>
                    <h2>0</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
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
                                    <td>{{ ucfirst($registration->role) }}</td>
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
    </div>

@elseif($user->role == 'vendor')
    <!-- Vendor Dashboard -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Devices</h5>
                    <h2>{{ $dashboardData['total_devices'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Devices Sold</h5>
                    <h2>{{ $dashboardData['devices_sold'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pending Reports</h5>
                    <h2>{{ $dashboardData['pending_reports'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Monthly Sales</h5>
                    <h2>₦{{ number_format($dashboardData['monthly_sales']) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Activities</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <p class="text-muted mt-2">No recent activities</p>
                        <small class="text-muted">Device management features coming in next batch</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@elseif($user->role == 'buyer')
    <!-- Buyer Dashboard -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Owned Devices</h5>
                    <h2>{{ $dashboardData['owned_devices'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Active Reports</h5>
                    <h2>{{ $dashboardData['active_reports'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Resolved Reports</h5>
                    <h2>{{ $dashboardData['resolved_reports'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">My Devices</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <p class="text-muted mt-2">No devices registered</p>
                        <small class="text-muted">Device management features coming in next batch</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@else
    <!-- Manufacturer Dashboard -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Devices</h5>
                    <h2>{{ $dashboardData['total_devices'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Fault Reports</h5>
                    <h2>{{ $dashboardData['fault_reports'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Performance</h5>
                    <h2>95%</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Fault Reports</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <p class="text-muted mt-2">No recent fault reports</p>
                        <small class="text-muted">Reporting features coming in next batch</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
