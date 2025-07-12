@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-6">
            @if(!empty($product->images) && is_array($product->images))
                <div id="productImagesCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-4 shadow-sm">
                        @foreach($product->images as $idx => $img)
                        <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                            <img src="{{ $img }}" class="d-block w-100" alt="{{ $product->name }}" style="height: 450px; object-fit: contain;">
                        </div>
                        @endforeach
                    </div>
                    @if(count($product->images) > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#productImagesCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productImagesCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    @endif
                </div>
                <div class="row row-cols-4 g-2">
                    @foreach($product->images as $idx => $img)
                        <div class="col">
                            <img src="{{ $img }}" class="img-thumbnail cursor-pointer" alt="Thumbnail {{ $idx }}" onclick="setActiveImage({{ $idx }})" style="height: 80px; object-fit: cover;">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold">{{ $product->name }}</h1>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge bg-primary">{{ $product->category->name ?? 'Uncategorized' }}</span>
                <h3 class="text-primary">₦{{ number_format($product->price, 2) }}</h3>
            </div>
            <p class="lead">{{ $product->description }}</p>
            <form action="{{ route('buyer.cart.add') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function setActiveImage(index) {
    const carousel = new bootstrap.Carousel(document.getElementById('productImagesCarousel'));
    carousel.to(index);
}
</script>
@endsection
