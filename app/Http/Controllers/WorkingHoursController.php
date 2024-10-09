<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hour;

class WorkingHoursController extends Controller
{
    // Store new working hours in the database
    public function store(Request $request)
    {
        $user = auth()->user();
        $drivingSchool = $user->drivingSchool;

        $request->validate([
        'working_hours.*.day_of_week' => 'required|string',
        'working_hours.*.opening_time' => 'nullable|date_format:H:i',
        'working_hours.*.closing_time' => 'nullable|date_format:H:i',
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

    // Show the form for editing existing working hours
    public function edit($companyId)
    {
        $workingHours = Hour::where('driving_school_id', $companyId)->get();
        return view('working_hours.edit', compact('workingHours', 'companyId'));
    }

    // Update working hours in the database
    public function update(Request $request, $companyId)
    {
        $request->validate([
            'working_hours.*.day_of_week' => 'required|string',
            'working_hours.*.opening_time' => 'nullable|date_format:H:i',
            'working_hours.*.closing_time' => 'nullable|date_format:H:i',
        ]);

        foreach ($request->working_hours as $hours) {
            Hour::updateOrCreate(
                [
                    'company_id' => $companyId,
                    'day_of_week' => $hours['day_of_week'],
                ],
                [
                    'opening_time' => $hours['opening_time'],
                    'closing_time' => $hours['closing_time']
                ]
            );
        }

        return redirect()->route('working_hours.index', $companyId)->with('success', 'Working hours updated successfully!');
    }
}
