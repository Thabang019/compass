<?php

namespace App\Http\Controllers;

use App\Models\DrivingSchool;
use App\Models\Instructor;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DrivingSchoolController extends Controller
{
    // Display the list of driving schools with optional location filtering
    public function index(Request $request): View
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            
            $drivingSchool = $user->drivingSchool;
            $drivingSchool = $drivingSchool ? $drivingSchool->load(['instructors', 'vehicles']) : null;
            $drivingSchoolId = $drivingSchool ? $drivingSchool->id : null;

            $drivingSchoolName = $drivingSchool->school_name;

            $bookings = Booking::where('driving_school_name', $drivingSchoolName)->get();
            
            $futureLessons = [];

            foreach ($bookings as $booking) {
                $lessons = $booking->lessons()->where('date', '>', Carbon::today())->get();
                $user = $booking->user;
                if ($lessons->isNotEmpty()) {
                    $futureLessons[] = [
                        'booking' => $booking,
                        'lessons' => $lessons,
                        'user' => $user,
                    ];
                }
            }

            // Return the driving school dashboard view for the admin
            return view('drivingSchool.dashboard', [
                'driving_school' => $drivingSchool,
                'driving_school_id' => $drivingSchoolId,
                'futureLessons' => $futureLessons,
            ]);
        }
    
        // Normal user - Filter by location if provided
        $query = DrivingSchool::query();
    
        if ($request->has('location') && !empty($request->input('location'))) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }
    
        // Fetch filtered driving schools
         $driving_schools = DrivingSchool::where('status', 'approved')->get();
    
        return view('dashboard', compact('driving_schools'));
    }

    public function search(Request $request): View
    {
        $query = DrivingSchool::query();

        if ($request->has('location') && !empty($request->input('location'))) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }

        $driving_schools = DrivingSchool::where('status', 'approved')->get();

        return view('dashboard', compact('driving_schools'));
    }

    public function getSuggestions(Request $request)
    {
        $query = $request->input('query');
        $suggestions = DrivingSchool::where('location', 'LIKE', "{$query}%")
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

    public function updateLessonPrice(Request $request, DrivingSchool $drivingSchool)
    {
        $drivingSchool->price_per_lesson = $request->input('price_per_lesson');
        $drivingSchool->save();

        return redirect()->route('drivingSchool.index')->with('status', 'Driving school lesson price updated!');
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

    public function updateVehicle(Request $request, Vehicle $vehicle): RedirectResponse
    {
       $validated = $request->validate([
            'registration_number' => 'required|string|max:25',
            'code' => 'required|string|max:10',
            'vin_number' => 'required|string|max:25|unique:vehicles,vin_number',
            'driving_school_id' => 'required|exists:driving_schools,id',
        ]);
 
        $vehicle->update($validated);
 
        return redirect()->route('drivingSchool.index')->with('success', 'Vehicle updated successfully.');
    }

    public function deleteVehicle(Vehicle $vehicle)
    {
        // Delete the vehicle
       $vehicle->delete();

        // Redirect back or to another page with a success message
        return redirect()->route('drivingSchool.index')->with('success', 'Vehicle deleted successfully.');
    }

    public function updateInstructor(Request $request, Instructor $instructor): RedirectResponse
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
        ]);

        // Update the instructor with the validated data
        $instructor->update($validatedData);

        // Redirect with a success message
        return redirect()->route('drivingSchool.index')->with('success', 'Instructor updated successfully.');
    }

    public function deleteInstructor(Instructor $instructor)
    {
        // Delete the instructor
        $instructor->delete();

        // Redirect back or to another page with a success message
        return redirect()->route('drivingSchool.index')->with('success', 'Instructor deleted successfully.');
    }

}