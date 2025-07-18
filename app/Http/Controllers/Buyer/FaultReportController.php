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
            'media.*' => 'nullable|file|max:20480|mimetypes:image/jpeg,image/png,video/mp4,video/quicktime', // 20MB per file
        ]);
        
        $faultReport = FaultReport::create([
            'device_id' => $device->id,
            'user_id' => Auth::id(),
            'description' => $validated['description'],
            'status' => 'open',
        ]);
        
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $mime = $file->getMimeType();
                $isImage = str_starts_with($mime, 'image/');
                $isVideo = str_starts_with($mime, 'video/');
                // For videos, check duration (requires ffprobe or similar for strict check, but skip for now)
                $mediaType = $isImage ? 'image' : ($isVideo ? 'video' : null);
                if (!$mediaType) continue;
                $path = $file->store('fault_reports', 'public');
                $faultReport->media()->create([
                    'media_type' => $mediaType,
                    'file_path' => $path,
                ]);
                // For backward compatibility, set image_path if first image
                if ($isImage && !$faultReport->image_path) {
                    $faultReport->image_path = $path;
                    $faultReport->save();
                }
            }
        }
        return redirect()->route('buyer.fault_reports.index')->with('success', 'Fault reported successfully.');
    }

    public function show(FaultReport $faultReport)
    {
        $this->authorize('view', $faultReport->device);
        abort_unless($faultReport->user_id === Auth::id(), 403);
        return view('buyer.fault_reports.show', compact('faultReport'));
    }
} 