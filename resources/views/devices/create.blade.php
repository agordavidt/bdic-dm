@extends('layouts.app')

@section('title', 'Register Device')
@section('page-title', 'Register Device')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Register Device</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('devices.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="unique_identifier" class="form-label">Unique Identifier</label>
                                <input type="text" class="form-control" id="unique_identifier" name="unique_identifier" required>
                            </div>
                            <div class="mb-3">
                                <label for="device_type" class="form-label">Device Type</label>
                                <input type="text" class="form-control" id="device_type" name="device_type" required>
                            </div>
                            <div class="mb-3">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" class="form-control" id="model" name="model" required>
                            </div>
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                <input type="text" class="form-control" id="brand" name="brand">
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01">
                            </div>
                            <div class="mb-3">
                                <label for="warranty_expiry" class="form-label">Warranty Expiry</label>
                                <input type="date" class="form-control" id="warranty_expiry" name="warranty_expiry">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="buyer_full_name" class="form-label">Buyer Full Name</label>
                                <input type="text" class="form-control" id="buyer_full_name" name="buyer_full_name">
                            </div>
                            <div class="mb-3">
                                <label for="buyer_phone" class="form-label">Buyer Phone</label>
                                <input type="text" class="form-control" id="buyer_phone" name="buyer_phone">
                            </div>
                            <div class="mb-3">
                                <label for="buyer_address" class="form-label">Buyer Address</label>
                                <input type="text" class="form-control" id="buyer_address" name="buyer_address">
                            </div>
                            <div class="mb-3">
                                <label for="buyer_city" class="form-label">Buyer City</label>
                                <input type="text" class="form-control" id="buyer_city" name="buyer_city">
                            </div>
                            <div class="mb-3">
                                <label for="buyer_state" class="form-label">Buyer State</label>
                                <input type="text" class="form-control" id="buyer_state" name="buyer_state">
                            </div>
                            <div class="mb-3">
                                <label for="buyer_country" class="form-label">Buyer Country</label>
                                <input type="text" class="form-control" id="buyer_country" name="buyer_country" value="Nigeria">
                            </div>
                            <div class="mb-3">
                                <label for="buyer_id_type" class="form-label">Buyer ID Type</label>
                                <input type="text" class="form-control" id="buyer_id_type" name="buyer_id_type">
                            </div>
                            <div class="mb-3">
                                <label for="buyer_id_number" class="form-label">Buyer ID Number</label>
                                <input type="text" class="form-control" id="buyer_id_number" name="buyer_id_number">
                            </div>
                            <div class="mb-3">
                                <label for="buyer_category" class="form-label">Buyer Category</label>
                                <select class="form-select" id="buyer_category" name="buyer_category">
                                    <option value="">Select Category</option>
                                    <option value="individual">Individual</option>
                                    <option value="institution">Institution</option>
                                    <option value="corporate">Corporate</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="institution_name" class="form-label">Institution Name</label>
                                <input type="text" class="form-control" id="institution_name" name="institution_name">
                            </div>
                            <div class="mb-3">
                                <label for="tax_id" class="form-label">Tax ID</label>
                                <input type="text" class="form-control" id="tax_id" name="tax_id">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
