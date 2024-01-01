<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;

class AdmissionController extends Controller
{

    // Admission Dashboard
    public function dashboard(Request $request) {
        return view('admission/dashboard');
    }

    // Add Courses view
    public function courses(Request $request) {
        $chairpersons = User::where('role', 1)->get();

        return view('admission/courses')->with(['chairpersons' => $chairpersons]);
    }

    // Process new course to save to database
    public function save_course(Request $request) {
        // Validate inputs
        $course_data = $request->validate([
            'course_name' => ['required'],
            'course_code' => ['required'],
            'chairperson' => ['exists:users,id']
        ]);

        // Save new course to database
        $course = new Course();
        $course->course_name = $course_data['course_name'];
        $course->course_code = $course_data['course_code'];
        $course->chairperson_id = $course_data['chairperson'];
        $course->save();

        // Refresh page
        return redirect()->route('admission.courses_view');
    }

    // Fetch all courses - Courses datatable
    public function courses_table() {
        $courses = Course::with('chairperson')->get();

        return response()->json(['data' => $courses]);
    }
}
