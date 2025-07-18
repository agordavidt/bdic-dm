@extends('layouts.app')

@section('title', 'Register Device')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="card-title mb-0">Register Device</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('devices.store') }}" method="POST" id="device-registration-form">
                @csrf
                <div class="row">
                    <!-- Device Information -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Device Information</h5>
                        <div class="mb-3">
                            <label for="unique_identifier" class="form-label">Unique Identifier <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('unique_identifier') is-invalid @enderror" 
                                   id="unique_identifier" name="unique_identifier" 
                                   value="{{ old('unique_identifier') }}" required>
                            @error('unique_identifier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="device_type" class="form-label">Device Type <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('device_type') is-invalid @enderror" 
                                   id="device_type" name="device_type" 
                                   value="{{ old('device_type') }}" required>
                            @error('device_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                   id="model" name="model" 
                                   value="{{ old('model') }}" required>
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" 
                                   value="{{ old('brand') }}">
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="specifications" class="form-label">Specifications</label>
                            <textarea class="form-control @error('specifications') is-invalid @enderror" 
                                      id="specifications" name="specifications" rows="3">{{ old('specifications') }}</textarea>
                            @error('specifications')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" step="0.01" min="0" 
                                   value="{{ old('price') }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="warranty_expiry" class="form-label">Warranty Expiry</label>
                            <input type="date" class="form-control @error('warranty_expiry') is-invalid @enderror" 
                                   id="warranty_expiry" name="warranty_expiry" 
                                   value="{{ old('warranty_expiry') }}">
                            @error('warranty_expiry')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buyer Information -->
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Buyer Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="buyer_email" class="form-label">Buyer Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('buyer_email') is-invalid @enderror" 
                                           id="buyer_email" name="buyer_email" 
                                           value="{{ old('buyer_email') }}" required 
                                           placeholder="e.g. buyer@email.com">
                                    @error('buyer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="buyer_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('buyer_name') is-invalid @enderror" 
                                           id="buyer_name" name="buyer_name" 
                                           value="{{ old('buyer_name') }}" required 
                                           placeholder="e.g. John Doe">
                                    @error('buyer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="buyer_phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('buyer_phone') is-invalid @enderror" 
                                           id="buyer_phone" name="buyer_phone" 
                                           value="{{ old('buyer_phone') }}" required 
                                           placeholder="e.g. 08012345678">
                                    @error('buyer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="buyer_address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('buyer_address') is-invalid @enderror" 
                                              id="buyer_address" name="buyer_address" 
                                              rows="3" required 
                                              placeholder="e.g. 123 Main St, City, State">{{ old('buyer_address') }}</textarea>
                                    @error('buyer_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('devices.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-lg" id="submit-btn">
                        <i class="fas fa-save me-2"></i>Register Device
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('device-registration-form');
    const submitButton = document.getElementById('submit-btn');
    
    form.addEventListener('submit', function(e) {
        // Disable submit button to prevent double submission
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
        
        // Basic client-side validation
        const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Validate email format
        const emailField = document.getElementById('buyer_email');
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailField.value && !emailPattern.test(emailField.value)) {
            isValid = false;
            emailField.classList.add('is-invalid');
        }
        
        if (!isValid) {
            e.preventDefault();
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-save me-2"></i>Register Device';
            
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
    
    // Remove validation styling on input
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
});
</script>
@endpush
@endsection