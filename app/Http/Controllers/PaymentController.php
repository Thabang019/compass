<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Show the confirmation page with booking details
    public function confirm(Request $request)
    {
        $user = Auth::user();
        
        // Get the user's bookings that are not yet paid
        $bookings = Booking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->get();

        // Calculate total cost based on the number of hours booked
        $totalCost = 0;
        foreach ($bookings as $booking) {
            $totalCost += $booking->hours * 200; // 200 is the price per lesson/hour
        }

        return view('book.confirm', [
            'user' => $user,
            'bookings' => $bookings,
            'totalCost' => $totalCost,
        ]);
    }

    // Process the payment (user enters amount manually)
    public function processPayment(Request $request)
    {
        $user = Auth::user();
        
        // Validate the entered amount
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $enteredAmount = $request->input('amount');

        // Get the user's pending bookings
        $bookings = Booking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->get();

        // Calculate total cost again
        $totalCost = 0;
        foreach ($bookings as $booking) {
            $totalCost += $booking->hours * 200;
        }

        // Check if the entered amount matches the total cost
        if ($enteredAmount < $totalCost) {
            return redirect()->back()->withErrors('The amount entered is less than the total cost.');
        }

        // If payment is successful, update the booking statuses
        foreach ($bookings as $booking) {
            $booking->status = 'paid';
            $booking->save();
        }

        return redirect()->route('bookings.index')->with('success', 'Payment successful and booking confirmed!');
    }
}
