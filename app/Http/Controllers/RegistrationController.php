<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Models\Instructor;
use App\Models\Vehicle;
use App\Models\DrivingSchool;

class RegistrationController extends Controller
{
    public function drivingSchool()
    {
        return view('drivingSchool.register');
    }

    public function postStep1(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string|max:25',
            'user_id' => 'required|exists:users,id',
            'phone_number' => 'required|string|max:10',
            'image' => 'nullable|string|max:255',
            'location' => 'required|string|max:100',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'string|max:25',
            'certificate' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $user = auth()->user();
        $drivingSchool = new DrivingSchool();
        $drivingSchool->user_id = $user->id;
        $drivingSchool->registration_number = $request->input('registration_number');
        $drivingSchool->phone_number = $request->input('phone_number');
        $drivingSchool->location = $request->input('location');
        $drivingSchool->latitude = $request->input('latitude');
        $drivingSchool->longitude = $request->input('longitude');

        $certificatePath = $request->file('certificate')->store('uploads/documents');

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time().'.'.$extension;
            $imagePath = 'storage/';
            $file->move($imagePath, $fileName);
            $validated['image'] = $imagePath.$fileName;
        }

        $drivingSchool->certificate = $certificatePath;
            
        $drivingSchool->save();

        return redirect()->route('vehicle.register');
    }

    

    public function vehicle()
    { 
        $user = auth()->user();
        $drivingSchool = $user->drivingSchool;

        // If $drivingSchool is null, handle it appropriately
        $drivingSchoolId = $drivingSchool ? $drivingSchool->id : null;

        return view('vehicle.register', ['driving_school_id' => $drivingSchoolId]);
    }

    public function postStep2(Request $request)
    {
    $request->validate([
        'registration_number' => 'required|string|max:25',
        'code' => 'required|string|max:10',
        'vin_number' => 'required|string|max:25',
        'driving_school_id' => 'required|exists:driving_schools,id',
    ]);

    $user = auth()->user();
    $drivingSchool = $user->drivingSchool;

    $vehicle = new Vehicle();
    $vehicle->user_id = $user->id;
    $vehicle->driving_school_id = $request->input('driving_school_id');
    $vehicle->registration_number = $request->input('registration_number');
    $vehicle->code = $request->input('code');
    $vehicle->vin_number = $request->input('vin_number');
    $vehicle->save();

    return redirect()->route('instructor.register');

    }


    
    public function instructor()
    {
        $user = auth()->user();
        $drivingSchool = $user->drivingSchool;

        $drivingSchoolId = $drivingSchool ? $drivingSchool->id : null;

        return view('instructor.register', ['driving_school_id' => $drivingSchoolId]);
    }

    public function postStep3(Request $request)
    {
        $request->validate([
            'driving_school_id' => 'required|exists:driving_schools,id',
            'name' => 'required|string|max:60',
            'phone_number' => 'required|string|max:10',
        ]);

        $user = auth()->user();
        $instructor = new Instructor();
        $instructor->user_id = $user->id;
        $instructor->driving_school_id = $request->input('driving_school_id');
        $instructor->name = $request->input('name');
        $instructor->phone_number = $request->input('phone_number');

        $instructor->save();

        return redirect(route('drivingSchool.index'));
    }

}
