@extends('layouts.dashboard')

@section('title', 'My Devices')
@section('page-title', 'My Devices')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">My Devices</h4>
                            <p class="card-subtitle card-subtitle-dash">Manage your registered devices</p>
                        </div>
                        <div>
                            <a href="{{ route('vendor.devices.create') }}" class="btn btn-primary btn-lg text-white mb-0 me-0">
                                <i class="mdi mdi-plus-circle-outline"></i> Register New Device
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <i class="mdi mdi-alert-circle-outline me-2"></i> {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="GET" action="{{ route('vendor.devices.index') }}" class="mt-4">
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
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive mt-4">
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
                                        <td>
                                            @if($device->status === 'active')
                                                <span class="badge badge-opacity-success">Active</span>
                                            @elseif($device->status === 'needs_attention')
                                                <span class="badge badge-opacity-warning">Needs Attention</span>
                                            @elseif($device->status === 'replacement_needed')
                                                <span class="badge badge-opacity-danger">Replacement Needed</span>
                                            @elseif($device->status === 'stolen')
                                                <span class="badge badge-opacity-danger">Stolen</span>
                                            @else
                                                <span class="badge badge-opacity-secondary">{{ ucfirst($device->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('vendor.devices.show', $device) }}" class="btn btn-sm btn-info me-2">
                                                    <i class="mdi mdi-eye"></i> View
                                                </a>
                                                <a href="{{ route('vendor.devices.edit', $device) }}" class="btn btn-sm btn-warning">
                                                    <i class="mdi mdi-pencil"></i> Edit
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $devices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection