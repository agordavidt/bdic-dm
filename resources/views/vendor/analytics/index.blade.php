@extends('layouts.app')

@section('title', 'Analytics')
@section('page-title', 'Analytics')

@section('content')
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Total Sales</h6>
                <h3>{{ $analytics['total_sales'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Total Orders</h6>
                <h3>{{ $analytics['total_orders'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Total Products</h6>
                <h3>{{ $analytics['total_products'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Revenue</h6>
                <h3>₦{{ number_format($analytics['revenue'] ?? 0, 2) }}</h3>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <h5>Sales Trends (Coming Soon)</h5>
        <div style="height: 200px; background: #f8f9fa; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center;">
            <span>Chart Placeholder</span>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h5>Top Products (Coming Soon)</h5>
        <div style="height: 200px; background: #f8f9fa; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center;">
            <span>Chart Placeholder</span>
        </div>
    </div>
</div>
@endsection 