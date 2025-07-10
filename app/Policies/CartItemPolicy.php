<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CartItem;

class CartItemPolicy
{
    /**
     * Determine whether the user can update the cart item.
     */
    public function update(User $user, CartItem $cartItem)
    {
        return $user->id === $cartItem->user_id;
    }

    /**
     * Determine whether the user can delete the cart item.
     */
    public function delete(User $user, CartItem $cartItem)
    {
        return $user->id === $cartItem->user_id;
    }
} 