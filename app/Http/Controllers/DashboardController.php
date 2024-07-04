<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index() {
        $total_students = Student::where('status', STATUS_ACTIVE)->count();
        $total_courses_ongoing = Course::where('status', STATUS_ACTIVE)->count();
        $total_courses_upcoming = Course::where('status', STATUS_UPCOMING)->count();
        return view('dashboard', compact('total_students', 'total_courses_ongoing', 'total_courses_upcoming'));
    }
}
