@extends('layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Profile</h2>
    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Full Name</dt>
                <dd class="col-sm-9">{{ $profile->full_name }}</dd>
                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>
                <dt class="col-sm-3">Phone</dt>
                <dd class="col-sm-9">{{ $profile->phone }}</dd>
                <dt class="col-sm-3">Address</dt>
                <dd class="col-sm-9">{{ $profile->address }}</dd>
                <dt class="col-sm-3">City</dt>
                <dd class="col-sm-9">{{ $profile->city }}</dd>
                <dt class="col-sm-3">State</dt>
                <dd class="col-sm-9">{{ $profile->state }}</dd>
                <dt class="col-sm-3">Country</dt>
                <dd class="col-sm-9">{{ $profile->country }}</dd>
                <dt class="col-sm-3">ID Type</dt>
                <dd class="col-sm-9">{{ $profile->id_type }}</dd>
                <dt class="col-sm-3">ID Number</dt>
                <dd class="col-sm-9">{{ $profile->id_number }}</dd>
                <dt class="col-sm-3">Buyer Type</dt>
                <dd class="col-sm-9">{{ ucfirst($profile->buyer_type) }}</dd>
                @if($profile->institution_name)
                <dt class="col-sm-3">Institution Name</dt>
                <dd class="col-sm-9">{{ $profile->institution_name }}</dd>
                @endif
                @if($profile->tax_id)
                <dt class="col-sm-3">Tax ID</dt>
                <dd class="col-sm-9">{{ $profile->tax_id }}</dd>
                @endif
            </dl>
            <a href="{{ route('buyer.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>
</div>
@endsection 