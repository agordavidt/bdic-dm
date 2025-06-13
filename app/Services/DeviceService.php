<?php


namespace App\Services;

use App\Models\Device;
use App\Models\User;
use App\Models\BuyerProfile;
use App\Models\DeviceTransfer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DeviceService
{
    /**
     * Register a new device with buyer information
     */
    public function registerDevice(array $deviceData, array $buyerData = null): Device
    {
        return DB::transaction(function () use ($deviceData, $buyerData) {
            // Create the device
            $device = Device::create($deviceData);

            // Create buyer profile if buyer data is provided
            if ($buyerData) {
                $buyer = $this->createOrFindBuyer($buyerData);
                $buyerProfile = $this->createBuyerProfile($buyer, $buyerData);
                
                // Link device to buyer
                $device->update(['buyer_id' => $buyer->id]);
                
                // Create initial transfer record
                DeviceTransfer::create([
                    'device_id' => $device->id,
                    'from_user_id' => null,
                    'to_user_id' => $buyer->id,
                    'transfer_type' => 'sale',
                    'amount' => $deviceData['price'] ?? null,
                    'notes' => 'Initial device registration and sale',
                    'transfer_date' => now(),
                ]);
            }

            return $device->load(['category', 'vendor', 'buyer', 'buyerProfile']);
        });
    }

    /**
     * Transfer device ownership
     */
    public function transferDevice(Device $device, User $newOwner, array $transferData): Device
    {
        return DB::transaction(function () use ($device, $newOwner, $transferData) {
            // Create transfer record
            DeviceTransfer::create([
                'device_id' => $device->id,
                'from_user_id' => $device->buyer_id,
                'to_user_id' => $newOwner->id,
                'transfer_type' => $transferData['transfer_type'],
                'amount' => $transferData['amount'] ?? null,
                'notes' => $transferData['notes'] ?? null,
                'transfer_date' => now(),
            ]);

            // Update device ownership
            $device->update(['buyer_id' => $newOwner->id]);

            return $device;
        });
    }

    /**
     * Get device analytics for a vendor
     */
    public function getVendorAnalytics(User $vendor): array
    {
        $devices = Device::byVendor($vendor->id);
        
        return [
            'total_devices' => $devices->count(),
            'active_devices' => $devices->byStatus('active')->count(),
            'devices_needing_attention' => $devices->byStatus('needs_attention')->count(),
            'stolen_devices' => $devices->byStatus('stolen')->count(),
            'total_sales' => DeviceTransfer::whereIn('device_id', $devices->pluck('id'))
                ->where('transfer_type', 'sale')
                ->sum('amount'),
            'devices_by_category' => $devices->with('category')
                ->get()
                ->groupBy('category.name')
                ->map->count(),
            'buyer_categories' => $devices->whereNotNull('buyer_category')
                ->get()
                ->groupBy('buyer_category')
                ->map->count(),
        ];
    }

    /**
     * Create or find buyer user
     */
    private function createOrFindBuyer(array $buyerData): User
    {
        return User::firstOrCreate(
            ['email' => $buyerData['buyer_email']],
            [
                'name' => $buyerData['buyer_full_name'],
                'role' => 'buyer',
                'password' => Hash::make('TempPass123!'), // Should be changed on first login
                'phone' => $buyerData['buyer_phone'],
                'status' => 'active',
            ]
        );
    }

    /**
     * Create buyer profile
     */
    private function createBuyerProfile(User $user, array $buyerData): BuyerProfile
    {
        return BuyerProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => $buyerData['buyer_full_name'],
                'phone' => $buyerData['buyer_phone'],
                'address' => $buyerData['buyer_address'],
                'city' => $buyerData['buyer_city'],
                'state' => $buyerData['buyer_state'],
                'country' => $buyerData['buyer_country'] ?? 'Nigeria',
                'id_type' => $buyerData['buyer_id_type'] ?? null,
                'id_number' => $buyerData['buyer_id_number'] ?? null,
                'buyer_type' => $buyerData['buyer_category'],
                'institution_name' => $buyerData['institution_name'] ?? null,
                'tax_id' => $buyerData['tax_id'] ?? null,
            ]
        );
    }
}