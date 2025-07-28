@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="content-wrapper">
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
                            <i class="mdi mdi-account text-success icon-lg"></i>
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

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
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
    </div>
</div>
@endsection