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