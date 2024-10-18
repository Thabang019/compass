<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Lesson;
use App\Models\Instructor;
use App\Models\DrivingSchool;

class StripeController extends Controller
{
 
    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $lessonsData = $request->get('lessons');
        $drivingSchoolName = $request->get('drivingSchoolName');
        $total = $request->get('total') * 100;
        session(['lessons_data' => $lessonsData]);
        session(['school' => $drivingSchoolName]);
        session(['total' => $total]);

        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'ZAR',
                        'product_data' => [
                            'name' => $drivingSchoolName,
                        ],
                        'unit_amount' => $total,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}', 
            'cancel_url' => route('book.confirm'),
        ]);

        return redirect()->away($session->url);
    }


    public function paymentSuccess(Request $request)
    {
    
        $drivingSchoolName = session('school');
        $total = session('total');
        $lessonsData = session('lessons_data');
        $lessonsDataArray = json_decode($lessonsData, true);

            $booking = Booking::create([
                'user_id' => auth()->user()->id,
                'driving_school_name' => $drivingSchoolName,
                'total_price' => $total / 100,
            ]);

        if (is_array($lessonsDataArray)) {
            foreach ($lessonsDataArray as $lesson) {
                Lesson::create([
                    'booking_id' => $booking->id,
                    'date' => $lesson['date'],
                    'start_time' => $lesson['time'],
                    'end_time' => $lesson['endTime'],
                    'lesson_type' => $lesson['lessonType'],
                    'vehicle_registration' => $lesson['vehicle']['registration_number'],
                    'instructor_name' => $lesson['instructor']['name'],
                    'lesson_price' => $lesson['totalPrice'],
                ]);
            }
            session()->forget('lessons_data');
        return redirect()->route('dashboard')->with('status', 'Booking successful!'); 
        }
    return redirect()->route('book.confirm')->withErrors(['error' => 'Payment not successful.']);
    }

    

}
