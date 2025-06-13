<?php

namespace App\Observers;

use App\Models\Device;
use App\Models\DeviceTransfer;
use Illuminate\Support\Facades\Auth;

class DeviceObserver
{
    /**
     * Handle the Device "created" event.
     */
    public function created(Device $device): void
    {
        // Log the initial device registration as a transfer
        if ($device->buyer_id) {
            DeviceTransfer::create([
                'device_id' => $device->id,
                'from_user_id' => null, // Initial registration
                'to_user_id' => $device->buyer_id,
                'transfer_type' => 'sale',
                'amount' => $device->price,
                'notes' => 'Initial device registration',
                'transfer_date' => now(),
            ]);
        }
    }

    /**
     * Handle the Device "updated" event.
     */
    public function updated(Device $device): void
    {
        // Log buyer changes as transfers
        if ($device->isDirty('buyer_id') && $device->buyer_id) {
            $originalBuyerId = $device->getOriginal('buyer_id');
            
            DeviceTransfer::create([
                'device_id' => $device->id,
                'from_user_id' => $originalBuyerId,
                'to_user_id' => $device->buyer_id,
                'transfer_type' => 'transfer',
                'notes' => 'Device ownership transferred via system update',
                'transfer_date' => now(),
            ]);
        }
    }
}