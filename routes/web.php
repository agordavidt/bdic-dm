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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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
    
    // Dashboard Routes by Role
    Route::get('vendor/dashboard', function () {return view('dashboards.vendor');})->middleware('role:vendor')->name('vendor.dashboard');
    
    Route::get('buyer/dashboard', function () {return view('dashboards.buyer'); })->middleware('role:buyer')->name('buyer.dashboard');
    
    Route::get('admin/dashboard', function () {return view('dashboards.admin'); })->middleware('role:admin')->name('admin.dashboard');
    
    Route::get('manufacturer/dashboard', function () { return view('dashboards.manufacturer'); })->middleware('role:manufacturer')->name('manufacturer.dashboard');
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