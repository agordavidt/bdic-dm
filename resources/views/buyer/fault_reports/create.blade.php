@extends('layouts.app')

@section('title', 'Report Device Fault')
@section('page-title', 'Report Device Fault')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Report Fault for {{ $device->model }} ({{ $device->unique_identifier }})</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('buyer.fault_reports.store', $device) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="media" class="form-label">Media (Images/Videos)</label>
                    <input type="file" name="media[]" id="media" class="form-control" accept="image/*,video/mp4,video/quicktime" multiple>
                    <small class="form-text text-muted">
                        You can upload multiple images (JPG, PNG) and videos (MP4, MOV).<br>
                        Max file size: 20MB. Max video duration: 30 seconds per file.
                    </small>
                </div>
                <button type="submit" class="btn btn-primary">Submit Fault Report</button>
                <a href="{{ route('devices.show', $device) }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection 