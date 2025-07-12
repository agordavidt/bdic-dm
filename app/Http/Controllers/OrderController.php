<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['buyer', 'vendor', 'orderItems.product']);

        // Filter by user role
        if (Auth::user()->isBuyer()) {
            $query->where('buyer_id', Auth::id());
        } elseif (Auth::user()->isVendor()) {
            $query->where('vendor_id', Auth::id());
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->paginate(15);

        return view('buyer.orders.index', compact('orders'));
    }

    /**
     * Display a listing of the vendor's orders (vendor dashboard)
     */
    public function vendorIndex(Request $request)
    {
        $query = Order::with(['buyer', 'orderItems.product'])
            ->where('vendor_id', auth()->id());

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->paginate(20);

        return view('vendor.orders.index', compact('orders'));
    }

    /**
     * Show checkout form
     */
    public function checkout()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('buyer.cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate cart items
        foreach ($cartItems as $item) {
            if (!$item->isProductAvailable()) {
                return redirect()->route('buyer.cart.index')
                    ->with('error', "Product '{$item->product->name}' is no longer available.");
            }

            if (!$item->isQuantityAvailable()) {
                return redirect()->route('buyer.cart.index')
                    ->with('error', "Insufficient stock for '{$item->product->name}'.");
            }
        }

        $total = $cartItems->sum('total_price');
        $shipping = 0; // Calculate shipping based on location
        $tax = $total * 0.1; // 10% tax rate
        $grandTotal = $total + $shipping + $tax;

        return view('buyer.orders.checkout', compact('cartItems', 'total', 'shipping', 'tax', 'grandTotal'));
    }

    /**
     * Process checkout and create order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
            'payment_method' => 'required|in:credit_card,bank_transfer,cash_on_delivery',
            'notes' => 'nullable|string',
        ]);

        $cartItems = Auth::user()->cartItems()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('buyer.cart.index')->with('error', 'Your cart is empty.');
        }

        // Group cart items by vendor
        $vendorGroups = $cartItems->groupBy('product.vendor_id');

        DB::beginTransaction();

        try {
            foreach ($vendorGroups as $vendorId => $items) {
                // Calculate totals
                $subtotal = $items->sum('total_price');
                $shipping = 0; // Calculate based on location
                $tax = $subtotal * 0.1; // 10% tax
                $total = $subtotal + $shipping + $tax;

                // Create order
                $order = Order::create([
                    'order_number' => Order::generateOrderNumber(),
                    'buyer_id' => Auth::id(),
                    'vendor_id' => $vendorId,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping' => $shipping,
                    'total' => $total,
                    'payment_method' => $validated['payment_method'],
                    'shipping_address' => $validated['shipping_address'],
                    'billing_address' => $validated['billing_address'],
                    'notes' => $validated['notes'],
                ]);

                // Create order items and update stock
                foreach ($items as $cartItem) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'unit_price' => $cartItem->product->price,
                        'total_price' => $cartItem->total_price,
                    ]);

                    // Update product stock
                    $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
                }
            }

            // Clear cart
            Auth::user()->cartItems()->delete();

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while processing your order.');
        }
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return view('buyer.orders.show', compact('order'));
    }

    /**
     * Update order status (for vendors)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        // Update timestamps
        if ($validated['status'] === 'shipped') {
            $order->update(['shipped_at' => now()]);
        } elseif ($validated['status'] === 'delivered') {
            $order->update(['delivered_at' => now()]);
        }

        return back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'transaction_id' => 'nullable|string',
        ]);

        $order->update([
            'payment_status' => $validated['payment_status'],
            'transaction_id' => $validated['transaction_id'],
            'paid_at' => $validated['payment_status'] === 'paid' ? now() : null,
        ]);

        return back()->with('success', 'Payment status updated successfully.');
    }

    /**
     * Cancel order
     */
    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        DB::beginTransaction();

        try {
            // Update order status
            $order->update(['status' => 'cancelled']);

            // Restore product stock
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
            }

            DB::commit();

            return back()->with('success', 'Order cancelled successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while cancelling the order.');
        }
    }
} 