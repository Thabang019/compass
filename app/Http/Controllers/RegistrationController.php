<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Models\Instructor;
use App\Models\Vehicle;
use App\Models\DrivingSchool;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function drivingSchool()
    {
        return view('drivingSchool.register');
    }

    public function postStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'registration_number' => 'required|string|max:25|unique:driving_schools,registration_number',
            'user_id' => 'required|exists:users,id',
            'phone_number' => 'required|string|max:10',
            'school_name' => 'required|string|max:100',
            'image' => 'nullable|image',
            'location' => 'required|string|max:100',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'string|max:25',
            'certificate' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validation failed. Please check your input.');
        }

        $user = auth()->user();
        $drivingSchool = new DrivingSchool();
        $drivingSchool->user_id = $user->id;
        $drivingSchool->registration_number = $request->input('registration_number');
        $drivingSchool->school_name = $request->input('school_name');
        $drivingSchool->phone_number = $request->input('phone_number');
        $drivingSchool->location = $request->input('location');
        $drivingSchool->latitude = $request->input('latitude');
        $drivingSchool->longitude = $request->input('longitude');

        if ($request->hasFile('certificate')) {
            $certificateFile = $request->file('certificate');
            $certificateFileName = time() . '_certificate.' . $certificateFile->getClientOriginalExtension();
            $certificateFilePath = $certificateFile->storePubliclyAs('public', $certificateFileName);
            $drivingSchool->certificate = Storage::url($certificateFilePath);
        }

        if ($request->hasFile('image')) {

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $imagePath = 'storage/';
                $file->storeAs('public/', $fileName);
                $drivingSchool->image = $imagePath . $fileName;
            }
        }
                    
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
        $validator = Validator::make($request->all(), [
        'registration_number' => 'required|string|max:25',
        'code' => 'required|string|max:10',
        'vin_number' => 'required|string|max:25|unique:vehicles,vin_number',
        'driving_school_id' => 'required|exists:driving_schools,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'Validation failed. Please check your input.');
    }

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
        $validator = Validator::make($request->all(), [
            'driving_school_id' => 'required|exists:driving_schools,id',
            'name' => 'required|string|max:60',
            'phone_number' => 'required|string|max:10|unique:instructors,phone_number',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validation failed. Please check your input.');
        }

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
