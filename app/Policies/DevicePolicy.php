<?php



namespace App\Policies;

use App\Models\Device;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any devices.
     */
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'vendor', 'buyer', 'manufacturer']);
    }

    /**
     * Determine whether the user can view the device.
     */
    public function view(User $user, Device $device)
    {
        // Admins and manufacturers can view all devices
        if (in_array($user->role, ['admin', 'manufacturer'])) {
            return true;
        }

        // Vendors can view devices they registered
        if ($user->role === 'vendor' && $device->vendor_id === $user->id) {
            return true;
        }

        // Buyers can view devices they own (by ID or by registered email)
        if ($user->role === 'buyer' && (
            $device->buyer_id === $user->id ||
            (strcasecmp($device->buyer_email, $user->email) === 0)
        )) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create devices.
     */
    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'vendor', 'manufacturer']);
    }

    /**
     * Determine whether the user can update the device.
     */
    public function update(User $user, Device $device)
    {
        // Admins can update any device
        if ($user->role === 'admin') {
            return true;
        }

        // Vendors can update devices they registered
        if ($user->role === 'vendor' && $device->vendor_id === $user->id) {
            return true;
        }

        // Manufacturers can update any device
        if ($user->role === 'manufacturer') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update device status.
     */
    public function updateStatus(User $user, Device $device)
    {
        // Admins and manufacturers can update any device status
        if (in_array($user->role, ['admin', 'manufacturer'])) {
            return true;
        }

        // Vendors can update status of devices they registered
        if ($user->role === 'vendor' && $device->vendor_id === $user->id) {
            return true;
        }

        // Buyers can flag their own devices as stolen
        if ($user->role === 'buyer' && $device->buyer_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can transfer the device.
     */
    public function transfer(User $user, Device $device)
    {
        // Admins can transfer any device
        if ($user->role === 'admin') {
            return true;
        }

        // Current owners can transfer their devices
        if ($device->buyer_id === $user->id) {
            return true;
        }

        // Vendors can transfer devices they registered (for initial sales)
        if ($user->role === 'vendor' && $device->vendor_id === $user->id && !$device->buyer_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the device.
     */
    public function delete(User $user, Device $device)
    {
        // Only admins can delete devices
        return $user->role === 'admin';
    }
}