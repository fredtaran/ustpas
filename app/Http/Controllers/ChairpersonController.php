<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Student;
use App\Models\Course;
use App\Models\User;
use App\Models\Subject;
use App\Models\SubjectForCredit;

class ChairpersonController extends Controller
{
    // Display chairperson dashboard
    public function dashboard(Request $request) {
        return view('chairperson/dashboard');
    }

    // Get all the students subjected for accreditation
    public function get_students() {
        $students = DB::table('students')
                        ->join('courses', 'students.course_id', '=', 'courses.id')
                        ->join('subject_for_credits', 'students.id', '=', 'subject_for_credits.student_id')
                        ->join('users', 'courses.chairperson_id', '=', 'users.id')
                        ->select('students.*', 'users.id AS chair', 'courses.course_name')
                        ->groupBy('students.id', 'students.student_id', 'students.first_name', 'students.middle_name', 'students.last_name', 'students.suffix', 'students.email', 'students.contact_number', 'students.course_id', 'students.year_level', 'students.created_at', 'students.updated_at', 'users.id', 'courses.course_name')
                        ->where('users.id', auth()->user()->id)
                        ->get();

        return response()->json([
            'data'  =>  $students
        ]);
    }

    // Individual student for approving of subjects subject for accreditation
    public function get_student($student_id) {
        $student = Student::findOrFail($student_id);

        return view('chairperson.student')->with([
            'student' => $student,
        ]);
    }

    // Get subjects for accredited
    public function get_subjects_for_accreditation($student_id) {
        $subjects = SubjectForCredit::with('subject')->where('student_id', $student_id)->where('status', 1)->get();

        return response()->json([
            'data' => $subjects
        ]);
    }

    // Update if approve or denied
    public function update_status($accreditation_id, $status) {
        $accreditation = SubjectForCredit::findOrFail($accreditation_id);

        if($status == 'approved') {
            $accreditation->status = 2;
            $accreditation->save();
        } else if($status == 'denied') {
            $accreditation->status = 3;
            $accreditation->save();
        }

        return response()->json([
            'message' => "Updated successfully"
        ]);
    }
}
