<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::orderBy('created_at', 'DESC')
        ->where('status', STATUS_ACTIVE)
        ->get(['id', 'name', 'total_class']);
        return view('back.attendances.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // return $request;

        $course_id = json_decode($request->course_id)->id;

        if($request->type == 'old') {
            // Update;
            $attendance = Attendance::where('class_no', $request->class_no_data)
                ->where('course_id', $course_id)
                ->firstOrFail();

            $students = json_decode($attendance->attendance_data, true);
            $students = $this->modifiedArrayOnEdit($students);

        }

        else {
            // Create;
            $students = $this->modifiedArrayOnStore($course_id);
        }

        return $students;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        if($request->type === 'new') {
            // Create new data;
            $request->validate([
                'course_id' => 'required',
                'type' => 'required',
                'date' => 'required',
            ]);

            $total_class_count = Attendance::where('course_id', $request->course_id)->count();

            $attendance = new Attendance();
            $attendance->course_id = $request->course_id;
            $attendance->class_no = $total_class_count + 1;
            $attendance->date = $request->date;
            $attendance->attendance_data = json_encode($request->attendances);

            $attendance->save();

           return 'Attendance added successfully';



        }

        else {
            // Update data;
            $request->validate([
                'course_id' => 'required',
                'type' => 'required',
                'class_no_data' => 'required',
            ]);


            $total_class_count = Attendance::where('course_id', $request->course_id)->count();

            return $attendance = Attendance::where('course_id', $request->course_id)
            ->where('class_no', $request->class_no_data)
            ->firstOrFail();

            $attendance->course_id = $request->course_id;
            $attendance->class_no = $total_class_count;
            $attendance->date = $request->date;
            $attendance->attendance_data = json_encode($request->attendances);

            $attendance->save();

           return 'Attendance updated successfully';
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $attendance_count = Attendance::where('course_id', $request->id)->count();
        return $attendance_count;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function modifiedArrayOnEdit ($array) {
        $modifiedArray = [];
        foreach ($array as $item) {
            $modifiedArray[] = [
                "id" => $item["student_id"],
                "name" => $item["student_name"],
                "present" => $item["present"],
                "homework" => $item["homework"],
                "total_present" => $item["total_present"],
                "total_homework" => $item["total_homework"]
            ];
        }

        return $modifiedArray;
    }


    public function modifiedArrayOnStore($course_id) {
        $attendance_exist = Attendance::where('course_id', $course_id)->orderBy('created_at', 'DESC')->first();
        $modifiedArray = [];
        $students = Student::where('course_id', $course_id)->get();

        if ($attendance_exist) {
            $attendance = json_decode($attendance_exist->attendance_data, true);

            foreach ($students as $item) {
                // Search for matching ID in $attendance data
                $matching_attendance = array_filter($attendance, function($att) use ($item) {
                    return $att['student_id'] == $item['id'];
                });

                if (!empty($matching_attendance)) {
                    // Get the first matching attendance item (assuming there's only one match)
                    $matching_attendance = reset($matching_attendance);
                    $modifiedArray[] = [
                        "id" => $item["id"],
                        "name" => $item["name"],
                        "total_present" => $matching_attendance["total_present"],
                        "total_homework" => $matching_attendance["total_homework"]
                    ];
                } else {
                    // If no matching attendance found, set default values
                    $modifiedArray[] = [
                        "id" => $item["id"],
                        "name" => $item["name"],
                        "total_present" => 0, // or any default value you prefer
                        "total_homework" => 0 // or any default value you prefer
                    ];
                }
            }

        }

        else {
            // First Class;
            foreach ($students as $item) {
                $modifiedArray[] = [
                    "id" => $item["id"],
                    "name" => $item["name"],
                    "total_present" => 0, // or any default value you prefer
                    "total_homework" => 0 // or any default value you prefer
                ];
            }
        }
        
        return $modifiedArray;
    }


    // public function modifiedArrayOnStore($course_id) {
    //     return $attendance_exist = Attendance::where('course_id', $course_id)->orderBy('created_at', 'DESC')->get()[0];
    //     $modifiedArray = [];

    //     if ($attendance_exist) {
    //        return $attendance = json_decode($attendance_exist->attendance_data, true);
    //         return 'ok';
    //     }

    //     return $modifiedArray;
    // }

}
