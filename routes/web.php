<?php
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LearnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DrivingSchoolController;
use App\Http\Controllers\SystemAdminController;
use App\Http\Controllers\WorkingHoursController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\LessonController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', function () {
    return view('search');
});

Route::get('/bookings/confirm', [PaymentController::class, 'confirm'])->name('bookings.confirm');
Route::post('/store-bookings', [BookingController::class, 'store']);
Route::post('/bookings/confirm-payment', [BookingController::class, 'finalizePayment'])->name('bookings.finalizePayment');
Route::post('/book/pay', [PaymentController::class, 'processPayment'])->name('book.pay');
Route::get('/book/confirm', [BookingController::class, 'showConfirmationPage'])->name('book.confirm');



Route::get('systemAdmin/dashboard', [SystemAdminController::class, 'dashboard'])->name('systemAdmin.dashboard');
Route::get('systemAdmin/dashboard/rejected', [SystemAdminController::class, 'rejectedSchools'])->name('systemAdmin.rejected');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/search', [DrivingSchoolController::class, 'search'])->name('driving_schools.search');
Route::get('/dashboard', [DrivingSchoolController::class, 'index'])->name('dashboard');
Route::get('/driving-schools', [DrivingSchoolController::class, 'index'])->name('driving_schools.index');
Route::get('/driving-schools/suggestions', [DrivingSchoolController::class, 'getSuggestions'])->name('driving_schools.suggestions');

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
Route::post('/drivingSchools/{drivingSchool}/update-price', [DrivingSchoolController::class, 'updateLessonPrice'])->name('drivingSchool.updatePrice');

Route::get('/profile/{id}', [ProfileController::class, 'displayDrivingSchoolProfile'])->name('profile.displayDrivingSchoolProfile');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  
    Route::get('/learner/dashboard', [LearnerController::class, 'index'])->name('learner.dashboard');
    Route::post('/learner/book-school', [LearnerController::class, 'bookSchool'])->name('learner.book_school');

    Route::post('/bookings/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::get('/book/{school}', [BookingController::class, 'create'])->name('book.create');
    Route::post('/book', [BookingController::class, 'store'])->name('book.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

Route::post('working-hours/store', [WorkingHoursController::class, 'store'])->name('working_hours.store');
Route::get('working-hours/schedule', [WorkingHoursController::class, 'schedule'])->name('working_hours.schedule');
Route::put('/working_hours/{id}', [WorkingHoursController::class, 'update'])->name('working_hours.update');

    Route::post('/session', [StripeController::class, 'session'])->name('session');
    Route::get('/success', [StripeController::class, 'paymentSuccess'])->name('success');
    Route::get('/cancel', function () {
        return redirect()->route('book.confirm')->with('status', 'Payment was canceled.');
    })->name('cancel');


Route::post('/drivingSchool/store-instructor', [DrivingSchoolController::class, 'store_instructor'])
    ->name('instructors.store')
    ->middleware(['auth', 'verified']);

Route::post('/drivingSchool/store-vehicle', [DrivingSchoolController::class, 'store_vehicle'])
    ->name('vehicles.store')
    ->middleware(['auth', 'verified']);

Route::resource('drivingSchool', DrivingSchoolController::class)
    ->only(['index', 'store', 'edit'])
    ->middleware(['auth', 'verified']);

    Route::get('/my-lessons', [LessonController::class, 'showMyLessons'])->name('my.lessons');


// Include Authentication Routes
require __DIR__.'/auth.php';