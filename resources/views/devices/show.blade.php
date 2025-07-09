@extends('layouts.app')

@section('title', 'Device Details')
@section('page-title', 'Device Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Device Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Device Information</h5>
                        <p><strong>Unique Identifier:</strong> {{ $device->unique_identifier }}</p>
                        <p><strong>Device Type:</strong> {{ $device->device_type }}</p>
                        <p><strong>Model:</strong> {{ $device->model }}</p>
                        <p><strong>Brand:</strong> {{ $device->brand }}</p>
                        <p><strong>Category:</strong> {{ $device->category->name }}</p>
                        <p><strong>Price:</strong> {{ $device->price }}</p>
                        <p><strong>Warranty Expiry:</strong> {{ $device->warranty_expiry }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($device->status) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Buyer Information</h5>
                        @if($device->buyer)
                            <p><strong>Name:</strong> {{ $device->buyer->name }}</p>
                            <p><strong>Email:</strong> {{ $device->buyer->email }}</p>
                        @endif
                        @if($device->buyerProfile)
                            <p><strong>Phone:</strong> {{ $device->buyerProfile->phone }}</p>
                            <p><strong>Address:</strong> {{ $device->buyerProfile->address }}, {{ $device->buyerProfile->city }}, {{ $device->buyerProfile->state }}, {{ $device->buyerProfile->country }}</p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h5>Update Status</h5>
                        <form action="{{ route('devices.update-status', $device) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <select name="status" class="form-select">
                                    <option value="active" {{ $device->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="needs_attention" {{ $device->status == 'needs_attention' ? 'selected' : '' }}>Needs Attention</option>
                                    <option value="replacement_needed" {{ $device->status == 'replacement_needed' ? 'selected' : '' }}>Replacement Needed</option>
                                    <option value="stolen" {{ $device->status == 'stolen' ? 'selected' : '' }}>Stolen</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <h5>Transfer Device</h5>
                        <form action="{{ route('devices.transfer', $device) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="buyer_email" class="form-label">Buyer Email</label>
                                <input type="email" class="form-control" id="buyer_email" name="buyer_email" required>
                            </div>
                            <div class="mb-3">
                                <label for="transfer_type" class="form-label">Transfer Type</label>
                                <select name="transfer_type" class="form-select" required>
                                    <option value="sale">Sale</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="return">Return</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01">
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Transfer Device</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
