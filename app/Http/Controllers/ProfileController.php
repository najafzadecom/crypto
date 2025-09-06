<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Country;
use App\Models\Region;
use App\Models\User;
use App\Notifications\ProfileUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        $countries = Country::where('status', 1)->get();
        
        // Get regions for the selected countries if any
        $birthRegions = collect();
        $residenceRegions = collect();
        
        if ($user->birth_country_id) {
            $birthRegions = Region::where('country_id', $user->birth_country_id)
                ->where('status', 1)
                ->get();
        }
        
        if ($user->residence_country_id) {
            $residenceRegions = Region::where('country_id', $user->residence_country_id)
                ->where('status', 1)
                ->get();
        }
        
        return view('profile.edit', compact('user', 'countries', 'birthRegions', 'residenceRegions'));
    }
    
    /**
     * Update the user's profile.
     */
    public function update(ProfileUpdateRequest $request)
    {
        // Check if profile is blocked
        if ($request->isProfileBlocked()) {
            return back()->with('error', $request->getBlockedMessage());
        }
        
        $user = Auth::user();
        $oldData = $user->only([
            'birth_date',
            'birth_place',
            'birth_country_id',
            'birth_region_id',
            'residence_country_id',
            'residence_region_id',
            'residence_address',
            'education',
            'job',
            'position',
            'telegram',
            'twitter',
            'wallet_address',
            'bio',
        ]);
        
        // Update user data
        $user->fill($request->validated());
        
        // Check if wallet address is being changed
        if ($user->isDirty('wallet_address') && $user->getOriginal('wallet_address')) {
            return back()->with('error', 'Blockchain cüzdan ünvanını dəyişmək üçün dəstək xidməti ilə əlaqə saxlayın.');
        }
        
        // Track what fields are updated
        $updatedFields = [];
        foreach ($oldData as $field => $oldValue) {
            $newValue = $user->$field;
            
            if ($oldValue != $newValue) {
                // For country and region IDs, get the actual names
                if ($field === 'birth_country_id' && $newValue) {
                    $country = Country::find($newValue);
                    $updatedFields[$field] = $country ? $country->name : $newValue;
                } elseif ($field === 'birth_region_id' && $newValue) {
                    $region = Region::find($newValue);
                    $updatedFields[$field] = $region ? $region->name : $newValue;
                } elseif ($field === 'residence_country_id' && $newValue) {
                    $country = Country::find($newValue);
                    $updatedFields[$field] = $country ? $country->name : $newValue;
                } elseif ($field === 'residence_region_id' && $newValue) {
                    $region = Region::find($newValue);
                    $updatedFields[$field] = $region ? $region->name : $newValue;
                } else {
                    $updatedFields[$field] = $newValue;
                }
            }
        }
        
        // Save changes
        $user->last_profile_update = now();
        $user->save();
        
        // Block profile updates for 48 hours
        $user->blockProfile(48);
        
        // Send notification if fields were updated
        if (!empty($updatedFields)) {
            $user->notify(new ProfileUpdatedNotification($updatedFields));
        }
        
        return back()->with('success', 'Profil məlumatlarınız uğurla yeniləndi. Növbəti yeniləmə 48 saatdan sonra mümkün olacaq.');
    }
    
    /**
     * Get regions for a country via AJAX.
     */
    public function getRegions(Request $request)
    {
        $countryId = $request->input('country_id');
        $regions = Region::where('country_id', $countryId)
            ->where('status', 1)
            ->get(['id', 'name']);
            
        return response()->json($regions);
    }
}
