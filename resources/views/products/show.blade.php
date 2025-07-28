@extends('layouts.dashboard')

@section('title', $product->name)

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active ps-0" id="product-tab" data-bs-toggle="tab" href="#product" role="tab" aria-controls="product" aria-selected="true">{{ $product->name }}</a>
          </li>
        </ul>
      </div>

      <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product">
          <div class="row">
            <div class="col-md-6">
              @if(!empty($product->images) && is_array($product->images))
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-inner">
                    @foreach($product->images as $idx => $img)
                    <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                      <img src="{{ $img }}" class="d-block w-100" style="height:400px;object-fit:contain;">
                    </div>
                    @endforeach
                  </div>
                  @if(count($product->images) > 1)
                  <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                  </button>
                  @endif
                </div>
              @endif
            </div>
            <div class="col-md-6">
              <h2>{{ $product->name }}</h2>
              <p class="text-muted">Category: {{ $product->category->name ?? '-' }}</p>
              <h4 class="text-primary">₦{{ number_format($product->price, 2) }}</h4>
              <p>{{ $product->description }}</p>
              
              @if(!empty($product->specifications) && is_array($product->specifications))
              <div class="mt-4">
                <h5>Specifications</h5>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <tbody>
                      @foreach($product->specifications as $key => $value)
                      <tr>
                        <td><strong>{{ $key }}</strong></td>
                        <td>{{ $value }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection