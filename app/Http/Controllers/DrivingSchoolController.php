<?php

namespace App\Http\Controllers;

use App\Models\DrivingSchool;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DrivingSchoolController extends Controller
{
    // Display the list of driving schools with optional location filtering
    public function index(Request $request): View
    {
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

}

   

   
  
