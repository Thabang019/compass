<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:50', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required',],
        ]);

        if ($request->role == 'user') {
            $request->validate([
                'driver_license_number' => ['required', 'string', 'max:13'],
                'phone_number' => ['required', 'string', 'max:10'],
            ]);
        }

        $user = User::create([
            'driver_license_number' => $request->driver_license_number ?? null,
            'phone_number' => $request->phone_number ?? null,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->role === 'admin') 
        {
            return redirect(route('drivingSchool.register'));
            
        } elseif ($user->role === 'user')
        {
            return redirect(route('dashboard'));
        } else
        {
            return redirect()->route('systemAdmin.dashboard');
        }
    }
}