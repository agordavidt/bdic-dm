<!-- @if(auth()->user()->isBuyer() && $device->buyer_id === auth()->id())
    <div class="mb-3">
        <a href="{{ route('buyer.fault_reports.create', $device) }}" class="btn btn-danger me-2">Report Fault</a>
        @if($device->status !== 'stolen')
            <form action="{{ route('devices.update-status', $device) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="stolen">
                <button type="submit" class="btn btn-warning">Flag as Stolen</button>
            </form>
        @else
            <span class="badge bg-danger">Device flagged as stolen</span>
        @endif
    </div>
@endif  -->



@extends('layouts.dashboard')

@section('title', 'Device Details')
@section('page-title', 'Device Details')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    @if(auth()->user()->isBuyer() && $device->buyer_id === auth()->id())
                    <div class="d-flex mb-4">
                        <a href="{{ route('buyer.fault_reports.create', $device) }}" class="btn btn-danger me-2">
                            <i class="mdi mdi-alert-circle-outline"></i> Report Fault
                        </a>
                        @if($device->status !== 'stolen')
                            <form action="{{ route('devices.update-status', $device) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="stolen">
                                <button type="submit" class="btn btn-warning">
                                    <i class="mdi mdi-flag"></i> Flag as Stolen
                                </button>
                            </form>
                        @else
                            <span class="badge badge-opacity-danger">
                                <i class="mdi mdi-alert"></i> Device flagged as stolen
                            </span>
                        @endif
                    </div>
                    @endif
                    
                    <!-- Add your device details content here -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Device Name:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext">{{ $device->display_name ?? $device->model }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Unique ID:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext">{{ $device->unique_identifier }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Status:</label>
                                <div class="col-sm-8">
                                    @if($device->status === 'active')
                                        <span class="badge badge-opacity-success">Active</span>
                                    @elseif($device->status === 'stolen')
                                        <span class="badge badge-opacity-danger">Stolen</span>
                                    @else
                                        <span class="badge badge-opacity-warning">{{ ucfirst($device->status ?? 'N/A') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Add more device details as needed -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection