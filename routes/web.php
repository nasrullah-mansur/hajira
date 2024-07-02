<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware('auth')->group(function() {

    // Courses;
    Route::get('courses', [CourseController::class, 'index'])->name('course.index');
    Route::get('course/create', [CourseController::class, 'create'])->name('course.create');
    Route::post('course/store', [CourseController::class, 'store'])->name('course.store');
    Route::get('course/edit/{id}', [CourseController::class, 'edit'])->name('course.edit');
    Route::post('course/update/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::post('course/delete', [CourseController::class, 'delete'])->name('course.delete');


    // Student;
    Route::get('students', [StudentController::class, 'index'])->name('student.index');
    Route::get('student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('student/store', [StudentController::class, 'store'])->name('student.store');
    Route::get('student/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('student/update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::post('student/delete', [StudentController::class, 'delete'])->name('student.delete');
});
