<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\DeviceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Key metrics
        $metrics = $this->getKeyMetrics();
        
        // Chart data
        $revenueData = $this->getRevenueData();
        $categoriesData = $this->getCategoriesData();
        $orderStatusData = $this->getOrderStatusData();
        $growthData = $this->getGrowthData();
        
        // Top performers
        $topVendors = $this->getTopVendors();
        $topProducts = $this->getTopProducts();

        return view('admin.analytics.index', compact(
            'metrics',
            'revenueData',
            'categoriesData',
            'orderStatusData',
            'growthData',
            'topVendors',
            'topProducts'
        ));
    }

    private function getKeyMetrics()
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // Current month data
        $currentGMV = Order::where('status', 'delivered')
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->sum('total');

        $currentOrders = Order::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        $currentProducts = Product::where('status', 'active')
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        $currentVendors = User::where('role', 'vendor')
            ->whereHas('products')
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        // Last month data
        $lastGMV = Order::where('status', 'delivered')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('total');

        $lastOrders = Order::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $lastProducts = Product::where('status', 'active')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $lastVendors = User::where('role', 'vendor')
            ->whereHas('products')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        // Calculate growth percentages
        $gmvGrowth = $lastGMV > 0 ? (($currentGMV - $lastGMV) / $lastGMV) * 100 : 0;
        $orderGrowth = $lastOrders > 0 ? (($currentOrders - $lastOrders) / $lastOrders) * 100 : 0;
        $productGrowth = $lastProducts > 0 ? (($currentProducts - $lastProducts) / $lastProducts) * 100 : 0;
        $vendorGrowth = $lastVendors > 0 ? (($currentVendors - $lastVendors) / $lastVendors) * 100 : 0;

        // Performance metrics
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'delivered')->sum('total');
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        $totalCustomers = User::where('role', 'buyer')->count();
        $repeatCustomers = User::where('role', 'buyer')
            ->whereHas('buyerOrders', function($q) {
                $q->where('status', 'delivered');
            }, '>', 1)
            ->count();
        $customerRetention = $totalCustomers > 0 ? ($repeatCustomers / $totalCustomers) * 100 : 0;

        $totalVendors = User::where('role', 'vendor')->count();
        $totalActiveProducts = Product::where('status', 'active')->count();
        $productsPerVendor = $totalVendors > 0 ? $totalActiveProducts / $totalVendors : 0;

        // Conversion rate (simplified - orders vs total users)
        $totalUsers = User::count();
        $conversionRate = $totalUsers > 0 ? ($totalOrders / $totalUsers) * 100 : 0;

        return [
            'totalGMV' => $currentGMV,
            'gmvGrowth' => $gmvGrowth,
            'totalOrders' => $currentOrders,
            'orderGrowth' => $orderGrowth,
            'activeProducts' => $currentProducts,
            'productGrowth' => $productGrowth,
            'activeVendors' => $currentVendors,
            'vendorGrowth' => $vendorGrowth,
            'averageOrderValue' => $averageOrderValue,
            'conversionRate' => $conversionRate,
            'customerRetention' => $customerRetention,
            'productsPerVendor' => $productsPerVendor,
        ];
    }

    private function getRevenueData()
    {
        $months = [];
        $revenue = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $monthRevenue = Order::where('status', 'delivered')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total');
            
            $revenue[] = $monthRevenue;
        }

        return [
            'labels' => $months,
            'data' => $revenue
        ];
    }

    private function getCategoriesData()
    {
        $categories = DeviceCategory::withCount(['products' => function($query) {
            $query->where('status', 'active');
        }])
        ->withSum(['products' => function($query) {
            $query->where('status', 'active');
        }], 'price')
        ->orderBy('products_count', 'desc')
        ->limit(5)
        ->get();

        return [
            'labels' => $categories->pluck('name')->toArray(),
            'data' => $categories->pluck('products_sum_price')->toArray()
        ];
    }

    private function getOrderStatusData()
    {
        return [
            Order::where('status', 'pending')->count(),
            Order::where('status', 'processing')->count(),
            Order::where('status', 'shipped')->count(),
            Order::where('status', 'delivered')->count(),
            Order::where('status', 'cancelled')->count(),
        ];
    }

    private function getGrowthData()
    {
        $months = [];
        $orders = [];
        $revenue = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');
            
            $monthOrders = Order::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            
            $monthRevenue = Order::where('status', 'delivered')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total');
            
            $orders[] = $monthOrders;
            $revenue[] = $monthRevenue;
        }

        return [
            'labels' => $months,
            'orders' => $orders,
            'revenue' => $revenue
        ];
    }

    private function getTopVendors()
    {
        return User::where('role', 'vendor')
            ->withCount(['products' => function($query) {
                $query->where('status', 'active');
            }])
            ->withCount(['products as orders_count' => function($query) {
                $query->whereHas('orderItems');
            }])
            ->withSum(['products as total_revenue' => function($query) {
                $query->whereHas('orderItems.order', function($orderQuery) {
                    $orderQuery->where('status', 'delivered');
                });
            }], 'price')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();
    }

    private function getTopProducts()
    {
        return Product::with('vendor')
            ->withCount(['orderItems as sales_count'])
            ->withSum(['orderItems as total_revenue' => function($query) {
                $query->whereHas('order', function($orderQuery) {
                    $orderQuery->where('status', 'delivered');
                });
            }], 'total_price')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();
    }
} 