@extends('layouts.app')

@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Profile</h2>
    <form action="{{ route('buyer.profile.update') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="full_name" id="full_name" value="{{ old('full_name', $profile->full_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $profile->phone) }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $profile->address) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" name="city" id="city" value="{{ old('city', $profile->city) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="state" class="form-label">State</label>
                        <input type="text" class="form-control" name="state" id="state" value="{{ old('state', $profile->state) }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" name="country" id="country" value="{{ old('country', $profile->country) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="id_type" class="form-label">ID Type</label>
                        <input type="text" class="form-control" name="id_type" id="id_type" value="{{ old('id_type', $profile->id_type) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="id_number" class="form-label">ID Number</label>
                        <input type="text" class="form-control" name="id_number" id="id_number" value="{{ old('id_number', $profile->id_number) }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="buyer_type" class="form-label">Buyer Type</label>
                        <select class="form-select" name="buyer_type" id="buyer_type" required>
                            <option value="individual" {{ old('buyer_type', $profile->buyer_type) == 'individual' ? 'selected' : '' }}>Individual</option>
                            <option value="institution" {{ old('buyer_type', $profile->buyer_type) == 'institution' ? 'selected' : '' }}>Institution</option>
                            <option value="corporate" {{ old('buyer_type', $profile->buyer_type) == 'corporate' ? 'selected' : '' }}>Corporate</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="institution_name" class="form-label">Institution Name</label>
                        <input type="text" class="form-control" name="institution_name" id="institution_name" value="{{ old('institution_name', $profile->institution_name) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="tax_id" class="form-label">Tax ID</label>
                        <input type="text" class="form-control" name="tax_id" id="tax_id" value="{{ old('tax_id', $profile->tax_id) }}">
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('buyer.profile.show') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection 