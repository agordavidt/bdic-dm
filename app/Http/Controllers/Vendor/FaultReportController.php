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

    public function destroyMedia($faultReportId, $mediaId)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403);
        }
        $media = \App\Models\FaultReportMedia::where('fault_report_id', $faultReportId)->findOrFail($mediaId);
        // Delete file from storage
        if (\Storage::disk('public')->exists($media->file_path)) {
            \Storage::disk('public')->delete($media->file_path);
        }
        $media->delete();
        return back()->with('success', 'Media file deleted successfully.');
    }
} 