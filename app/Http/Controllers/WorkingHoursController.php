<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Hour;


class WorkingHoursController extends Controller
{

    public function schedule()
    {
        $user = auth()->user();
        $drivingSchool = $user->drivingSchool;
        $drivingSchoolId = $drivingSchool ? $drivingSchool->id : null;

        // Check if the user has a driving school and load working hours
        if ($drivingSchool) {
            $drivingSchool->load('workingHours');
        }

        return view('drivingSchool.schedule', [
            'driving_school' => $drivingSchool,
            'driving_school_id' => $drivingSchoolId,
        ]);
    }


    // Store new working hours in the database
    public function store(Request $request)
    {
        $user = auth()->user();
        $drivingSchool = $user->drivingSchool;

         if ($drivingSchool->workingHours()->count() >= 7) {
            return redirect()->route('drivingSchool.index')->with('status', 'You cannot add more than 7 days of working hours.');
        }

        $request->validate([
            'hours.*.day_of_week' => [
                'required',
                'string',
                Rule::unique('hours')->where(function ($query) use ($drivingSchool) {
                    return $query->where('driving_school_id', $drivingSchool->id);
                })
            ],
            'hours.*.opening_time' => 'nullable|date_format:H:i',
            'hours.*.closing_time' => 'nullable|date_format:H:i',
        ]);

        $driving_school_id = $request->input('driving_school_id');

         foreach ($request->working_hours as $hours) {
            Hour::create([
                'user_id' => $user->id,
                'driving_school_id' => $drivingSchool->id,
                'day_of_week' => $hours['day_of_week'],
                'opening_time' => $hours['opening_time'],
                'closing_time' => $hours['closing_time'],
            ]);
        }

        return redirect()->route('drivingSchool.index')->with('status', 'Working hours saved successfully!');
    }


    public function update(Request $request, $id)
{
    
    try {
        
        $validatedData = $request->validate([
            'workingHours.*.opening_time' => 'required|date_format:H:i',
            'workingHours.*.closing_time' => 'required|date_format:H:i|after:workingHours.*.opening_time',
        ]);

        // Let's find the specific working hour by ID and confirm it's successful
        $workingHour = Hour::findOrFail($id);

        // Get the first matching working hour input from the request
        $input = $request->input('workingHours.' . $id);

        // Update the opening and closing times
        $workingHour->opening_time = $input['opening_time'];
        $workingHour->closing_time = $input['closing_time'];

        // Save the updated working hour
        $workingHour->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Working hours updated successfully!');

    } catch (\Exception $e) {
        // Log any other general exceptions
        Log::error('An error occurred during update:', ['error' => $e->getMessage()]);
        return redirect()->back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
    }
}

        
}
