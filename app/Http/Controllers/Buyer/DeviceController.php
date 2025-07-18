<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:buyer']);
    }

    public function index()
    {
        $user = Auth::user();
        $devicesByEmail = \App\Models\Device::byBuyerEmail($user->email);
        $devicesById = \App\Models\Device::where('buyer_id', $user->id);
        $devices = $devicesByEmail->union($devicesById)->latest()->paginate(20);
        return view('buyer.devices.index', compact('devices'));
    }
} 