<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{
    /**
     * Determine whether the user can view the order.
     */
    public function view(User $user, Order $order)
    {
        return $user->isAdmin() || $user->id === $order->buyer_id || $user->id === $order->vendor_id;
    }

    /**
     * Determine whether the user can update the order (vendor or admin).
     */
    public function update(User $user, Order $order)
    {
        return $user->isAdmin() || $user->id === $order->vendor_id;
    }

    /**
     * Determine whether the user can cancel the order (buyer or admin).
     */
    public function cancel(User $user, Order $order)
    {
        return $user->isAdmin() || $user->id === $order->buyer_id;
    }
} 