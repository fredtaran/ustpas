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
        $chairpersons = User::where('role', 1)->get(); // For new courses modal select option

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

    // Delete course
    public function delete_course($id) {
        $course = Course::find($id);
        if($course->delete()) {
            return response()->json(['message' => "Record has been deleted successfully"], 200);
        } else {
            return response()->json(['message' => "An errro has been encountered."], 500);
        }
    }

    // Retrieve data for edit
    public function get_course($id) {
        $course = Course::findOrFail($id);

        return response()->json(['course' => $course], 200);
    }

    // Update course details
    public function update_course(Request $request, $id) {
        // Validate inputs
        $course_data = $request->validate([
            'edit_course_name' => ['required'],
            'edit_course_code' => ['required'],
            'edit_chairperson' => ['exists:users,id']
        ]);

        // Find the existing record
        $course = Course::findOrFail($id);

        // Update the values and save
        $course->course_name = $course_data['edit_course_name'];
        $course->course_code = $course_data['edit_course_code'];
        $course->chairperson_id = $course_data['edit_chairperson'];
        $course->save();

        // Refresh page
        return redirect()->route('admission.courses_view');
    }

    // Subject page
    public function subjects() {

        return view('admission.subjects');
    }
}
