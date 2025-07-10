<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of conversations
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get unique conversations
        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver', 'order'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($user) {
                if ($message->sender_id === $user->id) {
                    return $message->receiver_id;
                } else {
                    return $message->sender_id;
                }
            });

        return view('messages.index', compact('conversations'));
    }

    /**
     * Show conversation with a specific user
     */
    public function show(User $user)
    {
        $currentUser = Auth::user();
        
        // Get conversation between current user and selected user
        $messages = Message::getConversation($currentUser->id, $user->id);
        
        // Mark messages as read
        $messages->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->each(function ($message) {
                $message->markAsRead();
            });

        return view('messages.show', compact('messages', 'user'));
    }

    /**
     * Show conversation related to an order
     */
    public function showOrder(Order $order)
    {
        $this->authorize('view', $order);
        
        $currentUser = Auth::user();
        $otherUser = $currentUser->id === $order->buyer_id ? $order->vendor : $order->buyer;
        
        // Get conversation related to this order
        $messages = Message::getConversation($currentUser->id, $otherUser->id, $order->id);
        
        // Mark messages as read
        $messages->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->each(function ($message) {
                $message->markAsRead();
            });

        $user = $otherUser;
        return view('messages.show', compact('messages', 'user', 'order'));
    }

    /**
     * Store a newly created message
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:general,order_inquiry,support,payment',
            'order_id' => 'nullable|exists:orders,id',
        ]);

        // Ensure user can't send message to themselves
        if ($validated['receiver_id'] === Auth::id()) {
            return back()->with('error', 'You cannot send a message to yourself.');
        }

        // If order_id is provided, verify user has access to the order
        if ($validated['order_id']) {
            $order = Order::findOrFail($validated['order_id']);
            if (!in_array(Auth::id(), [$order->buyer_id, $order->vendor_id])) {
                return back()->with('error', 'You do not have access to this order.');
            }
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'order_id' => $validated['order_id'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'type' => $validated['type'],
        ]);

        return back()->with('success', 'Message sent successfully.');
    }

    /**
     * Mark message as read
     */
    public function markAsRead(Message $message)
    {
        $this->authorize('update', $message);

        $message->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Get unread message count for AJAX requests
     */
    public function unreadCount()
    {
        $count = Auth::user()->unread_message_count;
        
        return response()->json(['count' => $count]);
    }

    /**
     * Get recent messages for AJAX requests
     */
    public function recent()
    {
        $messages = Auth::user()->receivedMessages()
            ->with(['sender', 'order'])
            ->unread()
            ->latest()
            ->limit(5)
            ->get();

        return response()->json($messages);
    }

    /**
     * Search for users to message
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('q');
        
        $users = User::where('id', '!=', Auth::id())
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email', 'role']);

        return response()->json($users);
    }
} 