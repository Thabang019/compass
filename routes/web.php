<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DrivingSchoolController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', function () {
    return view('search');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('drivingSchool/register', [RegistrationController::class, 'drivingSchool'])->name('drivingSchool.register');
Route::post('drivingSchool/register', [RegistrationController::class, 'postStep1'])->name('register.postStep1');

Route::get('vehicle/register', [RegistrationController::class, 'vehicle'])->name('vehicle.register');
Route::post('vehicle/register', [RegistrationController::class, 'postStep2'])->name('register.postStep2');

Route::get('instructor/register', [RegistrationController::class, 'instructor'])->name('instructor.register');
Route::post('instructor/register', [RegistrationController::class, 'postStep3'])->name('register.postStep3');

Route::get('drivingSchool', [DrivingSchoolController::class, 'index'])->name('drivingSchool.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('drivingSchool', DrivingSchoolController::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
