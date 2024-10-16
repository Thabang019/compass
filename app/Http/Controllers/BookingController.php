<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Lesson;
use App\Models\Instructor;
use App\Models\DrivingSchool;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('lesson', 'instructor')->get()->map(function ($booking) {
            return [
                'title' => $booking->lesson->title . ' with ' . $booking->instructor->name,
                'start' => $booking->date . ' ' . $booking->time,
            ];
        });
        
        return view('bookings.calendar', compact('bookings'));
    }

    public function create(DrivingSchool $school)
    {
        $school = $school->load(['instructors', 'vehicles']);
        return view('book.create', compact('school'));
    }
    
    public function storeBookings(Request $request)
{
    $bookings = $request->input('bookings');
    $request->session()->put('bookings', $bookings); // Store the bookings in session
    return response()->json(['message' => 'Bookings stored successfully']);
}

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'instructor_id' => 'required|exists:instructors,id',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $lesson = Lesson::create([
            'title' => $request->title,
            'description' => 'N/A', // Add a field for description if needed
            'duration' => '1:00:00' // Default duration
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'lesson_id' => $lesson->id,
            'instructor_id' => $request->instructor_id,
            'date' => $request->start->format('Y-m-d'),
            'time' => $request->start->format('H:i:s'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking created successfully!');
    }
}
