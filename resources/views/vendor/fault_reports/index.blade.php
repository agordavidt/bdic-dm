@extends('layouts.app')

@section('title', 'Device Fault Reports')
@section('page-title', 'Device Fault Reports')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Device Fault Reports</h2>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Device</th>
                            <th>Buyer</th>
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
                                <td>{{ $report->user->name ?? '-' }}</td>
                                <td>{{ Str::limit($report->description, 40) }}</td>
                                <td>{{ ucfirst($report->status) }}</td>
                                <td>{{ $report->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('vendor.fault_reports.show', $report) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No fault reports found.</td>
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