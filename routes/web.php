<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseStudentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');
Route::post('/login', [AuthController::class, 'submitLogin'])->name('login.submit');


Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance');



Route::middleware(['session.check', 'prevent.back'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Password change (first-time login) - accessible to all logged-in users
    Route::get('/user-page', [PasswordController::class, 'showChangeForm'])->name('password.change.form');
    Route::post('/user-page', [PasswordController::class, 'update'])->name('password.change.update');

    // All other routes are blocked until password is changed
    Route::middleware(['force.password.change'])->group(function () {

        // Dashboard route with statistics
        Route::get('/dashboard', function () {
            $role = session('user_role');
            
            // Get statistics
            $studentCount = \App\Models\Student::count();
            $teacherCount = \App\Models\Teacher::count();
            $courseCount = \App\Models\Course::count();
            
            if ($role === 'admin') {
                return view('dashboards.admin', compact('studentCount', 'teacherCount', 'courseCount'));
            } elseif ($role === 'teacher') {
                return view('dashboards.teacher');
            } elseif ($role === 'student') {
                return view('dashboards.student');
            }
            return redirect()->route('login');
        })->name('dashboard');

        // Admin-only routes
        Route::middleware(['admin.only'])->group(function () {
            Route::resource('/users', UserController::class);
        });
        
        // Admin and Teacher routes
        Route::middleware([\App\Http\Middleware\AdminOrTeacher::class])->group(function () {
            Route::resource('/students', StudentController::class);
            Route::resource('/teachers', TeacherController::class);
            Route::get('/studentDetails', [StudentController::class, 'index'])->name('students.details');
            Route::resource('/degrees', DegreeController::class);
            Route::resource('/courses', CourseController::class);
            Route::resource('/course_students', CourseStudentController::class);
        });

        // Admin/Teacher shared routes
        Route::get('/greetings', [ClientController::class, 'displayGreetings'])->name('greetings');
        Route::get('/clientProfile', [ClientController::class, 'displayProfile']);
        Route::get('/clientDashboard', [ClientController::class, 'displayDashboard']);
        Route::get('/clientAboutUs', [ClientController::class, 'displayAboutUs']);

        Route::resource('/profiles', ProfileController::class);
        Route::resource('/posts', PostController::class);

        // Student-only routes
        Route::post('/student/password/update', [PasswordController::class, 'studentPasswordUpdate'])->name('student.password.update');

        // Teacher-only routes
        Route::post('/teacher/password/update', [PasswordController::class, 'teacherPasswordUpdate'])->name('teacher.password.update');

    }); // end force.password.change
});

// Catch-all route - redirect to login if not authenticated
Route::fallback(function () {
    if (!session()->has('user_id')) {
        return redirect()->route('login')->with('error', 'Please log in to access this page.');
    }
    abort(404, 'Page not found');
});