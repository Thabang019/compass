<?php
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LearnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DrivingSchoolController;
use App\Http\Controllers\SystemAdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', function () {
    return view('search');
});

Route::get('systemAdmin/dashboard', [SystemAdminController::class, 'dashboard'])->name('systemAdmin.dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/driving-schools/search', [DrivingSchoolController::class, 'search'])->name('driving_schools.search');
Route::get('/dashboard', [DrivingSchoolController::class, 'index'])->name('dashboard');


Route::get('drivingSchool/register', [RegistrationController::class, 'drivingSchool'])->name('drivingSchool.register');
Route::post('drivingSchool/register', [RegistrationController::class, 'postStep1'])->name('register.postStep1');

Route::get('vehicle/register', [RegistrationController::class, 'vehicle'])->name('vehicle.register');
Route::post('vehicle/register', [RegistrationController::class, 'postStep2'])->name('register.postStep2');

Route::get('instructor/register', [RegistrationController::class, 'instructor'])->name('instructor.register');
Route::post('instructor/register', [RegistrationController::class, 'postStep3'])->name('register.postStep3');

Route::get('drivingSchool', [DrivingSchoolController::class, 'index'])->name('drivingSchool.dashboard');

Route::put('/driving-school/instructors/{instructor}', [DrivingSchoolController::class, 'updateInstructor'])->name('drivingSchool.update-in');
Route::delete('/driving-school/instructors/{instructor}', [DrivingSchoolController::class, 'deleteInstructor'])->name('drivingSchool.delete-in');

Route::put('/driving-school/vehicles/{vehicle}', [DrivingSchoolController::class, 'updateVehicle'])->name('drivingSchool.update');
Route::delete('/driving-school/vehicles/{vehicle}', [DrivingSchoolController::class, 'deleteVehicle'])->name('drivingSchool.delete');

Route::get('/driving-schools/{drivingSchool}', [DrivingSchoolController::class, 'show'])->name('drivingSchools.show');
Route::post('/driving-schools/{drivingSchool}/update-status', [DrivingSchoolController::class, 'updateStatus'])->name('drivingSchools.updateStatus');

Route::get('/profile/{id}', [ProfileController::class, 'displayDrivingSchoolProfile'])->name('profile.displayDrivingSchoolProfile');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  
    Route::get('/learner/dashboard', [LearnerController::class, 'index'])->name('learner.dashboard');
    Route::post('/learner/book-school', [LearnerController::class, 'bookSchool'])->name('learner.book_school');

   
    Route::get('/book/{school}', [BookingController::class, 'create'])->name('book.create');
    Route::post('/book', [BookingController::class, 'store'])->name('book.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});


Route::post('/drivingSchool/store-instructor', [DrivingSchoolController::class, 'store_instructor'])
    ->name('instructors.store')
    ->middleware(['auth', 'verified']);

Route::post('/drivingSchool/store-vehicle', [DrivingSchoolController::class, 'store_vehicle'])
    ->name('vehicles.store')
    ->middleware(['auth', 'verified']);

Route::resource('drivingSchool', DrivingSchoolController::class)
    ->only(['index', 'store', 'edit'])
    ->middleware(['auth', 'verified']);

// Include Authentication Routes
require __DIR__.'/auth.php';
