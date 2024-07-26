<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\DrivingSchool;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function showProfile(Request $request)
    {
        $user = Auth::user();
        
        $drivingSchoolData = $user->role === 'admin' ? $user->drivingSchool : null;

        switch ($user->role) {
            case 'admin':
                return view('profile.admin', [
                    'user' => $user,
                    'drivingSchoolData' => $drivingSchoolData,
                ]);

            case 'user':
                return view('profile.learner', [
                    'user' => $user,
                ]);

            default:
                return view('profile.edit', [
                    'user' => $user,
                ]);
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    $user->fill($request->validated());

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    if ($user->isDirty() || $request->hasFile('image')) {
        $user->save(); // Save the user only if there are changes or a new image is uploaded
        
        if ($user->role === 'admin') {
            $drivingSchool = DrivingSchool::firstOrNew(['user_id' => $user->id]);
            $drivingSchool->fill([
                'registration_number' => $request->input('registration_number'),
                'phone_number' => $request->input('phone_number'),
                'location' => $request->input('location'),
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $imagePath = 'storage/';
                $file->storeAs('public/', $fileName);
                $drivingSchool->image = $imagePath . $fileName;
            }
            
            $drivingSchool->save(); 
        }
    }
    
    return redirect()->route('profile.show')->with('status', 'profile-updated');
}
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
