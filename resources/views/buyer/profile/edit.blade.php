@extends('layouts.dashboard')

@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Edit Profile</h4>
                            <p class="card-subtitle card-subtitle-dash">Update your personal information</p>
                        </div>
                    </div>

                    <form action="{{ route('buyer.profile.update') }}" method="POST" class="mt-4">
                        @csrf
                        @method('PATCH')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="full_name" id="full_name" value="{{ old('full_name', $profile?->full_name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $profile?->phone) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $profile?->address) }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" name="city" id="city" value="{{ old('city', $profile?->city) }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control" name="state" id="state" value="{{ old('state', $profile?->state) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" name="country" id="country" value="{{ old('country', $profile?->country) }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="id_type" class="form-label">ID Type</label>
                                    <select class="form-select" name="id_type" id="id_type" required>
                                        <option value="" disabled {{ old('id_type', $profile?->id_type) ? '' : 'selected' }}>Select ID Type</option>
                                        <option value="Voter's card" {{ old('id_type', $profile?->id_type) == "Voter's card" ? 'selected' : '' }}>Voter's card</option>
                                        <option value="International passport" {{ old('id_type', $profile?->id_type) == 'International passport' ? 'selected' : '' }}>International passport</option>
                                        <option value="National identity card" {{ old('id_type', $profile?->id_type) == 'National identity card' ? 'selected' : '' }}>National identity card</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="id_number" class="form-label">ID Number</label>
                                    <input type="text" class="form-control" name="id_number" id="id_number" value="{{ old('id_number', $profile?->id_number) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="buyer_type" class="form-label">Buyer Type</label>
                                    <select class="form-select" name="buyer_type" id="buyer_type">
                                        <option value="individual" {{ old('buyer_type', $profile?->buyer_type ?? 'individual') == 'individual' ? 'selected' : '' }}>Individual</option>
                                        <option value="institution" {{ old('buyer_type', $profile?->buyer_type) == 'institution' ? 'selected' : '' }}>Institution</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 institution-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="institution_name" class="form-label">Institution Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="institution_name" id="institution_name" value="{{ old('institution_name', $profile?->institution_name) }}">
                                </div>
                            </div>
                            <div class="col-md-4 institution-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="tax_id" class="form-label">Tax ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="tax_id" id="tax_id" value="{{ old('tax_id', $profile?->tax_id) }}">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('buyer.profile.show') }}" class="btn btn-secondary me-2">
                                <i class="mdi mdi-close"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleInstitutionFields() {
        var buyerType = document.getElementById('buyer_type').value;
        var institutionFields = document.querySelectorAll('.institution-fields');
        if (buyerType === 'institution') {
            institutionFields.forEach(function(field) {
                field.style.display = '';
                field.querySelector('input').setAttribute('required', 'required');
            });
        } else {
            institutionFields.forEach(function(field) {
                field.style.display = 'none';
                field.querySelector('input').removeAttribute('required');
                field.querySelector('input').value = '';
            });
        }
    }
    document.getElementById('buyer_type').addEventListener('change', toggleInstitutionFields);
    window.addEventListener('DOMContentLoaded', function() {
        toggleInstitutionFields();
    });
</script>
@endsection