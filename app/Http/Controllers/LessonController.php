<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function showMyLessons()
    {
        $userId = Auth::id();
        // Fetch user's bookings and related lessons
        $bookings = Booking::where('user_id', $userId)
            ->with('lessons') // Assuming there is a relationship between Booking and Lesson
            ->get();

        return view('my-lessons', compact('bookings'));
    }
}
