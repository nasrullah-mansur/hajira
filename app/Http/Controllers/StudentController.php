<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use App\DataTables\StudentDataTable;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StudentDataTable $dataTable)
    {
        return $dataTable->render('back.student.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::get(['id', 'name']);
        return view('back.student.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'course_id' => 'required|numeric',
            'email' => 'required|email',
            'phone' => 'required|max_digits:11',
        ]);

        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->course_id = $request->course_id;
        $student->status = $request->status;
        $student->save();

        return redirect()->route('student.index')->with('success', 'Student added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::where('id', $id)->firstOrFail();
        $courses = Course::get(['id', 'name']);

        return view('back.student.edit', compact('student', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'course_id' => 'required|numeric',
            'email' => 'required|email',
            'phone' => 'required|max_digits:11',
        ]);

        $student = Student::where('id', $id)->firstOrFail();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->course_id = $request->course_id;
        $student->status = $request->status;
        $student->save();

        return redirect()->route('student.index')->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $student = Student::where('id', $request->id)->firstOrFail();

        $student->delete();

        return redirect()->route('student.index')->with('success', 'Student removed successfully');
    }
}
