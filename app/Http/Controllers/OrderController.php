<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // BUYER: List their orders
    public function index(Request $request)
    {
        $orders = Order::with(['vendor', 'orderItems.product'])
            ->where('buyer_id', Auth::id())
            ->latest()
            ->paginate(20);
        return view('buyer.orders.index', compact('orders'));
    }

    // BUYER: Show checkout page
    public function checkout()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        $total = $cartItems->sum('total_price');
        $tax = 0;
        $shipping = 0;
        $grandTotal = $total + $tax + $shipping;
        return view('buyer.orders.checkout', compact('cartItems', 'total', 'tax', 'shipping', 'grandTotal'));
    }

    // BUYER: Place order
    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            $order = Order::create([
                'buyer_id' => $user->id,
                'vendor_id' => $cartItems->first()->product->vendor_id ?? null,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'pending',
                'payment_status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
                'billing_address' => $validated['billing_address'],
                'subtotal' => $cartItems->sum('total_price'),
                'tax' => 0,
                'shipping' => 0,
                'total' => $cartItems->sum('total_price'),
            ]);
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                    'total_price' => $item->total_price,
                ]);
                // Decrement product stock
                $item->product->decrement('stock_quantity', $item->quantity);
            }
            $user->cartItems()->delete();
            DB::commit();
            return redirect()->route('buyer.orders.show', $order)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    // BUYER: Show order details
    public function show(Order $order)
    {
        $user = Auth::user();
        if ($user->isBuyer() && $order->buyer_id !== $user->id) {
            abort(403);
        }
        if ($user->isVendor() && $order->vendor_id !== $user->id) {
            abort(403);
        }
        $order->load(['orderItems.product', 'vendor', 'buyer']);
        if ($user->isBuyer()) {
            return view('buyer.orders.show', compact('order'));
        } elseif ($user->isVendor()) {
            return view('vendor.orders.show', compact('order'));
        } else {
            abort(403);
        }
    }

    // BUYER: Cancel order
    public function cancel(Order $order)
    {
        $user = Auth::user();
        if ($order->buyer_id !== $user->id || !$order->canBeCancelled()) {
            abort(403);
        }
        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'Order cancelled successfully.');
    }

    // VENDOR: List their orders
    public function vendorIndex(Request $request)
    {
        $orders = Order::with(['buyer', 'orderItems.product'])
            ->where('vendor_id', Auth::id())
            ->latest()
            ->paginate(20);
        return view('vendor.orders.index', compact('orders'));
    }

    // VENDOR: Update order status
    public function updateStatus(Request $request, Order $order)
    {
        $user = Auth::user();
        if ($user->isVendor() && $order->vendor_id !== $user->id) {
            abort(403);
        }
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);
        $order->update(['status' => $validated['status']]);
        return back()->with('success', 'Order status updated successfully.');
    }

    // VENDOR: Update payment status
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $user = Auth::user();
        if ($user->isVendor() && $order->vendor_id !== $user->id) {
            abort(403);
        }
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);
        $order->update(['payment_status' => $validated['payment_status']]);
        return back()->with('success', 'Payment status updated successfully.');
    }
}