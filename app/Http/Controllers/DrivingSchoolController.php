<?php

namespace App\Http\Controllers;

use App\Models\DrivingSchool;
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
        return view('drivingSchool.dashboard');
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

            $user = $request->user();
    
            if ($request->hasFile('image')) {
    
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $fileName = time().'.'.$extension;
                $imagePath = 'storage/';
                $file->move($imagePath, $fileName);
                $validated['image'] = $imagePath.$fileName;
            }
            $post = $user->posts()->create($validated);
    
            return redirect()->route('posts.show', ['post' => $post])->with('success', 'Blog Post Successfully Posted.');

        }

    /**
     * Display the specified resource.
     */
    public function show(DrivingSchool $drivingSchool)
    {
        //
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
}
