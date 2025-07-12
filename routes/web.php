<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceCategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Device;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Remove old /home route and closure-based dashboard routes
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Device Management Routes
Route::middleware(['auth'])->group(function () {
    
    // Device Routes
    Route::resource('devices', DeviceController::class);
    Route::patch('devices/{device}/status', [DeviceController::class, 'updateStatus'])->name('devices.update-status');
    Route::post('devices/{device}/transfer', [DeviceController::class, 'transfer'])->name('devices.transfer');
    
    // Device Category Routes (Admin/Manufacturer only)
    Route::middleware(['role:admin,manufacturer'])->group(function () {
        Route::resource('device-categories', DeviceCategoryController::class);
    });
    
    // Dashboard Routes by Role (now using controllers)
    Route::get('admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->middleware('role:admin')->name('admin.dashboard');
    Route::get('vendor/dashboard', [App\Http\Controllers\VendorDashboardController::class, 'index'])->middleware('role:vendor')->name('vendor.dashboard');
    Route::get('buyer/dashboard', [App\Http\Controllers\BuyerDashboardController::class, 'index'])->middleware('role:buyer')->name('buyer.dashboard');
    Route::get('manufacturer/dashboard', [App\Http\Controllers\ManufacturerDashboardController::class, 'index'])->middleware('role:manufacturer')->name('manufacturer.dashboard');
});

// Enhanced E-Commerce Module Routes with Vendor-Specific Organization

Route::middleware(['auth'])->group(function () {
    
    // Vendor-Specific Product Management Routes
    Route::middleware(['role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
        
        // Vendor Dashboard (existing)
        Route::get('dashboard', [App\Http\Controllers\VendorDashboardController::class, 'index'])->name('dashboard');
        
        // Product Management (FR_ECO_001, FR_ECO_002, FR_ECO_003, FR_ECO_004)
        Route::get('products', [App\Http\Controllers\ProductController::class, 'vendorIndex'])->name('products.index');
        Route::get('products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
        Route::post('products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
        Route::patch('products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
        
        // Product Status Management (FR_ECO_003)
        Route::patch('products/{product}/toggle-status', [App\Http\Controllers\ProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::patch('products/{product}/activate', [App\Http\Controllers\ProductController::class, 'activate'])->name('products.activate');
        Route::patch('products/{product}/deactivate', [App\Http\Controllers\ProductController::class, 'deactivate'])->name('products.deactivate');
        
        // Inventory Management (FR_ECO_004)
        Route::get('inventory', [App\Http\Controllers\VendorInventoryController::class, 'index'])->name('inventory.index');
        Route::patch('inventory/{product}/update-stock', [App\Http\Controllers\VendorInventoryController::class, 'updateStock'])->name('inventory.update-stock');
        Route::post('inventory/bulk-update', [App\Http\Controllers\VendorInventoryController::class, 'bulkUpdate'])->name('inventory.bulk-update');
        
        // Vendor Order Management
        Route::get('orders', [App\Http\Controllers\OrderController::class, 'vendorIndex'])->name('orders.index');
        Route::get('orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::patch('orders/{order}/payment', [App\Http\Controllers\OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
        
        // Analytics and Reports
        Route::get('analytics', [App\Http\Controllers\VendorAnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('reports/sales', [App\Http\Controllers\VendorReportsController::class, 'sales'])->name('reports.sales');
        Route::get('reports/inventory', [App\Http\Controllers\VendorReportsController::class, 'inventory'])->name('reports.inventory');
        
        // AJAX Endpoints for Vendor Operations
        Route::get('products/search', [App\Http\Controllers\ProductController::class, 'vendorSearch'])->name('products.search');
        Route::get('inventory/low-stock', [App\Http\Controllers\VendorInventoryController::class, 'lowStock'])->name('inventory.low-stock');
    });
    
    // Public Product Catalog (for buyers and general browsing)
    Route::prefix('catalog')->name('catalog.')->group(function () {
        Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
        Route::get('products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
        Route::get('categories/{category}', [App\Http\Controllers\ProductController::class, 'byCategory'])->name('products.by-category');
        Route::get('search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
    });
    
    // Buyer-Specific Routes
    Route::middleware(['role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
        // Shopping Cart
        Route::get('cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
        Route::post('cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
        Route::patch('cart/{cartItem}/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
        Route::delete('cart/{cartItem}/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
        Route::post('cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
        
        // Orders
        Route::get('orders', [App\Http\Controllers\OrderController::class, 'buyerIndex'])->name('orders.index');
        Route::get('orders/checkout', [App\Http\Controllers\OrderController::class, 'checkout'])->name('orders.checkout');
        Route::post('orders', [App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');
    });
    
    // Messaging (accessible to all authenticated users)
    Route::get('messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/user/{user}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::get('messages/order/{order}', [App\Http\Controllers\MessageController::class, 'showOrder'])->name('messages.show-order');
    Route::post('messages', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::post('messages/{message}/read', [App\Http\Controllers\MessageController::class, 'markAsRead'])->name('messages.mark-as-read');
});

// API Routes for AJAX calls
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('devices/search', [DeviceController::class, 'search'])->name('api.devices.search');
    Route::get('users/search', function (Request $request) {
        $users = User::where('email', 'like', '%' . $request->q . '%')
                    ->orWhere('name', 'like', '%' . $request->q . '%')
                    ->limit(10)
                    ->get(['id', 'name', 'email', 'role']);
        return response()->json($users);
    })->name('api.users.search');
    
    Route::get('devices/{device}/history', function (Device $device) {
        $transfers = $device->transfers()->with(['fromUser', 'toUser'])->get();
        return response()->json($transfers);
    })->name('api.devices.history');
    
    // Vendor-specific API endpoints
    Route::middleware(['role:vendor'])->prefix('vendor')->group(function () {
        Route::get('products/quick-stats', [App\Http\Controllers\ProductController::class, 'quickStats'])->name('api.vendor.products.quick-stats');
        Route::get('inventory/alerts', [App\Http\Controllers\VendorInventoryController::class, 'alerts'])->name('api.vendor.inventory.alerts');
        Route::get('orders/recent', [App\Http\Controllers\OrderController::class, 'recentVendorOrders'])->name('api.vendor.orders.recent');
    });
    
    // Buyer-specific API endpoints
    Route::middleware(['role:buyer'])->group(function () {
        Route::get('cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('api.cart.count');
        Route::get('cart/total', [App\Http\Controllers\CartController::class, 'total'])->name('api.cart.total');
        Route::get('messages/unread-count', [App\Http\Controllers\MessageController::class, 'unreadCount'])->name('api.messages.unread-count');
        Route::get('messages/recent', [App\Http\Controllers\MessageController::class, 'recent'])->name('api.messages.recent');
        Route::get('messages/search-users', [App\Http\Controllers\MessageController::class, 'searchUsers'])->name('api.messages.search-users');
    });
});