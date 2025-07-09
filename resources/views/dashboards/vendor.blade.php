@extends('layouts.app')

@section('title', 'Vendor Dashboard')
@section('page-title', 'Vendor Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Devices</h5>
                <h2>{{ $totalDevices }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Devices Sold</h5>
                <h2>{{ $devicesSold }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pending Reports</h5>
                <h2>{{ $pendingReports }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Monthly Sales</h5>
                <h2>₦{{ number_format($monthlySales) }}</h2>
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
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Device</th>
                                <th>Buyer</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities as $activity)
                                <tr>
                                    <td>{{ $activity->device->model }}</td>
                                    <td>{{ $activity->buyer->name }}</td>
                                    <td>{{ $activity->created_at->format('M d, Y') }}</td>
                                    <td>{{ ucfirst($activity->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No recent activities</td>
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
