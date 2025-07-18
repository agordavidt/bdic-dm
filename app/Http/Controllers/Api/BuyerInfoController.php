<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BuyerInfoController extends Controller
{
    public function show(Request $request)
    {
        $email = $request->query('email');
        if (!$email) {
            return response()->json(['error' => 'Email is required.'], 400);
        }
        $user = User::where('email', $email)->where('role', 'buyer')->first();
        if (!$user || !$user->buyerProfile) {
            return response()->json(['error' => 'Buyer not found.'], 404);
        }
        return response()->json([
            'full_name' => $user->buyerProfile->full_name,
            'phone' => $user->buyerProfile->phone,
            'address' => $user->buyerProfile->address,
            'city' => $user->buyerProfile->city,
            'state' => $user->buyerProfile->state,
            'country' => $user->buyerProfile->country,
            'id_type' => $user->buyerProfile->id_type,
            'id_number' => $user->buyerProfile->id_number,
            'buyer_category' => $user->buyerProfile->buyer_type,
            'institution_name' => $user->buyerProfile->institution_name,
            'tax_id' => $user->buyerProfile->tax_id,
        ]);
    }
} 