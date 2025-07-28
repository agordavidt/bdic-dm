@extends('layouts.dashboard')

@section('title', $category->name)

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active ps-0" id="category-tab" data-bs-toggle="tab" href="#category" role="tab" aria-controls="category" aria-selected="true">{{ $category->name }}</a>
          </li>
        </ul>
      </div>

      <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="category" role="tabpanel" aria-labelledby="category">
          <div class="row">
            @forelse($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6 grid-margin stretch-card">
              <div class="card card-rounded">
                @if(!empty($product->images) && is_array($product->images))
                  <img src="{{ $product->images[0] }}" class="card-img-top" style="height:200px;object-fit:cover;">
                @endif
                <div class="card-body">
                  <h5 class="card-title">{{ $product->name }}</h5>
                  <p class="card-text">₦{{ number_format($product->price, 2) }}</p>
                  <a href="{{ route('products.show', $product) }}" class="btn btn-primary">View Details</a>
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
      </div>
    </div>
  </div>
</div>
@endsection