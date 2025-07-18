<?php



namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceCategory;
use App\Models\BuyerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Mail\DeviceRegisteredMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of devices
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Device::with(['category', 'vendor', 'buyer', 'buyerProfile']);

        // Filter based on user role
        if ($user->isVendor()) {
            $query->byVendor($user->id);
        } elseif ($user->isBuyer()) {
            $query->byBuyer($user->id);
        }

        // Apply filters
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('buyer_category')) {
            $query->byBuyerCategory($request->buyer_category);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('unique_identifier', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        $devices = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = DeviceCategory::all();

        return view('devices.index', compact('devices', 'categories'));
    }

    /**
     * Show the form for creating a new device
     */
    public function create()
    {
        $this->authorize('create', Device::class);
        
        $categories = DeviceCategory::all();
        return view('devices.create', compact('categories'));
    }

    /**
     * Store a newly created device
     */
    public function store(Request $request)
    {
        $this->authorize('create', Device::class);

        $validated = $request->validate([
            'unique_identifier' => 'required|string|unique:devices,unique_identifier',
            'device_type' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'specifications' => 'nullable|string',
            'category_id' => 'required|exists:device_categories,id',
            'price' => 'nullable|numeric|min:0',
            'warranty_expiry' => 'nullable|date|after:today',
            // Buyer information
            'buyer_email' => 'required|email',
            'buyer_name' => 'required|string|max:255',
            'buyer_phone' => 'required|string|max:20',
            'buyer_address' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $device = Device::create([
                'unique_identifier' => $validated['unique_identifier'],
                'device_type' => $validated['device_type'],
                'model' => $validated['model'],
                'brand' => $validated['brand'],
                'specifications' => $validated['specifications'],
                'category_id' => $validated['category_id'],
                'vendor_id' => Auth::id(),
                'price' => $validated['price'],
                'warranty_expiry' => $validated['warranty_expiry'],
                'buyer_name' => $validated['buyer_name'],
                'buyer_email' => $validated['buyer_email'],
                'buyer_phone' => $validated['buyer_phone'],
                'buyer_address' => $validated['buyer_address'],
                'purchase_date' => now(),
            ]);

            // TODO: Send email notification to buyer_email about device registration
            try {
                Mail::to($device->buyer_email)->send(new DeviceRegisteredMail($device, $device->buyer_name));
            } catch (\Exception $e) {
                Log::error('Failed to send device registration email: ' . $e->getMessage());
            }

            DB::commit();
            return redirect()->route('devices.index')
                ->with('success', 'Device registered successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to register device: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified device
     */
    public function show(Device $device)
    {
        $this->authorize('view', $device);
        
        $device->load(['category', 'vendor', 'buyer', 'buyerProfile', 'transfers.fromUser', 'transfers.toUser']);
        
        return view('devices.show', compact('device'));
    }

    /**
     * Show the form for editing the device
     */
    public function edit(Device $device)
    {
        $this->authorize('update', $device);
        
        $categories = DeviceCategory::all();
        $device->load('buyerProfile');
        
        return view('devices.edit', compact('device', 'categories'));
    }

    /**
     * Update the specified device
     */
    public function update(Request $request, Device $device)
    {
        $this->authorize('update', $device);

        $validated = $request->validate([
            'device_type' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'specifications' => 'nullable|string',
            'category_id' => 'required|exists:device_categories,id',
            'price' => 'nullable|numeric|min:0',
            'warranty_expiry' => 'nullable|date',
            'status' => ['required', Rule::in(['active', 'needs_attention', 'replacement_needed', 'stolen'])],
        ]);

        $device->update($validated);

        return redirect()->route('devices.show', $device)
            ->with('success', 'Device updated successfully!');
    }

    /**
     * Update device status
     */
    public function updateStatus(Request $request, Device $device)
    {
        $this->authorize('updateStatus', $device);

        $validated = $request->validate([
            'status' => ['required', Rule::in(['active', 'needs_attention', 'replacement_needed', 'stolen'])],
            'notes' => 'nullable|string',
        ]);

        $device->update(['status' => $validated['status']]);

        return back()->with('success', 'Device status updated successfully!');
    }

    /**
     * Transfer device to new owner
     */
    public function transfer(Request $request, Device $device)
    {
        $this->authorize('transfer', $device);

        $validated = $request->validate([
            'buyer_email' => 'required|email|exists:users,email',
            'transfer_type' => 'required|in:sale,transfer,return',
            'amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $newBuyer = User::where('email', $validated['buyer_email'])->first();

        DB::beginTransaction();
        try {
            // Create transfer record
            $device->transfers()->create([
                'from_user_id' => $device->buyer_id,
                'to_user_id' => $newBuyer->id,
                'transfer_type' => $validated['transfer_type'],
                'amount' => $validated['amount'],
                'notes' => $validated['notes'],
                'transfer_date' => now(),
            ]);

            // Update device owner
            $device->update(['buyer_id' => $newBuyer->id]);

            DB::commit();
            return redirect()->route('devices.show', $device)
                ->with('success', 'Device transferred successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Transfer failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Create or update buyer profile
     */
    private function createOrUpdateBuyerProfile(array $data)
    {
        // Require buyer_email
        if (empty($data['buyer_email'])) {
            throw new \InvalidArgumentException('Buyer email is required.');
        }
        $user = User::firstOrCreate(
            ['email' => $data['buyer_email']],
            [
                'name' => $data['buyer_full_name'],
                'role' => 'buyer',
                'password' => bcrypt('temporary123'), // Should be changed on first login
            ]
        );
        return BuyerProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => $data['buyer_full_name'],
                'phone' => $data['buyer_phone'],
                'address' => $data['buyer_address'],
                'city' => $data['buyer_city'],
                'state' => $data['buyer_state'],
                'country' => $data['buyer_country'] ?? 'Nigeria',
                'id_type' => $data['buyer_id_type'],
                'id_number' => $data['buyer_id_number'],
                'buyer_type' => $data['buyer_category'] ?? 'individual',
                'institution_name' => $data['institution_name'],
                'tax_id' => $data['tax_id'],
            ]
        );
    }
}

