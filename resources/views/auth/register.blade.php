@extends('layouts.auth')

@section('title', 'Register')
@section('auth-title', 'Create Your Account')
@section('auth-subtitle', 'Join the BDIC Device Management System in just a few steps')
@section('auth-width', 'col-lg-10')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Account Type Selection -->
    <div class="mb-4">
        <label class="form-label mb-3">I'm registering as:</label>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="account-type-card p-4 rounded-3 text-center @if(old('role') == 'buyer') active @endif" data-role="buyer" id="buyer-card">
                    <i class="bi bi-person fs-1 text-primary mb-3"></i>
                    <h4 class="h5">Buyer/Customer</h4>
                    <p class="text-muted small">For individuals purchasing devices</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="account-type-card p-4 rounded-3 text-center @if(old('role') == 'vendor') active @endif" data-role="vendor" id="vendor-card">
                    <i class="bi bi-building fs-1 text-primary mb-3"></i>
                    <h4 class="h5">Vendor/Distributor</h4>
                    <p class="text-muted small">For companies selling devices</p>
                </div>
            </div>
        </div>
        <input type="hidden" id="role" name="role" value="{{ old('role') }}" required>
        @error('role')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Grid Layout for Form Fields -->
    <div class="registration-grid">
        <!-- Column 1 -->
        <div>
            <div class="mb-4">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                       class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="form-label">Phone Number</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                       class="form-control @error('phone') is-invalid @enderror">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Column 2 -->
        <div>
            <div class="mb-4" id="company-field" style="display: {{ old('role') == 'vendor' ? 'block' : 'none' }};">
                <label for="company_name" class="form-label">Company Name</label>
                <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}"
                       class="form-control @error('company_name') is-invalid @enderror"
                       {{ old('role') == 'vendor' ? 'required' : '' }}>
                @error('company_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror               
            </div>

            <div class="mb-4">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="form-control">
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="terms" required>
            <label class="form-check-label" for="terms">
                I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>
            </label>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-3">Create Account</button>

        <div class="text-center mt-4">
            <p class="text-muted">Already have an account? 
                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Sign In</a>
            </p>
        </div>
    </div>
</form>

@push('styles')
<style>
    .registration-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    @media (max-width: 992px) {
        .registration-grid {
            grid-template-columns: 1fr;
        }
    }
    .account-type-card {
        color: var(--bs-primary);
        cursor: pointer;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    .account-type-card:hover {
        border-color: var(--bs-primary);
    }
    .account-type-card.active {
        border-color: var(--bs-primary);
        background-color: var(--bs-secondary);
    }
</style>
@endpush

@push('scripts')
<script>
    // Enhanced account type selection
    document.querySelectorAll('.account-type-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.account-type-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('role').value = this.dataset.role;
            
            // Toggle company field
            const companyField = document.getElementById('company-field');
            const companyNameInput = document.getElementById('company_name');
            if (this.dataset.role === 'vendor') {
                companyField.style.display = 'block';
                companyNameInput.required = true;
            } else {
                companyField.style.display = 'none';
                companyNameInput.required = false;
                companyNameInput.value = '';
            }
        });
    });

    // Auto-select if returning after validation error
    document.addEventListener('DOMContentLoaded', function() {
        const roleInput = document.getElementById('role');
        if (roleInput.value) {
            document.querySelector(`.account-type-card[data-role="${roleInput.value}"]`).classList.add('active');
            if (roleInput.value === 'vendor') {
                document.getElementById('company-field').style.display = 'block';
                document.getElementById('company_name').required = true;
            }
        }
    });
</script>
@endpush
@endsection