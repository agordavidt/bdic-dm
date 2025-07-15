@extends('layouts.app')

@section('title', 'Edit Device')
@section('page-title', 'Edit Device')

@section('content')
@includeIf('vendor.partials.device_edit_content')
@endsection 