<?php

namespace App\Http\Controllers;

use App\Models\DeviceCategory;
use Illuminate\Http\Request;

class DeviceCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,manufacturer');
    }

    public function index()
    {
        $categories = DeviceCategory::withCount('devices')->get();
        return view('device-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('device-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:device_categories,name',
            'description' => 'nullable|string',
        ]);

        DeviceCategory::create($validated);

        return redirect()->route('device-categories.index')
            ->with('success', 'Device category created successfully!');
    }

    public function edit(DeviceCategory $deviceCategory)
    {
        return view('device-categories.edit', compact('deviceCategory'));
    }

    public function update(Request $request, DeviceCategory $deviceCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:device_categories,name,' . $deviceCategory->id,
            'description' => 'nullable|string',
        ]);

        $deviceCategory->update($validated);

        return redirect()->route('device-categories.index')
            ->with('success', 'Device category updated successfully!');
    }

    public function destroy(DeviceCategory $deviceCategory)
    {
        if ($deviceCategory->devices()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete category with associated devices.']);
        }

        $deviceCategory->delete();

        return redirect()->route('device-categories.index')
            ->with('success', 'Device category deleted successfully!');
    }
}