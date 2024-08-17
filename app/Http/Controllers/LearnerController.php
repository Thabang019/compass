<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DrivingSchool;
use Illuminate\Support\Facades\Auth;

class LearnerController extends Controller
{
    public function index()
    {
        $driving_schools = DrivingSchool::all();
        return view('dashboard', compact('driving_schools'));
    }

    public function bookSchool(Request $request)
    {
        $request->validate([
            'school' => 'required|exists:driving_schools,id',
            'date' => 'required|date',
            'time' => 'required',
            'lesson_type' => 'required',
            'payment_method' => 'required'
        ]);

        // Here you would handle the booking logic, such as saving it to the database
        // For now, let's just return a success message
        return back()->with('success', 'Booking successful!');
    }
}
