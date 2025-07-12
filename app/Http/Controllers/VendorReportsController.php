<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:vendor']);
    }

    public function sales(Request $request)
    {
        $vendorId = Auth::id();

        $query = OrderItem::with(['order', 'product', 'order.buyer'])
            ->whereHas('order', function($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            });

        // Date filter
        if ($request->filled('start_date')) {
            $query->whereHas('order', function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->start_date);
            });
        }
        if ($request->filled('end_date')) {
            $query->whereHas('order', function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->end_date);
            });
        }

        $sales = $query->latest()->paginate(20);

        return view('vendor.reports.sales', compact('sales'));
    }
} 