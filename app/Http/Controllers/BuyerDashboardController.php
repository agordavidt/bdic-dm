<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Support\Facades\Auth;

class BuyerDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:buyer']);
    }

    public function index()
    {
        $user = Auth::user();
        $ownedDevices = Device::where('buyer_id', $user->id)->count();
        $activeReports = 0; // Placeholder, update with actual logic if available
        $resolvedReports = 0; // Placeholder, update with actual logic if available
        $devices = Device::where('buyer_id', $user->id)->get();

        return view('dashboards.buyer', compact('ownedDevices', 'activeReports', 'resolvedReports', 'devices'));
    }
} 