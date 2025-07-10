@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">← Continue Shopping</a>
    </div>

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold text-gray-900">Cart Items ({{ $cartItems->count() }})</h2>
                    </div>
                    
                    <div class="divide-y">
                        @foreach($cartItems as $cartItem)
                            <div class="p-6">
                                <div class="flex items-center space-x-4">
                                    @if($cartItem->product->main_image)
                                        <img src="{{ $cartItem->product->main_image }}" alt="{{ $cartItem->product->name }}" 
                                             class="w-20 h-20 object-cover rounded">
                                    @else
                                        <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-500 text-xs">No Image</span>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $cartItem->product->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $cartItem->product->category->name }}</p>
                                        <p class="text-sm text-gray-500">SKU: {{ $cartItem->product->sku }}</p>
                                        
                                        @if(!$cartItem->isProductAvailable())
                                            <p class="text-red-600 text-sm mt-1">Product no longer available</p>
                                        @elseif(!$cartItem->isQuantityAvailable())
                                            <p class="text-red-600 text-sm mt-1">Insufficient stock</p>
                                        @endif
                                    </div>
                                    
                                    <div class="text-right">
                                        <div class="text-lg font-bold text-blue-600">{{ $cartItem->product->formatted_price }}</div>
                                        <div class="text-sm text-gray-500">per item</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center space-x-4">
                                        <form action="{{ route('cart.update', $cartItem) }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <label for="quantity-{{ $cartItem->id }}" class="text-sm font-medium text-gray-700">Qty:</label>
                                            <input type="number" name="quantity" id="quantity-{{ $cartItem->id }}" 
                                                   value="{{ $cartItem->quantity }}" min="1" max="{{ $cartItem->product->stock_quantity }}"
                                                   class="w-16 border border-gray-300 rounded-md px-2 py-1 text-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm">Update</button>
                                        </form>
                                        
                                        <form action="{{ route('cart.remove', $cartItem) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Remove</button>
                                        </form>
                                    </div>
                                    
                                    <div class="text-right">
                                        <div class="text-lg font-bold text-gray-900">{{ $cartItem->formatted_total_price }}</div>
                                        <div class="text-sm text-gray-500">Total</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="p-6 border-t bg-gray-50">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('Are you sure you want to clear your cart?')"
                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                Clear Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax (10%):</span>
                            <span class="font-medium">${{ number_format($total * 0.1, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping:</span>
                            <span class="font-medium">$0.00</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold">Total:</span>
                                <span class="text-lg font-bold text-blue-600">${{ number_format($total * 1.1, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <a href="{{ route('orders.checkout') }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-center block">
                            Proceed to Checkout
                        </a>
                        
                        <a href="{{ route('products.index') }}" 
                           class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg text-center block">
                            Continue Shopping
                        </a>
                    </div>
                    
                    @if($cartItems->contains(function($item) { return !$item->isProductAvailable() || !$item->isQuantityAvailable(); }))
                        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-yellow-800 text-sm">
                                ⚠️ Some items in your cart may not be available. Please review and update your cart.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-500 text-xl mb-4">Your cart is empty</div>
            <p class="text-gray-400 mb-6">Add some products to your cart to get started.</p>
            <a href="{{ route('products.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection 