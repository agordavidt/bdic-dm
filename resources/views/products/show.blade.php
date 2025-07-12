@extends('layouts.app')

@section('title', $product->name)
@section('page-title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            @if(!empty($product->images) && is_array($product->images))
                <div id="productImagesCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($product->images as $idx => $img)
                        <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                            <img src="{{ $img }}" class="d-block w-100" style="height:350px;object-fit:cover;">
                        </div>
                        @endforeach
                    </div>
                    @if(count($product->images) > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#productImagesCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productImagesCarousel" data-bs-slide="next">
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
            <h5 class="mt-4">Specifications</h5>
            <ul>
                @foreach($product->specifications as $key => $value)
                <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection 