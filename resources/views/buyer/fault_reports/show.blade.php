@extends('layouts.dashboard')

@section('title', 'Fault Report Details')
@section('page-title', 'Fault Report Details')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h4 class="card-title card-title-dash">Fault Report Details</h4>
                            <p class="card-subtitle card-subtitle-dash">Details for fault report #{{ $faultReport->id }}</p>
                        </div>
                        <div>
                            <a href="{{ route('buyer.fault_reports.index') }}" class="btn btn-secondary btn-lg text-white mb-0 me-0">
                                <i class="mdi mdi-arrow-left"></i> Back to Reports
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Device:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext">{{ $faultReport->device->model ?? '-' }} ({{ $faultReport->device->unique_identifier ?? '' }})</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Status:</label>
                                <div class="col-sm-8">
                                    @if($faultReport->status === 'pending')
                                        <span class="badge badge-opacity-warning">Pending</span>
                                    @elseif($faultReport->status === 'in_progress')
                                        <span class="badge badge-opacity-primary">In Progress</span>
                                    @elseif($faultReport->status === 'resolved')
                                        <span class="badge badge-opacity-success">Resolved</span>
                                    @else
                                        <span class="badge badge-opacity-secondary">{{ ucfirst($faultReport->status) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Reported At:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext">{{ $faultReport->created_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Description:</label>
                        <div class="card bg-light p-3">
                            {{ $faultReport->description }}
                        </div>
                    </div>

                    @if($faultReport->media && $faultReport->media->count())
                        <div class="form-group mb-4">
                            <label class="form-label">Media:</label>
                            <div class="row">
                                @foreach($faultReport->media as $media)
                                    <div class="col-md-4 mb-3">
                                        @if($media->media_type === 'image')
                                            <img src="{{ asset('storage/' . $media->file_path) }}" alt="Fault Image" class="img-fluid rounded shadow-sm" style="max-width: 100%; max-height: 200px;">
                                        @elseif($media->media_type === 'video')
                                            <video controls style="max-width: 100%; max-height: 200px;">
                                                <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                                                <source src="{{ asset('storage/' . $media->file_path) }}" type="video/quicktime">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection