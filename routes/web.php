<?php
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LearnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DrivingSchoolController;
use Illuminate\Support\Facades\Route;
use App\Models\DrivingSchool;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::middleware(['auth', 'verified'])->group(function () {
   
    Route::get('/dashboard', [DrivingSchoolController::class, 'index'])->name('dashboard');

   
    Route::get('/search', [DrivingSchoolController::class, 'search'])->name('search');
    Route::post('/search', [DrivingSchoolController::class, 'search']);
    Route::get('/driving-schools/search', [DrivingSchoolController::class, 'search'])->name('driving_schools.search');
   
    Route::get('drivingSchool', [DrivingSchoolController::class, 'index'])->name('drivingSchool.dashboard');

    
    Route::get('drivingSchool/register', [RegistrationController::class, 'drivingSchool'])->name('drivingSchool.register');
    Route::post('drivingSchool/register', [RegistrationController::class, 'postStep1'])->name('register.postStep1');
    Route::get('vehicle/register', [RegistrationController::class, 'vehicle'])->name('vehicle.register');
    Route::post('vehicle/register', [RegistrationController::class, 'postStep2'])->name('register.postStep2');
    Route::get('instructor/register', [RegistrationController::class, 'instructor'])->name('instructor.register');
    Route::post('instructor/register', [RegistrationController::class, 'postStep3'])->name('register.postStep3');

    
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  
    Route::get('/learner/dashboard', [LearnerController::class, 'index'])->name('learner.dashboard');
    Route::post('/learner/book-school', [LearnerController::class, 'bookSchool'])->name('learner.book_school');

   
    Route::get('/book/{school}', [BookingController::class, 'create'])->name('book.create');
    Route::post('/book', [BookingController::class, 'store'])->name('book.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});


Route::get('systemAdmin/dashboard', [SystemAdminController::class, 'dashboard'])->name('systemAdmin.dashboard');

// Include Authentication Routes
require __DIR__.'/auth.php';
