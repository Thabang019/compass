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
            $filePath = 'public/'.$fileName;
            $file->storeAs('public', $fileName);
            $drivingSchool->image = $filePath;
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
