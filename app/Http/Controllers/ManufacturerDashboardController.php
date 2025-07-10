<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class ManufacturerDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:manufacturer']);
    }

    public function index()
    {
        $totalDevices = Device::count();
        $faultReports = 0; // Placeholder, update with actual logic if available
        $recentFaultReports = []; // Placeholder, update with actual logic if available

        return view('dashboards.manufacturer', compact('totalDevices', 'faultReports', 'recentFaultReports'));
    }
} 