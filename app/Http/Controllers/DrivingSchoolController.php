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
            $drivingSchool = $drivingSchool ? $drivingSchool->load(['instructors', 'vehicles']) : null;
            $drivingSchoolId = $drivingSchool ? $drivingSchool->id : null;
    
            // Return the driving school dashboard view for the admin
            return view('drivingSchool.dashboard', [
                'driving_school' => $drivingSchool,
                'driving_school_id' => $drivingSchoolId,
            ]);
        }
    
        // Normal user - Filter by location if provided
        $query = DrivingSchool::query();
    
        if ($request->has('location') && !empty($request->input('location'))) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }
    
        // Fetch filtered driving schools
        $driving_schools = $query->get();
    
        return view('dashboard', compact('driving_schools'));
    }
    public function search(Request $request): View
{
    $query = DrivingSchool::query();

    if ($request->has('location') && !empty($request->input('location'))) {
        $query->where('location', 'like', '%' . $request->input('location') . '%');
    }

    $driving_schools = $query->get();

    return view('dashboard', compact('driving_schools'));
}

public function getSuggestions(Request $request)
{
    $location = $request->input('location');
    
    // Fetch matching driving schools
    $suggestions = DrivingSchool::where('location', 'like', $location . '%')
        ->select('location')
        ->distinct()
        ->get();

    return response()->json($suggestions);
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
        $validated = $request->validate([
            'registration_number' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'phone_number' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // Adjusted to handle file uploads correctly
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'nullable|string|max:255',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $imagePath = 'storage/images/';
            $file->move(public_path($imagePath), $fileName);
            $validated['image'] = $imagePath . $fileName;
        }

        // Create a new driving school record in the database
        DrivingSchool::create($validated);

        // Redirect to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Driving School Successfully Created.');
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