<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Get the post-verification redirect path based on user role.
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
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
