<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Get the post-confirmation redirect path based on user role.
     */
    protected function redirectTo()
    {
        $user = auth()->user();
        switch ($user->role) {
            case 'admin':
                return route('admin.dashboard');
            case 'vendor':
                return route('vendor.dashboard');
            case 'buyer':
                return route('buyer.dashboard');
            case 'manufacturer':
                return route('manufacturer.dashboard');
            default:
                return '/';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
