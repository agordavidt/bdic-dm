@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">← Browse Products</a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('orders.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                <select name="status" id="status" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            
            <div>
                <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                <select name="payment_status" id="payment_status" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Payment Statuses</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Filter
                </button>
                <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Orders List -->
    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->order_number }}</h3>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <!-- Order Status Badge -->
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
                                
                                <!-- Payment Status Badge -->
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
                        <div class="space-y-3 mb-4">
                            @foreach($order->orderItems as $item)
                                <div class="flex items-center space-x-3">
                                    @if($item->product->main_image)
                                        <img src="{{ $item->product->main_image }}" alt="{{ $item->product->name }}" 
                                             class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
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
                        
                        <!-- Order Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Vendor:</span>
                                <span class="text-gray-600">{{ $order->vendor->name }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Payment Method:</span>
                                <span class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                            </div>
                            @if($order->notes)
                                <div class="md:col-span-2">
                                    <span class="font-medium text-gray-700">Notes:</span>
                                    <span class="text-gray-600">{{ $order->notes }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Order Totals -->
                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    <div>Subtotal: ${{ number_format($order->subtotal, 2) }}</div>
                                    <div>Tax: ${{ number_format($order->tax, 2) }}</div>
                                    <div>Shipping: ${{ number_format($order->shipping, 2) }}</div>
                                    <div class="font-semibold text-gray-900 mt-1">Total: ${{ number_format($order->total, 2) }}</div>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('orders.show', $order) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                                        View Details
                                    </a>
                                    
                                    @if($order->canBeCancelled())
                                        <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
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
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-500 text-xl mb-4">No orders found</div>
            <p class="text-gray-400 mb-6">You haven't placed any orders yet.</p>
            <a href="{{ route('products.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection 