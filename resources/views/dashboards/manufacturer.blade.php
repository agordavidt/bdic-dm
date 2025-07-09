@extends('layouts.app')

@section('title', 'Manufacturer Dashboard')
@section('page-title', 'Manufacturer Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Devices</h5>
                <h2>{{ $totalDevices }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Fault Reports</h5>
                <h2>{{ $faultReports }}</h2>
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
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Device</th>
                                <th>Reported By</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentFaultReports as $report)
                                <tr>
                                    <td>{{ $report->device->model }}</td>
                                    <td>{{ $report->user->name }}</td>
                                    <td>{{ $report->created_at->format('M d, Y') }}</td>
                                    <td>{{ ucfirst($report->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No recent fault reports</td>
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
