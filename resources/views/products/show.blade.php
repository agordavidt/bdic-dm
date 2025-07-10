@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
            <!-- Product Images -->
            <div>
                @if($product->images && count($product->images) > 0)
                    <div class="space-y-4">
                        <div class="aspect-w-1 aspect-h-1">
                            <img src="{{ $product->main_image }}" alt="{{ $product->name }}" 
                                 class="w-full h-96 object-cover rounded-lg">
                        </div>
                        @if(count($product->images) > 1)
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($product->images as $image)
                                    <img src="{{ $image }}" alt="{{ $product->name }}" 
                                         class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75">
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500 text-lg">No Image Available</span>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                    <p class="text-lg text-gray-600 mb-4">{{ $product->category->name }}</p>
                    <div class="text-3xl font-bold text-blue-600 mb-4">{{ $product->formatted_price }}</div>
                    
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="text-sm {{ $product->isInStock() ? 'text-green-600' : 'text-red-600' }} font-medium">
                            {{ $product->isInStock() ? 'In Stock' : 'Out of Stock' }}
                        </span>
                        @if($product->featured)
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Featured</span>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                </div>

                @if($product->specifications)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Specifications</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            @foreach($product->specifications as $key => $value)
                                <div class="flex justify-between py-2 border-b border-gray-200 last:border-b-0">
                                    <span class="font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                    <span class="text-gray-600">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="border-t pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-600">SKU: {{ $product->sku }}</span>
                        <span class="text-sm text-gray-600">Vendor: {{ $product->vendor->name }}</span>
                    </div>

                    @if(auth()->user()->isBuyer() && $product->isInStock())
                        <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                       class="w-24 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <span class="text-sm text-gray-500 ml-2">Available: {{ $product->stock_quantity }}</span>
                            </div>
                            
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg">
                                Add to Cart
                            </button>
                        </form>
                    @elseif(!$product->isInStock())
                        <div class="text-center py-4">
                            <span class="text-red-600 font-medium">This product is currently out of stock.</span>
                        </div>
                    @endif

                    @if(auth()->user()->isVendor() && auth()->user()->id === $product->vendor_id)
                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('products.edit', $product) }}" 
                               class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white text-center py-2 px-4 rounded">
                                Edit Product
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded">
                                    Delete Product
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        @if($relatedProduct->main_image)
                            <img src="{{ $relatedProduct->main_image }}" alt="{{ $relatedProduct->name }}" 
                                 class="w-full h-32 object-cover">
                        @else
                            <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500 text-sm">No Image</span>
                            </div>
                        @endif
                        
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-2">{{ $relatedProduct->name }}</h3>
                            <p class="text-lg font-bold text-blue-600 mb-2">{{ $relatedProduct->formatted_price }}</p>
                            <a href="{{ route('products.show', $relatedProduct) }}" 
                               class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded text-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection 