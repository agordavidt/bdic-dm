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
        $totalDevices = Device::where('vendor_id', $user->id)->count();
        $devicesSold = Device::where('vendor_id', $user->id)->whereNotNull('buyer_id')->count();
        $pendingReports = 0; // Placeholder, update with actual logic if available
        $monthlySales = 0; // Placeholder, update with actual logic if available
        $recentActivities = []; // Placeholder, update with actual logic if available

        return view('dashboards.vendor', compact('totalDevices', 'devicesSold', 'pendingReports', 'monthlySales', 'recentActivities'));
    }
} 