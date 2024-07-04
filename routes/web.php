<?php

use App\Http\Controllers\{
    AttendanceController,
    CourseController,
    DashboardController,
    ProfileController,
    StudentController
};
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware('auth')->group(function () {

    Route::middleware('verified')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('course.index');
        Route::get('create', [CourseController::class, 'create'])->name('course.create');
        Route::post('store', [CourseController::class, 'store'])->name('course.store');
        Route::get('edit/{id}', [CourseController::class, 'edit'])->name('course.edit');
        Route::post('update/{id}', [CourseController::class, 'update'])->name('course.update');
        Route::post('delete', [CourseController::class, 'delete'])->name('course.delete');
    });

    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::get('create', [StudentController::class, 'create'])->name('student.create');
        Route::post('store', [StudentController::class, 'store'])->name('student.store');
        Route::get('edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
        Route::post('update/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::post('delete', [StudentController::class, 'delete'])->name('student.delete');
    });

    Route::prefix('attendances')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('store', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::post('view', [AttendanceController::class, 'show'])->name('attendance.view');
        Route::get('edit/{id}', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::post('update/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
        Route::post('delete', [AttendanceController::class, 'delete'])->name('attendance.delete');
    });
});
