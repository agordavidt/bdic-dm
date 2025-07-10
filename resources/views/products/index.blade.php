@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Product Catalog</h1>
        @if(auth()->user()->isVendor() || auth()->user()->isAdmin())
            <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Product
            </a>
        @endif
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Search products...">
            </div>
            
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id" id="category_id" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="min_price" class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="0">
            </div>
            
            <div>
                <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" 
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="1000">
            </div>
            
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    @if($product->main_image)
                        <img src="{{ $product->main_image }}" alt="{{ $product->name }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">No Image</span>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $product->category->name }}</p>
                        <p class="text-gray-700 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 100) }}</p>
                        
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xl font-bold text-blue-600">{{ $product->formatted_price }}</span>
                            <span class="text-sm text-gray-500">SKU: {{ $product->sku }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm {{ $product->isInStock() ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->isInStock() ? 'In Stock' : 'Out of Stock' }}
                            </span>
                            @if($product->featured)
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Featured</span>
                            @endif
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('products.show', $product) }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded text-sm">
                                View Details
                            </a>
                            
                            @if(auth()->user()->isBuyer() && $product->isInStock())
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded text-sm">
                                        Add to Cart
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        @if(auth()->user()->isVendor() && auth()->user()->id === $product->vendor_id)
                            <div class="flex gap-2 mt-3">
                                <a href="{{ route('products.edit', $product) }}" 
                                   class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white text-center py-2 px-4 rounded text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-500 text-xl mb-4">No products found</div>
            <p class="text-gray-400">Try adjusting your search criteria or check back later.</p>
        </div>
    @endif
</div>
@endsection 