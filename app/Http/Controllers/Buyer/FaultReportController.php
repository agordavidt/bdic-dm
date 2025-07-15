<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\FaultReport;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaultReportController extends Controller
{
    public function index()
    {
        $reports = FaultReport::where('user_id', Auth::id())->latest()->paginate(15);
        return view('buyer.fault_reports.index', compact('reports'));
    }

    public function create(Device $device)
    {
        $this->authorize('view', $device);
        return view('buyer.fault_reports.create', compact('device'));
    }

    public function store(Request $request, Device $device)
    {
        $this->authorize('view', $device);
        $validated = $request->validate([
            'description' => 'required|string|max:2000',
            'image' => 'nullable|image|max:2048',
        ]);
        $imagePath = $request->file('image') ? $request->file('image')->store('fault_reports', 'public') : null;
        FaultReport::create([
            'device_id' => $device->id,
            'user_id' => Auth::id(),
            'description' => $validated['description'],
            'image_path' => $imagePath,
            'status' => 'open',
        ]);
        return redirect()->route('buyer.fault_reports.index')->with('success', 'Fault reported successfully.');
    }

    public function show(FaultReport $faultReport)
    {
        $this->authorize('view', $faultReport->device);
        abort_unless($faultReport->user_id === Auth::id(), 403);
        return view('buyer.fault_reports.show', compact('faultReport'));
    }
} 