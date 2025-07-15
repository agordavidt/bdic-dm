<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Device;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

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
    
    // Dashboard Routes by Role (dashboard stays in dashboards directory)
    Route::get('admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->middleware('role:admin')->name('admin.dashboard');
    Route::get('vendor/dashboard', [App\Http\Controllers\VendorDashboardController::class, 'index'])->middleware('role:vendor')->name('vendor.dashboard');
    Route::get('buyer/dashboard', [App\Http\Controllers\BuyerDashboardController::class, 'index'])->middleware('role:buyer')->name('buyer.dashboard');
    Route::get('manufacturer/dashboard', [App\Http\Controllers\ManufacturerDashboardController::class, 'index'])->middleware('role:manufacturer')->name('manufacturer.dashboard');
    
    // Admin E-commerce Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Product Management
        Route::get('products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
        Route::get('products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'show'])->name('products.show');
        Route::patch('products/{product}/toggle-status', [App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('products.toggle-status');
        
        // Order Management (admin only)
        Route::get('orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
        
        // Analytics
        Route::get('analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index');
    });
});

// Enhanced E-Commerce Module Routes

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
    
    // Public Product Catalog - accessible to all authenticated users
    // FR_ECO_006: Browse products by categories
    // FR_ECO_007: View detailed product information
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/category/{category}', [ProductController::class, 'byCategory'])->name('by-category');
        Route::get('/search', [ProductController::class, 'search'])->name('search');
    });
    
    // Buyer-Specific Routes - Views will be in resources/views/buyer/
    Route::middleware(['role:buyer'])->group(function () {
        
        // Shopping Cart Routes - FR_ECO_008, FR_ECO_009
        // Views: resources/views/buyer/cart/
        Route::prefix('buyer/cart')->name('buyer.cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add', [CartController::class, 'add'])->name('add');
            Route::patch('/{cartItem}', [CartController::class, 'update'])->name('update');
            Route::delete('/{cartItem}', [CartController::class, 'remove'])->name('remove');
            Route::delete('/', [CartController::class, 'clear'])->name('clear');
        });
        
        // Checkout and Order Routes - FR_ECO_010, FR_ECO_011, FR_ECO_012, FR_ECO_015
        // Views: resources/views/buyer/orders/
        Route::prefix('buyer/orders')->name('buyer.orders.')->group(function () {
            Route::get('/', [App\Http\Controllers\OrderController::class, 'index'])->name('index');
            Route::get('/checkout', [App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
            Route::post('/', [App\Http\Controllers\OrderController::class, 'store'])->name('store');
            Route::get('/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('show');
            Route::post('/{order}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('cancel');
        });
        
        // Buyer Product Browsing - specific buyer views
        // Views: resources/views/buyer/products/
        Route::prefix('buyer/products')->name('buyer.products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/{product}', [ProductController::class, 'show'])->name('show');
            Route::get('/category/{category}', [ProductController::class, 'byCategory'])->name('by-category');
        });
        
        // Buyer Profile Management
        // Views: resources/views/buyer/profile/
        Route::prefix('buyer/profile')->name('buyer.profile.')->group(function () {
            Route::get('/', [App\Http\Controllers\BuyerProfileController::class, 'show'])->name('show');
            Route::get('/edit', [App\Http\Controllers\BuyerProfileController::class, 'edit'])->name('edit');
            Route::patch('/', [App\Http\Controllers\BuyerProfileController::class, 'update'])->name('update');
        });
    });
});

// Vendor Device Management
Route::middleware(['role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('devices', [\App\Http\Controllers\DeviceController::class, 'index'])->name('devices.index');
    Route::get('devices/create', [\App\Http\Controllers\DeviceController::class, 'create'])->name('devices.create');
    Route::post('devices', [\App\Http\Controllers\DeviceController::class, 'store'])->name('devices.store');
    Route::get('devices/{device}', [\App\Http\Controllers\DeviceController::class, 'show'])->name('devices.show');
    Route::get('devices/{device}/edit', [\App\Http\Controllers\DeviceController::class, 'edit'])->name('devices.edit');
    Route::patch('devices/{device}', [\App\Http\Controllers\DeviceController::class, 'update'])->name('devices.update');
    Route::delete('devices/{device}', [\App\Http\Controllers\DeviceController::class, 'destroy'])->name('devices.destroy');
});

// Buyer Fault Reports
Route::prefix('buyer/fault-reports')->name('buyer.fault_reports.')->middleware(['role:buyer'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Buyer\FaultReportController::class, 'index'])->name('index');
    Route::get('/create/{device}', [\App\Http\Controllers\Buyer\FaultReportController::class, 'create'])->name('create');
    Route::post('/store/{device}', [\App\Http\Controllers\Buyer\FaultReportController::class, 'store'])->name('store');
    Route::get('/{faultReport}', [\App\Http\Controllers\Buyer\FaultReportController::class, 'show'])->name('show');
});

// Vendor Fault Reports
Route::prefix('vendor/fault-reports')->name('vendor.fault_reports.')->middleware(['role:vendor'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Vendor\FaultReportController::class, 'index'])->name('index');
    Route::get('/{faultReport}', [\App\Http\Controllers\Vendor\FaultReportController::class, 'show'])->name('show');
    Route::patch('/{faultReport}/resolve', [\App\Http\Controllers\Vendor\FaultReportController::class, 'resolve'])->name('resolve');
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
        Route::get('products/quick-stats', [ProductController::class, 'quickStats'])->name('api.vendor.products.quick-stats');
        Route::get('inventory/alerts', [App\Http\Controllers\VendorInventoryController::class, 'alerts'])->name('api.vendor.inventory.alerts');
        Route::get('orders/recent', [OrderController::class, 'recentVendorOrders'])->name('api.vendor.orders.recent');
    });
    
    // Buyer-specific API endpoints
    Route::middleware(['role:buyer'])->group(function () {
        Route::get('cart/count', [CartController::class, 'count'])->name('api.cart.count');
        Route::get('cart/total', [CartController::class, 'total'])->name('api.cart.total');
        Route::get('products/search', [ProductController::class, 'search'])->name('api.products.search');
    });
});