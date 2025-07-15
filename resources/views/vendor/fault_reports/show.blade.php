@extends('layouts.app')

@section('title', 'Fault Report Details')
@section('page-title', 'Fault Report Details')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Fault Report Details</h2>
    <div class="card">
        <div class="card-body">
            <h5>Device: {{ $faultReport->device->model ?? '-' }} ({{ $faultReport->device->unique_identifier ?? '' }})</h5>
            <p><strong>Buyer:</strong> {{ $faultReport->user->name ?? '-' }}</p>
            <p><strong>Description:</strong> {{ $faultReport->description }}</p>
            @if($faultReport->image_path)
                <p><strong>Image:</strong><br>
                    <img src="{{ asset('storage/' . $faultReport->image_path) }}" alt="Fault Image" style="max-width: 300px;">
                </p>
            @endif
            <p><strong>Status:</strong> {{ ucfirst($faultReport->status) }}</p>
            <p><strong>Reported At:</strong> {{ $faultReport->created_at->format('M d, Y H:i') }}</p>
            @if($faultReport->status === 'open')
                <form action="{{ route('vendor.fault_reports.resolve', $faultReport) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">Mark as Resolved</button>
                </form>
            @endif
            <a href="{{ route('vendor.fault_reports.index') }}" class="btn btn-secondary mt-3">← Back to Fault Reports</a>
        </div>
    </div>
</div>
@endsection 