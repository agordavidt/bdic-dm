<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $totalUsers = User::count();
        $totalVendors = User::where('role', 'vendor')->count();
        $totalBuyers = User::where('role', 'buyer')->count();
        $totalDevices = Device::count();
        $recentRegistrations = User::latest()->limit(5)->get();

        return view('dashboards.admin', compact('totalUsers', 'totalVendors', 'totalBuyers', 'totalDevices', 'recentRegistrations'));
    }
} 