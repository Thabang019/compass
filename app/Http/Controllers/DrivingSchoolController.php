<?php

namespace App\Http\Controllers;

use App\Models\DrivingSchool;
use App\Models\Instructor;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class DrivingSchoolController extends Controller
{
    // Display the list of driving schools with optional location filtering
    public function index(Request $request): View
    {
        $user = auth()->user();

        // Check if the user is an admin
        if ($user->role === 'admin') {
            // Get the driving school associated with the admin
            $drivingSchool = $user->drivingSchool;

            // Load the related instructors and vehicles
            $drivingSchool = $drivingSchool ? $drivingSchool->load(['instructors', 'vehicles']) : null;

            // Get the driving school ID
            $drivingSchoolId = $drivingSchool ? $drivingSchool->id : null;

            // Return the driving school dashboard view for the admin
            return view('drivingSchool.dashboard', [
                'driving_school' => $drivingSchool,
                'driving_school_id' => $drivingSchoolId,
            ]);
        }

        // If not admin, proceed with filtering by location
        $query = DrivingSchool::query();

        // Filter by location if provided
        if ($request->has('location') && $request->input('location') !== null) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }

        // Fetch all matching driving schools
        $driving_schools = $query->get();

        // Pass the results to the view
        return view('dashboard', compact('driving_schools'));
    }




    // Search for driving schools by address and vehicle code
    public function search(Request $request): View
    {
        // Validate input for search criteria
        $validated = $request->validate([
            'code' => 'required|integer|between:8,14',
            'address' => 'required|string',
        ]);

        // Fetch driving schools that match the search criteria
        $driving_schools = DrivingSchool::whereHas('vehicles', function ($query) use ($validated) {
            $query->where('code', $validated['code']);
        })
        ->where('location', 'like', '%' . $validated['address'] . '%')
        ->get();

        // Check if any schools were found, and set a message if none were found
        $message = $driving_schools->isEmpty() ? "There are no registered driving schools in this area." : null;

        // Return the search results and any messages to the view
        return view('search', compact('driving_schools', 'message'));
    }

    // Show the form for creating a new driving school
    public function create(): View
    {
        return view('drivingSchool.create');
    }

    // Store a newly created driving school in the database
    public function store(Request $request): RedirectResponse
    {
        // Validate the input data
        
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
    
   


    public function store_instructor(Request $request) : RedirectResponse
    {
        $user = auth()->user();
        $drivingSchool = $user->drivingSchool;

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

        $instructor = new Instructor();
        $instructor->user_id = $user->id;
        $instructor->driving_school_id = $request->input('driving_school_id');
        $instructor->name = $request->input('name');
        $instructor->phone_number = $request->input('phone_number');

        $instructor->save();

        return redirect()->route('drivingSchool.index')->with('status', 'Instructor Added!');
    }
    
    public function store_vehicle(Request $request) : RedirectResponse
    {
    $user = auth()->user();
    $drivingSchool = $user->drivingSchool;

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

    $vehicle = new Vehicle();
    $vehicle->user_id = $user->id;
    $vehicle->driving_school_id = $request->input('driving_school_id');
    $vehicle->registration_number = $request->input('registration_number');
    $vehicle->code = $request->input('code');
    $vehicle->vin_number = $request->input('vin_number');
    $vehicle->save();

    return redirect()->route('drivingSchool.index')->with('status', 'Vehicle Added!');

    }
}