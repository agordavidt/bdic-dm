@extends('layouts.dashboard')

@section('title', 'My Devices')
@section('page-title', 'My Devices')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">My Devices</h4>
                            <p class="card-subtitle card-subtitle-dash">List of all your registered devices</p>
                        </div>
                        <div>
                            <a href="{{ route('buyer.dashboard') }}" class="btn btn-secondary btn-lg text-white mb-0 me-0">
                                <i class="mdi mdi-arrow-left"></i> Back to Dashboard
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Unique Identifier</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($devices as $device)
                                <tr>
                                    <td>{{ $device->display_name ?? $device->model }}</td>
                                    <td>{{ $device->unique_identifier }}</td>
                                    <td>
                                        @if($device->status === 'active')
                                            <span class="badge badge-opacity-success">Active</span>
                                        @elseif($device->status === 'stolen')
                                            <span class="badge badge-opacity-danger">Stolen</span>
                                        @else
                                            <span class="badge badge-opacity-warning">{{ ucfirst($device->status ?? 'N/A') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('buyer.fault_reports.create', ['device' => $device->id]) }}" class="btn btn-sm btn-warning">
                                            <i class="mdi mdi-alert-circle-outline"></i> Report Fault
                                        </a>
                                    </td>
                                </tr>
                                @php
                                    $user = auth()->user();
                                @endphp
                                @if(($device->buyer_name && $user && $device->buyer_name !== $user->name) || ($device->buyer_phone && $user && $device->buyer_phone !== $user->phone))
                                <tr>
                                    <td colspan="4" class="text-warning small">
                                        <i class="mdi mdi-alert"></i> <strong>Note:</strong> This device was registered with buyer info (Name: {{ $device->buyer_name }}, Phone: {{ $device->buyer_phone }}), which differs from your profile. <a href="#" class="text-primary">Update device info?</a>
                                    </td>
                                </tr>
                                @endif
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No devices found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $devices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection