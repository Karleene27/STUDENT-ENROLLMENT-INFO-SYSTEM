<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\MyCoursesController;
use App\Http\Controllers\Student\EnrollmentController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\StudentManagementController;
use App\Http\Controllers\Admin\CourseManagementController;
use App\Http\Controllers\Admin\EnrollmentManagementController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\PageController;

// PUBLIC
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');

// AUTH
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// AUTHENTICATED (common)
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// STUDENT
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-courses', [MyCoursesController::class, 'index'])->name('my-courses');
    Route::get('/enroll', [EnrollmentController::class, 'index'])->name('enroll.index');
    Route::get('/enroll/course/{course}/sections', [EnrollmentController::class, 'getSections'])->name('enroll.sections');
    Route::post('/enroll/add-to-cart', [EnrollmentController::class, 'addToCart'])->name('enroll.addToCart');
    Route::post('/enroll/confirm', [EnrollmentController::class, 'confirmEnrollment'])->name('enroll.confirm');
    Route::delete('/enroll/remove-from-cart/{cartId}', [EnrollmentController::class, 'removeFromCart'])->name('enroll.remove');
    // Grades removed – no /my-grades route
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    // Payments route (single definition)
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
});

// ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/students/pending', [StudentManagementController::class, 'pending'])->name('students.pending');
    Route::put('/students/{student}/approve', [StudentManagementController::class, 'approve'])->name('students.approve');
    Route::delete('/students/{student}/reject', [StudentManagementController::class, 'reject'])->name('students.reject');
    Route::resource('/students', StudentManagementController::class);
    Route::resource('/courses', CourseManagementController::class);
    Route::post('/courses/{course}/sections', [CourseManagementController::class, 'storeSection'])->name('courses.sections.store');
    Route::get('/enrollments', [EnrollmentManagementController::class, 'index'])->name('enrollments.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});