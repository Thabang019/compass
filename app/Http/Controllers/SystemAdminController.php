<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\DrivingSchool;
use App\Models\Booking;
use Carbon\Carbon;

class SystemAdminController extends Controller

{
    public function dashboard() : View
    {
        $allDrivingSchools = DrivingSchool::where('status', 'approved')->get();
        $drivingSchools = DrivingSchool::where('status', 'pending')->get();

        $bookings = Booking::with('lessons')->get();
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
        
         return view('systemAdmin.dashboard', [
            'allDrivingSchools' => $allDrivingSchools,
            'drivingSchools' => $drivingSchools,
            'futureLessons' => $futureLessons,
        ]); 
    }

    public function rejectedSchools() : View
    {  
        $rejectedDrivingSchools = DrivingSchool::where('status', 'rejected')->get();
        return view('systemAdmin.rejected', compact('rejectedDrivingSchools'));
    }

}
