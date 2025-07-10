<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
    /**
     * Determine whether the user can view any products.
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isVendor() || $user->isBuyer();
    }

    /**
     * Determine whether the user can view the product.
     */
    public function view(User $user, Product $product)
    {
        return $user->isAdmin() || $user->isBuyer() || $user->id === $product->vendor_id;
    }

    /**
     * Determine whether the user can create products.
     */
    public function create(User $user)
    {
        return $user->isVendor() || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the product.
     */
    public function update(User $user, Product $product)
    {
        return $user->isAdmin() || ($user->isVendor() && $user->id === $product->vendor_id);
    }

    /**
     * Determine whether the user can delete the product.
     */
    public function delete(User $user, Product $product)
    {
        return $user->isAdmin() || ($user->isVendor() && $user->id === $product->vendor_id);
    }
} 