@extends('layouts.app')

@section('title', 'Product Catalog')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-5">Product Catalog</h2>
    <form method="GET" class="row g-3 mb-5 justify-content-center">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category_id" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-md-3">
            <div class="card h-100">
                @if(!empty($product->images) && is_array($product->images))
                    <img src="{{ $product->images[0] }}" class="card-img-top" alt="{{ $product->name }}">
                @endif
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-primary fw-bold">₦{{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('buyer.products.show', $product) }}" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">No products found.</div>
        </div>
        @endforelse
    </div>
    <div class="mt-5">
        {{ $products->links() }}
    </div>
</div>
@endsection
