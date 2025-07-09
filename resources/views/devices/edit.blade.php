@extends('layouts.app')

@section('title', 'Edit Device')
@section('page-title', 'Edit Device')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Device</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('devices.update', $device) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="device_type" class="form-label">Device Type</label>
                                <input type="text" class="form-control" id="device_type" name="device_type" value="{{ $device->device_type }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" class="form-control" id="model" name="model" value="{{ $device->model }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                <input type="text" class="form-control" id="brand" name="brand" value="{{ $device->brand }}">
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $device->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ $device->price }}">
                            </div>
                            <div class="mb-3">
                                <label for="warranty_expiry" class="form-label">Warranty Expiry</label>
                                <input type="date" class="form-control" id="warranty_expiry" name="warranty_expiry" value="{{ $device->warranty_expiry }}">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active" {{ $device->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="needs_attention" {{ $device->status == 'needs_attention' ? 'selected' : '' }}>Needs Attention</option>
                                    <option value="replacement_needed" {{ $device->status == 'replacement_needed' ? 'selected' : '' }}>Replacement Needed</option>
                                    <option value="stolen" {{ $device->status == 'stolen' ? 'selected' : '' }}>Stolen</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
