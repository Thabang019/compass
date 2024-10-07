<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\DrivingSchool;
use App\Models\User;
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
     * Update the profile information by root user
     */
    public function displayDrivingSchoolProfile(Request $request, $id)
    {   
    $user = Auth::user();

    $drivingSchoolData = DrivingSchool::where('id', $id)->firstOrFail();

    switch ($user->role) {
        case 'root':
            return view('profile.admin', [
                'drivingSchoolData' => $drivingSchoolData,
                'userEmail' => $drivingSchoolData->user->email,
                'userID' => $drivingSchoolData->user->id,
            ]);
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
    $request->user()->fill($request->validated());

    if ($request->user()->isDirty('email')) {
        $request->user()->email_verified_at = null;
    }

    $user = $request->user();

    if ($user->role === 'admin') {
        $drivingSchool = DrivingSchool::updateOrCreate(
            ['user_id' => $user->id],
            [
                'registration_number' => $request->input('registration_number'),
                'phone_number' => $request->input('phone_number'),
                'location' => $request->input('location'),
            ]
        );

        if ($request->hasFile('image')) {
            if ($drivingSchool->image) {
                Storage::delete($drivingSchool->image);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time().'.'.$extension;
            $imagePath = 'storage/';
            $file->storeAs('public/', $fileName);
            $drivingSchool->image = $imagePath . $fileName;
            $drivingSchool->save();
        }
    }

    $request->user()->save();

    return Redirect::route('profile.show')->with('status', 'profile-updated');
    }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
{
    $user = $request->user();

    if ($user->role === 'root' && $request->has('user_id')) {
        $targetUser = User::findOrFail($request->input('user_id'));

        $targetUser->delete();
        return redirect(route('systemAdmin.dashboard'))->with('success', 'User account deleted successfully.');
    }

    // Regular user deleting their own account
    if ($user->role !== 'root') {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    return Redirect::back()->with('error', 'You cannot delete your own account.');
}

}
