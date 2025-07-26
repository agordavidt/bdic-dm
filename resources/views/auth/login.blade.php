@extends('layouts.auth')

@section('title', 'Login')
@section('auth-title', 'Sign In')
@section('auth-subtitle', 'Access your BDIC Device Management account')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    {{-- Email Address --}}
    <div class="mb-4">
        <label for="email" class="form-label">Email Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
               class="form-control @error('email') is-invalid @enderror">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Password --}}
    <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" name="password" required autocomplete="current-password" 
               class="form-control @error('password') is-invalid @enderror">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Remember Me & Forgot Password --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">Remember me</label>
        </div>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-decoration-none">
                Forgot password?
            </a>
        @endif
    </div>

    {{-- Login Button --}}
    <button type="submit" class="btn btn-primary w-100 py-2">Log In</button>

    {{-- Link to Register --}}
    <div class="text-center mt-4">
        <p class="text-muted">Don't have an account? 
            <a href="{{ route('register') }}" class="text-decoration-none">Register here</a>
        </p>
    </div>
</form>
@endsection