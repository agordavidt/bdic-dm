@extends('layouts.auth') {{-- Assuming your new layout is in resources/views/layouts/auth.blade.php --}}

@section('title', 'Login')
@section('auth-subtitle', 'Sign in to your account')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    {{-- Email Address --}}
    <div class="mb-4">
        <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Email Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control @error('email') border-red-500 @enderror">
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Password --}}
    <div class="mb-4">
        <label for="password" class="block font-medium text-sm text-gray-700 mb-1">Password</label>
        <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control @error('password') border-red-500 @enderror">
        @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Remember Me & Forgot Password --}}
    <div class="flex items-center justify-between mt-6 mb-4">
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500" name="remember">
            <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </label>

        @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" href="{{ route('password.request') }}">
                Forgot your password?
            </a>
        @endif
    </div>

    {{-- Login Button --}}
    <div class="flex items-center justify-end mt-4">
        <button type="submit" class="btn-primary">
            Log in
        </button>
    </div>
</form>

{{-- Link to Register --}}
<div class="text-center mt-6">
    <p class="text-sm text-gray-600">Don't have an account?</p>
    <a href="{{ route('register') }}" class="underline text-sm text-red-600 hover:text-red-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
        Register here
    </a>
</div>
@endsection