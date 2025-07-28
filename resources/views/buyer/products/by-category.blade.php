@extends('layouts.dashboard')

@section('title', $category->name)
@section('page-title', $category->name)

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card card-rounded">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">{{ $category->name }} Products</h4>
                            <p class="card-subtitle card-subtitle-dash">Browse products in this category</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        @forelse($products as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                @if(!empty($product->images) && is_array($product->images))
                                    <img src="{{ $product->images[0] }}" class="card-img-top" style="height:200px;object-fit:cover;">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-primary fw-bold">₦{{ number_format($product->price, 2) }}</p>
                                    <a href="{{ route('buyer.products.show', $product) }}" class="btn btn-primary">
                                        <i class="mdi mdi-eye"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="mdi mdi-information-outline"></i> No products found in this category.
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection