<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Lesson;
use App\Models\Instructor;
use Illuminate\View\View;
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
            'description' => 'N/A', // You can add a field for description if needed
            'duration' => '1:00:00' // Default duration
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'lesson_id' => $lesson->id,
            'instructor_id' => $request->instructor_id,
            'date' => $request->start,
            'time' => $request->start,
        ]);

        return response()->json(['success' => true]);
    }
}