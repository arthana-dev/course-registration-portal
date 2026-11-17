
<?php

use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Models\Course;
use App\Models\Registration;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Student course registration
Route::post('/courses/{course}/register', [RegistrationController::class, 'store'])
    ->name('courses.register');

// Admin course management
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('courses', CourseController::class);
    Route::get('/registrations', [AdminRegistrationController::class, 'index'])
        ->name('registrations.index');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard', [
        'totalCourses' => Course::count(),
        'totalRegistrations' => Registration::count(),
    ]);
})->middleware(['auth', 'admin'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
