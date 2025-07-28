@extends('layouts.dashboard')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">My Profile</h4>
                            <p class="card-subtitle card-subtitle-dash">Your personal information</p>
                        </div>
                        <div>
                            <a href="{{ route('buyer.profile.edit') }}" class="btn btn-primary btn-lg text-white mb-0 me-0">
                                <i class="mdi mdi-pencil"></i> Edit Profile
                            </a>
                        </div>
                    </div>

                    @if(!$profile)
                        <div class="alert alert-warning mt-4">
                            <i class="mdi mdi-alert-circle-outline"></i> Your profile is not yet created. 
                            <a href="{{ route('buyer.profile.edit') }}" class="alert-link">Click here to complete your profile.</a>
                        </div>
                    @else
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Full Name:</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-plaintext">{{ $profile->full_name }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Email:</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-plaintext">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Phone:</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-plaintext">{{ $profile->phone }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Address:</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-plaintext">{{ $profile->address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">City:</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-plaintext">{{ $profile->city }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">State:</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-plaintext">{{ $profile->state }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Country:</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-plaintext">{{ $profile->country }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Buyer Type:</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-plaintext">{{ ucfirst($profile->buyer_type) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection