@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Conversation with {{ $user->name }}</h1>
        <a href="{{ route('messages.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Messages</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
        <!-- Message History -->
        <div class="mb-6 max-h-96 overflow-y-auto divide-y">
            @forelse($messages as $message)
                <div class="py-4 flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs w-full">
                        <div class="flex items-center mb-1">
                            <span class="text-xs text-gray-500">
                                {{ $message->created_at->format('M d, Y g:i A') }}
                                @if($message->is_read && $message->receiver_id === auth()->id())
                                    <span class="ml-2 text-green-500">Read</span>
                                @endif
                            </span>
                        </div>
                        <div class="p-3 rounded-lg {{ $message->sender_id === auth()->id() ? 'bg-blue-100 text-blue-900' : 'bg-gray-100 text-gray-900' }}">
                            @if($message->subject)
                                <div class="font-semibold mb-1">{{ $message->subject }}</div>
                            @endif
                            <div>{{ $message->message }}</div>
                        </div>
                        @if($message->order)
                            <div class="text-xs text-blue-600 mt-1">
                                Related to Order #{{ $message->order->order_number }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">No messages yet. Start the conversation below.</div>
            @endforelse
        </div>

        <!-- Reply Form -->
        <form action="{{ route('messages.store') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
            @if(isset($order))
                <input type="hidden" name="order_id" value="{{ $order->id }}">
            @endif
            <div class="mb-4">
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject (optional)</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea name="message" id="message" rows="3" required
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Type your message..."></textarea>
            </div>
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" id="type" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="general">General</option>
                    <option value="order_inquiry">Order Inquiry</option>
                    <option value="support">Support</option>
                    <option value="payment">Payment</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Send Message
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 