@extends('layouts.app')

@section('title', 'Fault Report Details')
@section('page-title', 'Fault Report Details')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Fault Report Details</h2>
    <div class="card">
        <div class="card-body">
            <h5>Device: {{ $faultReport->device->model ?? '-' }} ({{ $faultReport->device->unique_identifier ?? '' }})</h5>
            <p><strong>Description:</strong> {{ $faultReport->description }}</p>
            @if($faultReport->media && $faultReport->media->count())
                <div class="mb-3">
                    <strong>Media:</strong>
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
            @if($faultReport->image_path)
                <p><strong>Image:</strong><br>
                    <img src="{{ asset('storage/' . $faultReport->image_path) }}" alt="Fault Image" style="max-width: 300px;">
                </p>
            @endif
            <p><strong>Status:</strong> {{ ucfirst($faultReport->status) }}</p>
            <p><strong>Reported At:</strong> {{ $faultReport->created_at->format('M d, Y H:i') }}</p>
            <a href="{{ route('buyer.fault_reports.index') }}" class="btn btn-secondary mt-3">← Back to My Fault Reports</a>
        </div>
    </div>
</div>
@endsection 