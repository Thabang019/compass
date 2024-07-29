<?php

namespace App\Http\Controllers;

use App\Models\DrivingSchool;
use App\Models\Instructor;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DrivingSchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = auth()->user();
        $drivingSchool = $user->drivingSchool;

        $drivingSchoolId = $drivingSchool ? $drivingSchool->id : null;

        return view('drivingSchool.dashboard', ['driving_school_id' => $drivingSchoolId]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|integer|between:8,14',
            'address' => 'required|string',
        ]);

        // Assuming you have a function to get coordinates from address
        $coordinates = $this->getCoordinatesFromAddress($validated['address']);

        $schools = DrivingSchool::whereHas('vehicles', function ($query) use ($validated) {
            $query->where('code', $validated['code']);
        })->get();

        return view('search', compact('schools', 'coordinates'));
    }

    private function getCoordinatesFromAddress($address)
    {
        // Use a geocoding service to get coordinates from the address
        // For example, use Google Maps API
        // This is a placeholder function
        return [
            'latitude' => 37.7749,
            'longitude' => -122.4194,
        ];
    }
    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            'registration_number' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'phone_number' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'nullable|string|max:255',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(DrivingSchool $drivingSchool) : View
    {
        return view('drivingSchool.show', compact('drivingSchool'));
    }


    public function updateStatus(Request $request, DrivingSchool $drivingSchool)
    {
        $drivingSchool->status = $request->input('status');
        $drivingSchool->save();

        return redirect()->route('drivingSchools.show', $drivingSchool)->with('status', 'Driving school status updated!');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DrivingSchool $drivingSchool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DrivingSchool $drivingSchool)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DrivingSchool $drivingSchool)
    {
        //
    }


    public function store_instructor(Request $request) : RedirectResponse
    {
        $user = auth()->user();
        $drivingSchool = $user->drivingSchool;

        $request->validate([
            'driving_school_id' => 'required|exists:driving_schools,id',
            'name' => 'required|string|max:60',
            'phone_number' => 'required|string|max:10',
        ]);

        $instructor = new Instructor();
        $instructor->user_id = $user->id;
        $instructor->driving_school_id = $request->input('driving_school_id');
        $instructor->name = $request->input('name');
        $instructor->phone_number = $request->input('phone_number');

        $instructor->save();

        return redirect(route('drivingSchool.index'));
    }
    


    public function store_vehicle(Request $request) : RedirectResponse
    {
    $user = auth()->user();
    $drivingSchool = $user->drivingSchool;

    $request->validate([
        'registration_number' => 'required|string|max:25',
        'code' => 'required|string|max:10',
        'vin_number' => 'required|string|max:25',
        'driving_school_id' => 'required|exists:driving_schools,id',
    ]);

    $vehicle = new Vehicle();
    $vehicle->user_id = $user->id;
    $vehicle->driving_school_id = $request->input('driving_school_id');
    $vehicle->registration_number = $request->input('registration_number');
    $vehicle->code = $request->input('code');
    $vehicle->vin_number = $request->input('vin_number');
    $vehicle->save();

    return redirect()->route('drivingSchool.index');

    }

}
