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

// E-Commerce Module Routes
Route::middleware(['auth'])->group(function () {
    // Product Catalog (Vendor: manage, Buyer: view)
    Route::resource('products', App\Http\Controllers\ProductController::class);

    // Shopping Cart
    Route::get('cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::patch('cart/{cartItem}/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/{cartItem}/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    // AJAX endpoints
    Route::get('cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');
    Route::get('cart/total', [App\Http\Controllers\CartController::class, 'total'])->name('cart.total');

    // Orders
    Route::get('orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/checkout', [App\Http\Controllers\OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('orders', [App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('orders/{order}/payment', [App\Http\Controllers\OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
    Route::post('orders/{order}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');

    // Messaging
    Route::get('messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/user/{user}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::get('messages/order/{order}', [App\Http\Controllers\MessageController::class, 'showOrder'])->name('messages.show-order');
    Route::post('messages', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::post('messages/{message}/read', [App\Http\Controllers\MessageController::class, 'markAsRead'])->name('messages.mark-as-read');
    // AJAX endpoints
    Route::get('messages/unread-count', [App\Http\Controllers\MessageController::class, 'unreadCount'])->name('messages.unread-count');
    Route::get('messages/recent', [App\Http\Controllers\MessageController::class, 'recent'])->name('messages.recent');
    Route::get('messages/search-users', [App\Http\Controllers\MessageController::class, 'searchUsers'])->name('messages.search-users');
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
});