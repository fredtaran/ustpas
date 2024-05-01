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
        $students = Student::whereHas('credited_subject', function($query) {
                                $query->whereHas('subject', function($x) {
                                    $x->where('chairperson_id', auth()->user()->id);
                                })->where('status', 1);
                            })->with('course')->get();

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
        $subjects = SubjectForCredit::with('subject')
                                    ->with('subject.chairperson')
                                    ->where('student_id', $student_id)
                                    ->get();

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

    // Upload e-sig
    public function upload_esig($user_id) {
        $user = User::findOrFail($user_id);

        return view('chairperson.upload_esig')->with([
            'user' => $user
        ]);
    }

    // Save e-sig
    public function save_upload_esig(Request $request, $user_id) {
        // Validate
        $messages = [
            'e_signature.required' => 'Please select a file.',
            'e_signature.mimes' => 'Only JGP, JPEG, PNG files are allowed.',
            'e_signature.max' => 'The file size may not exceed 2048 kilobytes.',
        ];
    

        $uploadedFile = $request->validate([
            'e_signature' => 'required|mimes:jpg,png,jpeg|max:2048'
        ], $messages);


        $file = $request->file('e_signature');
        $filename = uniqid() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public', $filename);

        // Save to database
        $user = User::findOrFail($user_id);
        $user->esignature = $filename;
        $user->save();

        return back()->with('success','You have successfully upload file.')
                    ->with('e_signature', $fileName);
    }
}
