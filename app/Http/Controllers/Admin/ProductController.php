<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $query = Product::with(['vendor', 'category']);

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', 'active');
            } elseif ($request->status === 'inactive') {
                $query->where('status', 'inactive');
            }
        }

        // Filter by vendor
        if ($request->filled('vendor')) {
            $query->where('vendor_id', $request->vendor);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(20);
        $vendors = User::where('role', 'vendor')->get();

        // Statistics
        $stats = [
            'total' => Product::count(),
            'active' => Product::where('status', 'active')->count(),
            'lowStock' => Product::where('stock_quantity', '<=', 10)->count(),
            'activeVendors' => User::where('role', 'vendor')->whereHas('products')->count(),
        ];

        return view('admin.products.index', compact('products', 'vendors', 'stats'));
    }

    public function show(Product $product)
    {
        $product->load(['vendor', 'category', 'orderItems']);
        
        return view('admin.products.show', compact('product'));
    }

    public function toggleStatus(Product $product)
    {
        $newStatus = $product->status === 'active' ? 'inactive' : 'active';
        $product->update(['status' => $newStatus]);
        
        return response()->json([
            'success' => true,
            'message' => 'Product status updated successfully'
        ]);
    }
} 