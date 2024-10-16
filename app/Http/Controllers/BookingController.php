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
        return view('book.create', compact('school'));
    }
    public function finalizePayment(Request $request)
{
    // Validate the payment amount (user should input the correct total)
    $request->validate([
        'amount_paid' => 'required|numeric|min:' . $request->input('totalCost'),
    ]);

    // Optionally, mark the bookings as 'paid' or 'completed' in the database
    Booking::where('user_id', Auth::id())->update(['status' => 'completed']);

    // Clear session bookings after payment
    $request->session()->forget('bookings');

    return redirect()->route('dashboard')->with('success', 'Payment successful, and booking is completed!');
}


   public function showConfirmationPage()
{
    $user = Auth::user();
    $bookings = Booking::where('user_id', $user->id)->get();

    // Default lesson price
    $lessonPrice = 200;

    // Calculate the total cost by summing up hours * lesson price for all bookings
    $totalCost = $bookings->sum(function($booking) use ($lessonPrice) {
        return $booking->hours * $lessonPrice;
    });

    return view('book.confirm', [
        'user' => $user,  // Check if the phone number is available on this object
        'bookings' => $bookings,
        'lessonPrice' => $lessonPrice,
        'totalCost' => $totalCost
    ]);
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
