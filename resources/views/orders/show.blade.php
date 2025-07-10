@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Orders</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Order #{{ $order->order_number }}</h2>
                <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
            </div>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <span class="px-3 py-1 rounded-full text-xs font-medium
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                    @elseif($order->status === 'processing') bg-purple-100 text-purple-800
                    @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-medium
                    @if($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->payment_status === 'paid') bg-green-100 text-green-800
                    @elseif($order->payment_status === 'failed') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </div>
        </div>

        <!-- Order Items -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h3>
            <div class="divide-y">
                @foreach($order->orderItems as $item)
                    <div class="flex items-center space-x-4 py-4">
                        @if($item->product->main_image)
                            <img src="{{ $item->product->main_image }}" alt="{{ $item->product->name }}" 
                                 class="w-16 h-16 object-cover rounded">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                <span class="text-gray-500 text-xs">No Image</span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $item->product->name }}</h4>
                            <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <div class="font-medium text-gray-900">{{ $item->formatted_total_price }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Shipping Address</h3>
                <p class="text-gray-700">{{ $order->shipping_address }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Billing Address</h3>
                <p class="text-gray-700">{{ $order->billing_address }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Vendor</h3>
                <p class="text-gray-700">{{ $order->vendor->name }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Payment Method</h3>
                <p class="text-gray-700">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
            </div>
            @if($order->notes)
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Order Notes</h3>
                    <p class="text-gray-700">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Order Totals -->
        <div class="border-t pt-6 mb-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                <div class="text-sm text-gray-600 mb-2 md:mb-0">
                    <div>Subtotal: ${{ number_format($order->subtotal, 2) }}</div>
                    <div>Tax: ${{ number_format($order->tax, 2) }}</div>
                    <div>Shipping: ${{ number_format($order->shipping, 2) }}</div>
                </div>
                <div class="text-lg font-semibold text-gray-900">Total: ${{ number_format($order->total, 2) }}</div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div class="flex gap-2">
                @if($order->canBeCancelled())
                    <form action="{{ route('orders.cancel', $order) }}" method="POST">
                        @csrf
                        <button type="submit" onclick="return confirm('Are you sure you want to cancel this order?')"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
                            Cancel Order
                        </button>
                    </form>
                @endif
                @if(auth()->user()->isVendor() && auth()->user()->id === $order->vendor_id)
                    <a href="{{ route('messages.show-order', $order) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                        Message Buyer
                    </a>
                @elseif(auth()->user()->isBuyer())
                    <a href="{{ route('messages.show-order', $order) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                        Message Vendor
                    </a>
                @endif
            </div>
            <div class="text-sm text-gray-500 mt-2 md:mt-0">
                Last updated: {{ $order->updated_at->diffForHumans() }}
            </div>
        </div>
    </div>
</div>
@endsection 