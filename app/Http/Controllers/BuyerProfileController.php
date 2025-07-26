<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BuyerProfile;

class BuyerProfileController extends Controller
{
    /**
     * Display the buyer's profile.
     */
    public function show()
    {
        $user = Auth::user();
        $profile = $user->buyerProfile;
        // If profile is still not found, try to fetch from DB (in case of just created)
        if (!$profile) {
            $profile = \App\Models\BuyerProfile::where('user_id', $user->id)->first();
        }
        return view('buyer.profile.show', compact('profile', 'user'));
    }

    /**
     * Show the form for editing the buyer's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->buyerProfile;
        return view('buyer.profile.edit', compact('profile'));
    }

    /**
     * Update the buyer's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->buyerProfile;

        $rules = [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:32',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'id_type' => 'required|string|max:50',
            'id_number' => 'required|string|max:100',
            'buyer_type' => 'nullable|in:individual,institution',
            'institution_name' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:100',
        ];

        // If buyer_type is institution, require institution_name and tax_id
        if ($request->input('buyer_type') === 'institution') {
            $rules['institution_name'] = 'required|string|max:255';
            $rules['tax_id'] = 'required|string|max:100';
        }

        $validated = $request->validate($rules);

        if (!$profile) {
            $profile = new BuyerProfile(['user_id' => $user->id]);
        }
        $profile->fill($validated);
        $profile->user_id = $user->id;
        $profile->save();

        // Also update user's name and phone for consistency
        $user->name = $validated['full_name'];
        $user->phone = $validated['phone'];
        $user->save();

        // Reload profile from DB to ensure it's available for the show page
        $profile = BuyerProfile::where('user_id', $user->id)->first();

        return redirect()->route('buyer.profile.show')->with('success', 'Profile updated successfully.');
    }
} 