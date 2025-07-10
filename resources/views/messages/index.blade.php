@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Messages</h1>
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Products</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Conversations List -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold text-gray-900">Conversations</h2>
                </div>
                
                @if($conversations->count() > 0)
                    <div class="divide-y">
                        @foreach($conversations as $userId => $messages)
                            @php
                                $otherUser = $messages->first()->sender_id === auth()->id() 
                                    ? $messages->first()->receiver 
                                    : $messages->first()->sender;
                                $latestMessage = $messages->first();
                                $unreadCount = $messages->where('receiver_id', auth()->id())->where('is_read', false)->count();
                            @endphp
                            
                            <a href="{{ route('messages.show', $otherUser) }}" 
                               class="block p-4 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex items-center space-x-3">
                                    <!-- User Avatar -->
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-semibold text-lg">
                                            {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm font-medium text-gray-900 truncate">
                                                {{ $otherUser->name }}
                                            </h3>
                                            <span class="text-xs text-gray-500">
                                                {{ $latestMessage->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-sm text-gray-600 truncate mt-1">
                                            @if($latestMessage->sender_id === auth()->id())
                                                <span class="text-gray-400">You:</span>
                                            @endif
                                            {{ Str::limit($latestMessage->message, 50) }}
                                        </p>
                                        
                                        @if($latestMessage->order)
                                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mt-1">
                                                Order #{{ $latestMessage->order->order_number }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($unreadCount > 0)
                                        <div class="flex-shrink-0">
                                            <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1">
                                                {{ $unreadCount }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center">
                        <div class="text-gray-500 text-lg mb-2">No conversations yet</div>
                        <p class="text-gray-400 text-sm">Start a conversation by messaging a vendor or buyer.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Welcome/Instructions -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Welcome to Messages</h2>
                <p class="text-gray-600 mb-6">
                    Select a conversation from the list to start messaging. You can communicate with vendors about products or discuss order details.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-blue-900 mb-2">For Buyers</h3>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Ask vendors about products</li>
                            <li>• Discuss order details</li>
                            <li>• Get support with orders</li>
                        </ul>
                    </div>
                    
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-green-900 mb-2">For Vendors</h3>
                        <ul class="text-sm text-green-800 space-y-1">
                            <li>• Answer buyer questions</li>
                            <li>• Provide order updates</li>
                            <li>• Offer customer support</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 