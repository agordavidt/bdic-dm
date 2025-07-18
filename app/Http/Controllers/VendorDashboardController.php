<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:vendor']);
    }

    public function index()
    {
        $user = Auth::user();
        $totalDevices = \App\Models\Device::where('vendor_id', $user->id)->count();
        $devicesSold = \App\Models\Device::where('vendor_id', $user->id)->whereNotNull('buyer_id')->count();
        $totalProducts = \App\Models\Product::where('vendor_id', $user->id)->count();
        $totalFaults = \App\Models\FaultReport::whereIn('device_id', \App\Models\Device::where('vendor_id', $user->id)->pluck('id'))->count();
        $pendingFaults = \App\Models\FaultReport::whereIn('device_id', \App\Models\Device::where('vendor_id', $user->id)->pluck('id'))->where('status', 'pending')->count();

        $recentDevices = \App\Models\Device::where('vendor_id', $user->id)->latest()->take(5)->get();
        $recentFaults = \App\Models\FaultReport::whereIn('device_id', \App\Models\Device::where('vendor_id', $user->id)->pluck('id'))->latest()->take(5)->get();

        return view('dashboards.vendor', compact(
            'totalDevices', 'devicesSold', 'totalProducts', 'totalFaults', 'pendingFaults', 'recentDevices', 'recentFaults'
        ));
    }
} 