<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        $total = $cartItems->sum('total_price');

        return view('buyer.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check if product is available
        if (!$product->isInStock()) {
            return back()->with('error', 'Product is out of stock.');
        }

        // Check if requested quantity is available
        if ($validated['quantity'] > $product->stock_quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        // Check if item already exists in cart
        $existingItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingItem) {
            // Update quantity
            $newQuantity = $existingItem->quantity + $validated['quantity'];
            
            if ($newQuantity > $product->stock_quantity) {
                return back()->with('error', 'Total quantity exceeds available stock.');
            }

            $existingItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
            ]);
        }

        return back()->with('success', 'Item added to cart successfully.');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorize('update', $cartItem);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = $cartItem->product;

        // Check if requested quantity is available
        if ($validated['quantity'] > $product->stock_quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cartItem->update(['quantity' => $validated['quantity']]);

        return back()->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove item from cart
     */
    public function remove(CartItem $cartItem)
    {
        $this->authorize('delete', $cartItem);

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        Auth::user()->cartItems()->delete();

        return back()->with('success', 'Cart cleared successfully.');
    }

    /**
     * Get cart count for AJAX requests
     */
    public function count()
    {
        $count = Auth::user()->cartItems()->sum('quantity');
        
        return response()->json(['count' => $count]);
    }

    /**
     * Get cart total for AJAX requests
     */
    public function total()
    {
        $total = Auth::user()->cart_total;
        
        return response()->json(['total' => $total]);
    }
} 