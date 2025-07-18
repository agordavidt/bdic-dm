@extends('layouts.app')

@section('title', 'My Fault Reports')
@section('page-title', 'My Fault Reports')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">My Fault Reports</h2>
    <div class="mb-3 d-flex justify-content-end">
        <a href="{{ route('buyer.devices.index') }}" class="btn btn-secondary">← Back to My Devices</a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Device</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Reported At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td>{{ $report->device->model ?? '-' }}</td>
                                <td>{{ Str::limit($report->description, 40) }}</td>
                                <td>{{ ucfirst($report->status) }}</td>
                                <td>{{ $report->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('buyer.fault_reports.show', $report) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No fault reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 