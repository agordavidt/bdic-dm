@extends('layouts.app')

@section('title', $category->name)
@section('page-title', $category->name)

@section('content')
<div class="container py-4">
    <h2 class="mb-4">{{ $category->name }} Products</h2>
    <div class="row">
        @forelse($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if(!empty($product->images) && is_array($product->images))
                    <img src="{{ $product->images[0] }}" class="card-img-top" style="height:200px;object-fit:cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">₦{{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('buyer.products.show', $product) }}" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">No products found in this category.</div>
        </div>
        @endforelse
    </div>
    <div class="mt-3">
        {{ $products->links() }}
    </div>
</div>
@endsection 