@extends('layouts.app')

@section('title', 'My Devices')
@section('page-title', 'My Devices')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">My Devices</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="mb-3">
                    <a href="{{ route('vendor.devices.create') }}" class="btn btn-primary">Register New Device</a>
                </div>

                <form method="GET" action="{{ route('vendor.devices.index') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="needs_attention" {{ request('status') == 'needs_attention' ? 'selected' : '' }}>Needs Attention</option>
                                <option value="replacement_needed" {{ request('status') == 'replacement_needed' ? 'selected' : '' }}>Replacement Needed</option>
                                <option value="stolen" {{ request('status') == 'stolen' ? 'selected' : '' }}>Stolen</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="buyer_category" class="form-select">
                                <option value="">All Buyer Categories</option>
                                <option value="individual" {{ request('buyer_category') == 'individual' ? 'selected' : '' }}>Individual</option>
                                <option value="institution" {{ request('buyer_category') == 'institution' ? 'selected' : '' }}>Institution</option>
                                <option value="corporate" {{ request('buyer_category') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="category_id" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Unique Identifier</th>
                                <th>Model</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($devices as $device)
                                <tr>
                                    <td>{{ $device->unique_identifier }}</td>
                                    <td>{{ $device->model }}</td>
                                    <td>{{ $device->brand }}</td>
                                    <td>{{ $device->category->name }}</td>
                                    <td>{{ ucfirst($device->status) }}</td>
                                    <td>
                                        <a href="{{ route('vendor.devices.show', $device) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('vendor.devices.edit', $device) }}" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $devices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 