<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class VendorAnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:vendor']);
    }

    public function index()
    {
        $vendorId = Auth::id();

        $totalSales = OrderItem::whereHas('order', function($q) use ($vendorId) {
            $q->where('vendor_id', $vendorId);
        })->sum('total_price');

        $totalOrders = Order::where('vendor_id', $vendorId)->count();
        $totalProducts = Product::where('vendor_id', $vendorId)->count();
        $revenue = Order::where('vendor_id', $vendorId)->where('payment_status', 'paid')->sum('total');

        $analytics = [
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'total_products' => $totalProducts,
            'revenue' => $revenue,
        ];

        return view('vendor.analytics.index', compact('analytics'));
    }
} 