<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Code;
use App\Models\SubjectForCredit;
use App\Models\Student;

class TrackerController extends Controller
{
    //
    public function landing_page() {
        return view('tracker');
    }

    // Get all the accredited subject status
    public function get_accredited_subjects($code) {
        $tracking_code = Code::where('code', $code)->first();
        $subjects = SubjectForCredit::with('subject')->where('code_id', $tracking_code->id)->get();

        return response()->json([
            'data' => $subjects
        ]);        
    }

    public function generate_pdf($tracking_code) {
        $code = Code::where('code', $tracking_code)->first();
        $creditedSubjects = SubjectForCredit::with('subject.course.chairperson')->where('code_id', $code->id)->get();
        $student = Student::with('course')->where('id', $creditedSubjects[0]->student_id)->first();

        $data = [
            'student' => $student,
            'creditedSubjects' => $creditedSubjects,
        ];

        $pdf = Pdf::loadView('pdf.pdf_template', $data);
        return $pdf->stream('sample.pdf');
    }
}
