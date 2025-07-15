<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Device;
use App\Models\Product;
use App\Models\Order;
use App\Models\DeviceCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Basic metrics
        $totalUsers = User::count();
        $totalVendors = User::where('role', 'vendor')->count();
        $totalBuyers = User::where('role', 'buyer')->count();
        $totalDevices = Device::count();
        $recentRegistrations = User::latest()->limit(5)->get();

        // E-commerce metrics
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalGMV = Order::where('status', 'delivered')->sum('total');
        $activeVendors = User::where('role', 'vendor')->whereHas('products')->count();
        $recentOrders = Order::with('buyer')->latest()->limit(5)->get();

        // Top categories - simplified for now since we need to check the relationships
        $topCategories = DeviceCategory::withCount(['products' => function($query) {
            $query->where('status', 'active'); // Use 'status' column with 'active' value
        }])
        ->orderBy('products_count', 'desc')
        ->limit(5)
        ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalVendors', 
            'totalBuyers', 
            'totalDevices', 
            'recentRegistrations',
            'totalProducts',
            'totalOrders',
            'totalGMV',
            'activeVendors',
            'recentOrders',
            'topCategories'
        ));
    }
} 