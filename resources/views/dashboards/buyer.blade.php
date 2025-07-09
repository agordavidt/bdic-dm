@extends('layouts.app')

@section('title', 'Buyer Dashboard')
@section('page-title', 'Buyer Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Owned Devices</h5>
                <h2>{{ $ownedDevices }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Active Reports</h5>
                <h2>{{ $activeReports }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Resolved Reports</h5>
                <h2>{{ $resolvedReports }}</h2>
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
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Model</th>
                                <th>Brand</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($devices as $device)
                                <tr>
                                    <td>{{ $device->model }}</td>
                                    <td>{{ $device->brand }}</td>
                                    <td>{{ ucfirst($device->status) }}</td>
                                    <td>
                                        <a href="{{ route('devices.show', $device) }}" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No devices found</td>
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
