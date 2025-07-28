@extends('layouts.dashboard')

@section('title', 'Edit Device Category')
@section('page-title', 'Edit Device Category')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Edit Device Category</h4>
                            <p class="card-subtitle card-subtitle-dash">Update category details</p>
                        </div>
                    </div>

                    <form action="{{ route('device-categories.update', $deviceCategory) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $deviceCategory->name }}" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $deviceCategory->description }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
