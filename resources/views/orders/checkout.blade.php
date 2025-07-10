@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
        <a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Cart</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Checkout Form -->
        <div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Information</h2>
                
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Shipping Address -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping Address</h3>
                            <textarea name="shipping_address" rows="4" required
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Enter your complete shipping address">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            @error('shipping_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Billing Address -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Billing Address</h3>
                            <textarea name="billing_address" rows="4" required
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Enter your complete billing address">{{ old('billing_address', auth()->user()->address) }}</textarea>
                            @error('billing_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Method</h3>
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="credit_card" {{ old('payment_method') == 'credit_card' ? 'checked' : '' }} required
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-gray-700">Credit Card</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }} required
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-gray-700">Bank Transfer</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="cash_on_delivery" {{ old('payment_method') == 'cash_on_delivery' ? 'checked' : '' }} required
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-gray-700">Cash on Delivery</span>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order Notes -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Order Notes (Optional)</h3>
                            <textarea name="notes" rows="3"
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Any special instructions or notes for your order">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t">
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div>
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                
                <!-- Cart Items -->
                <div class="space-y-4 mb-6">
                    @foreach($cartItems as $cartItem)
                        <div class="flex items-center space-x-3">
                            @if($cartItem->product->main_image)
                                <img src="{{ $cartItem->product->main_image }}" alt="{{ $cartItem->product->name }}" 
                                     class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-500 text-xs">No Image</span>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $cartItem->product->name }}</h4>
                                <p class="text-sm text-gray-600">Qty: {{ $cartItem->quantity }}</p>
                            </div>
                            
                            <div class="text-right">
                                <div class="font-medium text-gray-900">{{ $cartItem->formatted_total_price }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Totals -->
                <div class="border-t pt-4 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax (10%):</span>
                        <span class="font-medium">${{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping:</span>
                        <span class="font-medium">${{ number_format($shipping, 2) }}</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold">Total:</span>
                            <span class="text-lg font-bold text-blue-600">${{ number_format($grandTotal, 2) }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Security Notice -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-blue-800 text-sm font-medium">Secure Checkout</span>
                    </div>
                    <p class="text-blue-700 text-sm mt-1">Your payment information is secure and encrypted.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 