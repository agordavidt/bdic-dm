@extends('layouts.auth')

@section('title', 'Register')
@section('auth-subtitle', 'Create your account')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    
    <div class="mb-3">
        <label for="name" class="form-label">
            Full Name
        </label>
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
               placeholder="Enter your full name">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">
            Email Address
        </label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
               name="email" value="{{ old('email') }}" required autocomplete="email"
               placeholder="Enter your email">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">
            Account Type
        </label>
        <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
            <option value="">Select Account Type</option>
            <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>Buyer/Customer</option>
            <option value="vendor" {{ old('role') == 'vendor' ? 'selected' : '' }}>Vendor/Distributor</option>
        </select>
        @error('role')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">
            Phone Number
        </label>
        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" 
               name="phone" value="{{ old('phone') }}"
               placeholder="Enter your phone number">
        @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3" id="company-field" style="display: none;">
        <label for="company_name" class="form-label">
            Company Name
        </label>
        <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" 
               name="company_name" value="{{ old('company_name') }}"
               placeholder="Enter your company name">
        @error('company_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">
            Password
        </label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
               name="password" required autocomplete="new-password"
               placeholder="Create a password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password-confirm" class="form-label">
            Confirm Password
        </label>
        <input id="password-confirm" type="password" class="form-control" 
               name="password_confirmation" required autocomplete="new-password"
               placeholder="Confirm your password">
    </div>

    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary btn-lg">
            Create Account
        </button>
    </div>

    <div class="text-center">
        <p class="mb-0">Already have an account?</p>
        <a href="{{ route('login') }}" class="btn btn-outline-primary">
            Sign In
        </a>
    </div>
</form>

@push('scripts')
<script>
document.getElementById('role').addEventListener('change', function() {
    const companyField = document.getElementById('company-field');
    if (this.value === 'vendor') {
        companyField.style.display = 'block';
        document.getElementById('company_name').required = true;
    } else {
        companyField.style.display = 'none';
        document.getElementById('company_name').required = false;
    }
});

// Show company field if vendor is already selected (on form reload)
if(document.getElementById('role').value === 'vendor') {
    document.getElementById('company-field').style.display = 'block';
    document.getElementById('company_name').required = true;
}
</script>
@endpush
@endsection