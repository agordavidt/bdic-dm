@extends('layouts.dashboard')

@section('title', 'My Fault Reports')
@section('page-title', 'My Fault Reports')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">My Fault Reports</h4>
                            <p class="card-subtitle card-subtitle-dash">List of all your reported faults</p>
                        </div>
                        <div>
                            <a href="{{ route('buyer.devices.index') }}" class="btn btn-secondary btn-lg text-white mb-0 me-0">
                                <i class="mdi mdi-arrow-left"></i> Back to My Devices
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive mt-4">
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
                                        <td>{{ $report->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('buyer.fault_reports.show', $report) }}" class="btn btn-sm btn-info">
                                                <i class="mdi mdi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No fault reports found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection