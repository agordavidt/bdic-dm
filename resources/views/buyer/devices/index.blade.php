@extends('layouts.app')

@section('title', 'My Devices')
@section('page-title', 'My Devices')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0"></h2>
        <a href="{{ route('buyer.dashboard') }}" class="btn btn-secondary">&larr; Back to Dashboard</a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
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
                            <td>{{ ucfirst($device->status ?? 'N/A') }}</td>
                            <td>
                                <a href="{{ route('buyer.fault_reports.create', ['device' => $device->id]) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Report Fault
                                </a>
                            </td>
                        </tr>
                        @php
                            $user = auth()->user();
                        @endphp
                        @if(($device->buyer_name && $user && $device->buyer_name !== $user->name) || ($device->buyer_phone && $user && $device->buyer_phone !== $user->phone))
                        <tr>
                            <td colspan="4" class="text-warning small">
                                <strong>Note:</strong> This device was registered with buyer info (Name: {{ $device->buyer_name }}, Phone: {{ $device->buyer_phone }}), which differs from your profile. <a href="#" class="text-primary">Update device info?</a>
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No devices found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $devices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 