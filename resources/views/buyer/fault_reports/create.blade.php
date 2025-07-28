@extends('layouts.dashboard')

@section('title', 'Report Device Fault')
@section('page-title', 'Report Device Fault')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Report Fault for {{ $device->model }} ({{ $device->unique_identifier }})</h4>
                            <p class="card-subtitle card-subtitle-dash">Please provide details about the fault you're experiencing</p>
                        </div>
                    </div>

                    <form action="{{ route('buyer.fault_reports.store', $device) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="media" class="form-label">Media (Images/Videos)</label>
                            <input type="file" name="media[]" id="media" class="form-control" accept="image/*,video/mp4,video/quicktime" multiple>
                            <small class="form-text text-muted">
                                You can upload multiple images (JPG, PNG) and videos (MP4, MOV).<br>
                                Max file size: 20MB. Max video duration: 30 seconds per file.
                            </small>
                        </div>
                        
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="mdi mdi-send"></i> Submit Fault Report
                            </button>
                            <a href="{{ route('devices.show', $device) }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection