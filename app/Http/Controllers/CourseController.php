<?php

namespace App\Http\Controllers;

use App\DataTables\CourseDataTable;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    function index(CourseDataTable $dataTable) {
        return $dataTable->render('back.course.index');
    }

    function create() {
        return view('back.course.create');
    }

    function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'total_class' => 'required|max:255|integer',
            'total_module' => 'required|max:255|integer',
            'total_exam' => 'required|max:255|integer',
            'status' => 'required',
        ]);

        $course = new Course();
        $course->name = $request->name;
        $course->total_class = $request->total_class;
        $course->total_module = $request->total_module;
        $course->total_exam = $request->total_exam;
        $course->status = $request->status;
        $course->save();

        return redirect()->route('course.index')->with('success', 'Course added successfully');
    }

    function edit($id){
        $course = Course::where('id', $id)->firstOrFail();

        return view('back.course.edit', compact('course'));
    }

    function update(Request $request, $id){
        
        $request->validate([
            'name' => 'required|max:255',
            'total_class' => 'required|max:255|integer',
            'total_module' => 'required|max:255|integer',
            'total_exam' => 'required|max:255|integer',
            'status' => 'required',
        ]);

        $course = Course::where('id', $id)->firstOrFail();
        $course->name = $request->name;
        $course->total_class = $request->total_class;
        $course->total_module = $request->total_module;
        $course->total_exam = $request->total_exam;
        $course->status = $request->status;
        $course->save();

        return redirect()->route('course.index')->with('success', 'Course added successfully');
    }

    function delete(Request $request){

        $course = Course::where('id', $request->id)->firstOrFail();
        
        $course->delete();

        return redirect()->route('course.index')->with('success', 'Course update successfully');
    }
}
