<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\FaultReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FaultReportController extends Controller
{
    public function index()
    {
        $reports = FaultReport::whereHas('device', function ($q) {
            $q->where('vendor_id', Auth::id());
        })->with(['device', 'user'])->latest()->paginate(15);
        return view('vendor.fault_reports.index', compact('reports'));
    }

    public function show(FaultReport $faultReport)
    {
        abort_unless($faultReport->device->vendor_id === Auth::id(), 403);
        return view('vendor.fault_reports.show', compact('faultReport'));
    }

    public function resolve(FaultReport $faultReport)
    {
        abort_unless($faultReport->device->vendor_id === Auth::id(), 403);
        $faultReport->update(['status' => 'resolved']);
        return redirect()->route('vendor.fault_reports.show', $faultReport)->with('success', 'Fault marked as resolved.');
    }
} 