@extends('layouts.app')

@section('title', 'Vendor Dashboard')
@section('page-title', 'Vendor Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Total Devices</h6>
                <h3>{{ $totalDevices }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Devices Sold</h6>
                <h3>{{ $devicesSold }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Products</h6>
                <h3>{{ $totalProducts }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Fault Reports</h6>
                <h3>{{ $totalFaults }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Pending Faults</h6>
                <h3>{{ $pendingFaults }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Recent Devices</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Model</th>
                                <th>Buyer</th>
                                <th>Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentDevices as $device)
                                <tr>
                                    <td>{{ $device->model }}</td>
                                    <td>{{ $device->buyer_name ?? '-' }}</td>
                                    <td>{{ $device->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No recent devices</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Recent Fault Reports</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Device</th>
                                <th>Status</th>
                                <th>Reported</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentFaults as $fault)
                                <tr>
                                    <td>{{ $fault->device->model ?? '-' }}</td>
                                    <td>{{ ucfirst($fault->status) }}</td>
                                    <td>{{ $fault->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No recent faults</td>
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
