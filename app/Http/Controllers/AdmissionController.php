<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Models\Student;

class AdmissionController extends Controller
{

    // Admission Dashboard - return view
    public function dashboard(Request $request) {
        return view('admission/dashboard');
    }

    // Add Courses view - return view
    public function courses(Request $request) {
        $chairpersons = User::where('role', 1)->get(); // For new courses modal select option

        return view('admission/courses')->with(['chairpersons' => $chairpersons]);
    }

    // Process new course to save to database - process
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

    // Fetch all courses - return json
    public function courses_table() {
        $courses = Course::with('chairperson')->get();

        return response()->json(['data' => $courses]);
    }

    // Delete course - process
    public function delete_course($id) {
        $course = Course::findOrFail($id);
        if($course->delete()) {
            return response()->json(['message' => "Record has been deleted successfully"], 200);
        } else {
            return response()->json(['message' => "An errro has been encountered."], 500);
        }
    }

    // Retrieve data for edit - return json
    public function get_course($id) {
        $course = Course::findOrFail($id);

        return response()->json(['course' => $course], 200);
    }

    // Update course details - process
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

    // Subject page - return view
    public function course_detail($id) {
        $course = Course::where('id', $id)->get();

        return view('admission.course_detail')->with(['course' => $course]);
    }

    // Save subject - process
    public function save_subject(Request $request) {
        // Validate inputs
        $subject_data = $request->validate([
            'subject_code' => ['required'],
            'description' => ['required'],
            'unit' => ['numeric'],
            'course_id' => ['required']
        ]);

        // Initialize the subject model
        $subject = new Subject();
        $subject->subject_code = $subject_data['subject_code'];
        $subject->subject_description = $subject_data['description'];
        $subject->unit = $subject_data['unit'];
        $subject->course_id = $subject_data['course_id'];
        $subject->save();

        // Refresh page
        return redirect()->route('admission.course_detail', $subject_data['course_id']);
    }

    // Get list of subjects per course - return json
    public function get_subjects($id) {
        $subjects = Subject::where('course_id', $id)->get();

        return response()->json(['data' => $subjects]);
    }

    // Delete subject - process
    public function delete_subject($id) {
        $subject = Subject::findOrFail($id);
        if($subject->delete()) {
            return response()->json(['message' => "Record has been deleted successfully"], 200);
        } else {
            return response()->json(['message' => "An errro has been encountered."], 500);
        }
    }

    // Get subject - return json
    public function get_subject($id) {
        $subject = Subject::findOrFail($id);

        return response()->json(['subject' => $subject], 200);
    }

    // Update subject details - process
    public function update_subject(Request $request, $id) {
        // Validate inputs
        $subject_data = $request->validate([
            'edit_subject_code' => ['required'],
            'edit_description' => ['required'],
            'edit_unit' => ['numeric'],
            'course_id' => ['required']
        ]);

        // Find the existing record - return view
        $subject = Subject::findOrFail($id);

        // Update the values and save
        $subject->subject_code = $subject_data['edit_subject_code'];
        $subject->subject_description = $subject_data['edit_description'];
        $subject->unit = $subject_data['edit_unit'];
        $subject->save();

        // Refresh page
        return redirect()->route('admission.course_detail', $subject_data['course_id']);
    }

    // Students view
    public function students_view() {
        return view('admission.students');
    }

    // Get student list
    public function get_student() {
        $students = Student::with('course')->get();

        return response()->json(['data' => $students]);
    }

    // Add student view
    public function add_student_view() {
        $courses = Course::all();

        return view('admission.add_student')->with(['courses' => $courses]);
    }

    // Add student
    public function add_student(Request $request) {
        // Validate data
        $data = $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'first_name' => 'required',
            'middle_name' => '',
            'last_name' => 'required',
            'suffix' => '',
            'email' => 'required|unique:students,email',
            'contact_number' => 'required|unique:students,contact_number',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required',
        ]);

        if(Student::create($data)) {
            return redirect()->route('admission.students_view');
        }
    }

    // Delete student
    public function delete_student($id) {
        $student = Student::findOrFail($id);
        if($student->delete()) {
            return response()->json(['message' => "Record has been deleted successfully"], 200);
        } else {
            return response()->json(['message' => "An errro has been encountered."], 500);
        }
    }

    // Edit student view
    public function edit_student($id) {
        $student = Student::where('id', $id)->first();
        $courses = Course::all();

        return view('admission.edit_student')->with([
            'student' => $student,
            'courses' => $courses
        ]);
    }

    // Save changes
    public function save_student_changes(Request $request, $id) {
        // Validate data
        $data = $request->validate([
            'student_id' => 'required',
            'first_name' => 'required',
            'middle_name' => '',
            'last_name' => 'required',
            'suffix' => '',
            'email' => 'required',
            'contact_number' => 'required',
            'course_id' => 'required|exists:courses,id',
            'year_level' => 'required',
        ]);

        $student = Student::findOrFail($id);

        $student->student_id = $data['student_id'];
        $student->first_name = $data['first_name'];
        $student->middle_name = $data['middle_name'];
        $student->last_name = $data['last_name'];
        $student->suffix = $data['suffix'];
        $student->email = $data['email'];
        $student->contact_number = $data['contact_number'];
        $student->course_id = $data['course_id'];
        $student->year_level = $data['year_level'];
        $student->save();

        return redirect()->route('admission.students_view');
    }

    // Student detail
    public function student_details($id) {
        $student = Student::where('id', $id)->first();

        dd($student);
    }
}
