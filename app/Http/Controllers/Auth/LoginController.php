<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Get the post-login redirect path based on user role.
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
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
