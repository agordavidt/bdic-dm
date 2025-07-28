@extends('layouts.dashboard')

@section('title', 'Device Categories')
@section('page-title', 'Device Categories')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Device Categories</h4>
                            <p class="card-subtitle card-subtitle-dash">Manage your device categories</p>
                        </div>
                        <div>
                            <a href="{{ route('device-categories.create') }}" class="btn btn-primary btn-lg text-white mb-0 me-0">
                                <i class="mdi mdi-plus-circle-outline"></i> Create New
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any()))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <i class="mdi mdi-alert-circle-outline me-2"></i> {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive mt-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Devices Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>{{ $category->devices_count }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('device-categories.edit', $category) }}" class="btn btn-sm btn-warning me-2">
                                                <i class="mdi mdi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('device-categories.destroy', $category) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="mdi mdi-delete"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection