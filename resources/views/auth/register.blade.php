@extends('layouts.auth') {{-- Assuming your new layout is in resources/views/layouts/auth.blade.php --}}

@section('title', 'Register')
@section('auth-subtitle', 'Create your account')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-4"> {{-- Changed from mb-3 to mb-4 for more consistent spacing with new layout --}}
        <label for="name" class="block font-medium text-sm text-gray-700 mb-1"> {{-- New label styles --}}
            Full Name
        </label>
        <input id="name" type="text" class="form-control @error('name') border-red-500 @enderror" {{-- Adopted form-control and error class --}}
               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
               placeholder="Enter your full name">
        @error('name')
            <p class="text-red-500 text-xs mt-1" role="alert"> {{-- New error message styling --}}
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="email" class="block font-medium text-sm text-gray-700 mb-1">
            Email Address
        </label>
        <input id="email" type="email" class="form-control @error('email') border-red-500 @enderror"
               name="email" value="{{ old('email') }}" required autocomplete="email"
               placeholder="Enter your email">
        @error('email')
            <p class="text-red-500 text-xs mt-1" role="alert">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="role" class="block font-medium text-sm text-gray-700 mb-1">
            Account Type
        </label>
        {{-- For select, use form-control class as well. It will pick up the shared input styles. --}}
        <select id="role" class="form-control @error('role') border-red-500 @enderror" name="role" required>
            <option value="">Select Account Type</option>
            <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>Buyer/Customer</option>
            <option value="vendor" {{ old('role') == 'vendor' ? 'selected' : '' }}>Vendor/Distributor</option>
        </select>
        @error('role')
            <p class="text-red-500 text-xs mt-1" role="alert">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="phone" class="block font-medium text-sm text-gray-700 mb-1">
            Phone Number
        </label>
        <input id="phone" type="text" class="form-control @error('phone') border-red-500 @enderror"
               name="phone" value="{{ old('phone') }}"
               placeholder="Enter your phone number">
        @error('phone')
            <p class="text-red-500 text-xs mt-1" role="alert">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mb-4" id="company-field" style="display: {{ old('role') == 'vendor' ? 'block' : 'none' }};"> {{-- Added initial display logic based on old('role') --}}
        <label for="company_name" class="block font-medium text-sm text-gray-700 mb-1">
            Company Name
        </label>
        <input id="company_name" type="text" class="form-control @error('company_name') border-red-500 @enderror"
               name="company_name" value="{{ old('company_name') }}"
               placeholder="Enter your company name">
        @error('company_name')
            <p class="text-red-500 text-xs mt-1" role="alert">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password" class="block font-medium text-sm text-gray-700 mb-1">
            Password
        </label>
        <input id="password" type="password" class="form-control @error('password') border-red-500 @enderror"
               name="password" required autocomplete="new-password"
               placeholder="Create a password">
        @error('password')
            <p class="text-red-500 text-xs mt-1" role="alert">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password-confirm" class="block font-medium text-sm text-gray-700 mb-1">
            Confirm Password
        </label>
        <input id="password-confirm" type="password" class="form-control"
               name="password_confirmation" required autocomplete="new-password"
               placeholder="Confirm your password">
    </div>

    <div class="mt-6"> {{-- Changed from d-grid mb-3 to mt-6 for spacing --}}
        <button type="submit" class="btn-primary"> {{-- Adopted btn-primary --}}
            Create Account
        </button>
    </div>

    <div class="text-center mt-6"> {{-- Changed from text-center for spacing --}}
        <p class="text-sm text-gray-600 mb-2">Already have an account?</p> {{-- Added text-gray-600 and mb-2 --}}
        <a href="{{ route('login') }}" class="underline text-sm text-red-600 hover:text-red-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"> {{-- New link styles --}}
            Sign In
        </a>
    </div>
</form>

@push('scripts')
<script>
document.getElementById('role').addEventListener('change', function() {
    const companyField = document.getElementById('company-field');
    const companyNameInput = document.getElementById('company_name');
    if (this.value === 'vendor') {
        companyField.style.display = 'block';
        companyNameInput.required = true;
    } else {
        companyField.style.display = 'none';
        companyNameInput.required = false;
        companyNameInput.value = ''; // Clear company name if buyer is selected
    }
});

// Show company field if vendor is already selected (on form reload, e.g., after validation error)
// This was correctly handled in your original script block, just ensured it uses the same elements.
if(document.getElementById('role').value === 'vendor') {
    document.getElementById('company-field').style.display = 'block';
    document.getElementById('company_name').required = true;
}
</script>
@endpush
@endsection