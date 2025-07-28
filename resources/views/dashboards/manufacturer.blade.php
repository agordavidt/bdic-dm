@extends('layouts.dashboard')

@section('title', 'Manufacturer Dashboard')
@section('page-title', 'Manufacturer Dashboard')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="statistics-title">Total Devices</p>
                            <h3 class="rate-percentage">{{ $totalDevices }}</h3>
                        </div>
                        <div>
                            <i class="mdi mdi-devices text-primary icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="statistics-title">Fault Reports</p>
                            <h3 class="rate-percentage">{{ $faultReports }}</h3>
                        </div>
                        <div>
                            <i class="mdi mdi-alert-circle-outline text-danger icon-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="statistics-title">Performance</p>
                            <h3 class="rate-percentage">95%</h3>
                        </div>
                        <div>
                            <i class="mdi mdi-chart-line text-success icon-lg"></i>
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
                            <h4 class="card-title card-title-dash">Recent Fault Reports</h4>
                            <p class="card-subtitle card-subtitle-dash">Latest reported device issues</p>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
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
                                    <td>
                                        @if($report->status === 'pending')
                                            <span class="badge badge-opacity-warning">Pending</span>
                                        @elseif($report->status === 'in_progress')
                                            <span class="badge badge-opacity-primary">In Progress</span>
                                        @elseif($report->status === 'resolved')
                                            <span class="badge badge-opacity-success">Resolved</span>
                                        @else
                                            <span class="badge badge-opacity-secondary">{{ ucfirst($report->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No recent fault reports</td>
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