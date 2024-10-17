<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
 
    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $drivingSchoolName = $request->get('drivingSchoolName');
        $totalPrice = $request->get('total');
        $total = $totalPrice * 100; // Stripe expects amounts in cents, so multiply by 100

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'USD',
                        'product_data' => [
                            "name" => $drivingSchoolName,
                        ],
                        'unit_amount'  => $total,
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'payment',
            'success_url' => route('dashboard'), 
            'cancel_url'  => route('book.confirm'),
        ]);

        return redirect()->away($session->url);
    }
}
