@extends('layouts.app')

@section('title', 'Device Details')
@section('page-title', 'Device Details')

@section('content')
@includeIf('vendor.partials.device_show_content')
@endsection 