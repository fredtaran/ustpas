<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Mail;
use App\Mail\NotifyChairperson;

use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Models\Student;
use App\Models\Tor;
use App\Models\Code;
use App\Models\SubjectForCredit;

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
        $student = Student::findOrFail($id);
        $course = Course::findOrFail($student->course_id);
        $tors = Tor::where('student_id', $id)->get();

        return view('admission.student_details')->with([
            'student' => $student,
            'course' => $course,
            'tors' => $tors
        ]);
    }

    // Save tor to database
    public function save_tor(Request $request) {
        $destinationPath = 'uploads';
        $files = $request->file('tor');
        foreach($files as $file) {
            // Move uploaded file to storage/public folder
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public', $filename);
            
            // Save to database
            Tor::create([
                'student_id' => $request->input('student_id'),
                'file_path' => $filename
            ]);
        }

        return back();
    }

    // Get TORs
    public function get_tors($id) {
        $tors = Tor::where('student_id', $id)->get();

        return response()->json([
            'data' => $tors
        ]);
    }

    // Delete TOR
    public function delete_tor($id) {
        // Find the TOR data
        $tor = Tor::findOrFail($id);

        // Delete from the storage/public directory
        $file = Storage::delete('public/' . $tor->file_path);

        if($file) {
            if($tor->delete()) {
                return response()->json([
                    'message' => "Record succesfully deleted."
                ]);
            }
        }
    }

    // Map TOR data
    public function map_data($tor_id, $student_id) {
        // Retrieve student data
        $student = Student::findOrFail($student_id);

        // Retrieve TOR from the database
        $tor = Tor::findOrFail($tor_id);

        // Conver image to text
        $file_path = storage_path('app/public/' . $tor->file_path); // Image file path
        $script = base_path('app/Http/Controllers/ocr.py'); // path to ocr python script
        $command = "python {$script} --image {$file_path}"; // Set command
        $tor_raw = null; // Set variable for the output and return
        $escapedCmd = escapeshellcmd($command); // Escape command
        exec($escapedCmd, $tor_raw); // Execute command

        // Process the raw TOR data
        $course_subjects = Subject::where('course_id', $student->course_id)->get();
        $tor_raw_collection = collect($tor_raw); // Convert array to collection
        $subjects_to_be_credited = $tor_raw_collection->map(function($item) use ($course_subjects) {
            $subjects_to_be_credited_formatted = array();

            $stopwords = array(" the ", " in ", " and ", " to ", " for ", " ng ", " at ", " sa ", " from ", " of ");    //declare stopwords

            $tor_raw_low_case = strtolower($item); // Transform the TOR data to lowercase
            $tor_raw_remove_stopwords = str_replace($stopwords, " ", $tor_raw_low_case); // remove stopwords from extracted student data

            foreach($course_subjects as $subject) {
                $subject_low_case = strtolower($subject->subject_description); //Convert characters to lowercase
                $subject_remove_stopwords = str_replace($stopwords, " ", $subject_low_case); //remove stopwords from extracted student data

                if(str_contains($tor_raw_remove_stopwords, $subject_remove_stopwords)) {
                    // Clean data
                    $clean_tor_data = strstr($tor_raw_remove_stopwords, $subject_remove_stopwords); // Remove the tor data subject/course code
                    $clean_grade_unit = trim(preg_replace('/[^\d.-]+/', ' ', str_replace($subject_remove_stopwords, "", $clean_tor_data))); // Remove everything except digits, dots, and optionally a single leading or trailing minus sign. Also remove the leading or trailing space
                    $grade_unit = explode(" ", $clean_grade_unit); // Separate the grade and unit

                    // Check if the units is the same
                    if($grade_unit[1] == $subject->unit) {
                        // Check if the grade pass
                        if($grade_unit[0] <= 3) {
                            // If grade is pass, add data to array for subject to be credited
                            $data = array(
                                'subject_id' => $subject->id,
                                'grade' => $grade_unit[0]
                            );
                        }
                    }

                    array_push($subjects_to_be_credited_formatted, $data);
                }
            }

            return $subjects_to_be_credited_formatted;
        });

        // Remove null values
        $filterSubjects = array_filter($subjects_to_be_credited->toArray(), function ($value) {
            return $value !== [];
        });

        // // Generate code to be sent to the student; format: minutes-seconds-6 random digits
        // $reference_code = Carbon::now()->format('is') . "" . rand(100000,999999);

        // // Save the new generated code
        // $new_code = Code::create(['code' => $reference_code]);
        
        // // Prepare the data to be save to credited_subject_table
        // $convert_subject_to_collection = collect($filterSubjects);
        // $data_for_saving = $convert_subject_to_collection->map(function($item) use ($student_id, $new_code) {
        //     $item[0]['student_id'] = $student_id;
        //     $item[0]['code_id'] = $new_code->id;
        //     return $item;
        // });

        // // Save subjects for program chair approval
        // foreach($data_for_saving as $subject) {
        //     SubjectForCredit::create($subject[0]);
        // }

        // Retrieve chairperson email
        $chairperson = DB::table('subject_for_credits')
                        ->join('subjects', 'subject_for_credits.subject_id', '=', 'subjects.id')
                        ->join('courses', 'subjects.course_id', '=', 'courses.id')
                        ->join('users', 'courses.chairperson_id', '=', 'users.id')
                        ->where('subject_for_credits.student_id', $student_id)
                        ->select('users.*') // Include users.id in the SELECT statement
                        ->first();
                        
        Mail::to($chairperson->email)->send(new NotifyChairperson($chairperson));
        dd('Mail sent successfully');

    }
}
