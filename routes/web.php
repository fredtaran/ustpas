<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ChairpersonController;
use App\Http\Controllers\TrackerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Routes
Route::middleware(['guest'])->get('/', [TrackerController::class, 'landing_page'])->name('tracker.landing_page');
Route::middleware(['guest'])->get('/get_status/{code}', [TrackerController::class, 'get_accredited_subjects'])->name('tracker.get_accredited_subjects');
Route::middleware(['guest'])->get('/generate_pdf/{code}', [TrackerController::class, 'generate_pdf'])->name('tracker.generate_pdf');
Route::middleware(['guest'])->get('/login', [AuthenticationController::class, 'login_view'])->name('login.view');
Route::middleware(['guest'])->post('/login', [AuthenticationController::class, 'login_authenticate'])->name('login.authenticate');
Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

// Admission Routes
Route::middleware(['auth', 'checkRoles:1'])->prefix('admission')->group(function() {
    // Dashboard
    Route::get('', [AdmissionController::class, 'dashboard'])->name('admission.dashboard');

    // Course
    Route::get('/courses', [AdmissionController::class, 'courses'])->name('admission.courses_view');
    Route::post('/courses', [AdmissionController::class, 'save_course'])->name('admission.save_course');
    Route::delete('/courses/{id}', [AdmissionController::class, 'delete_course'])->name('admission.delete_course');
    Route::post('/courses/{id}/edit', [AdmissionController::class, 'update_course'])->name('admission.update_course');
    Route::get('/course/{id}', [AdmissionController::class, 'course_detail'])->name('admission.course_detail');

    // Use by datatable - return json
    Route::get('/course_list', [AdmissionController::class, 'courses_table'])->name('admission.course_list');

    // Use by update  modal - return json
    Route::get('/courses/{id}', [AdmissionController::class, 'get_course'])->name('admission.get_course');

    // Subject
    Route::post('/subjects', [AdmissionController::class, 'save_subject'])->name('admission.save_subject');
    Route::get('/subjects/{id}', [AdmissionController::class, 'get_subjects'])->name('admission.get_subjects');
    Route::delete('/subject/{id}', [AdmissionController::class, 'delete_subject'])->name('admission.delete_subject');
    Route::get('/subject/{id}', [AdmissionController::class, 'get_subject'])->name('admission.get_subject');
    Route::post('/subject/{id}/edit', [AdmissionController::class, 'update_subject'])->name('admission.update_subject');

    // Student
    Route::get('/students', [AdmissionController::class, 'students_view'])->name('admission.students_view');
    Route::get('/students/list', [AdmissionController::class, 'get_student'])->name('admission.get_student');
    Route::get('/add_student', [AdmissionController::class, 'add_student_view'])->name('admission.add_student_view');
    Route::post('/add_student', [AdmissionController::class, 'add_student'])->name('admission.add_student');
    Route::delete('/student/{id}', [AdmissionController::class, 'delete_student'])->name('admission.delete_student');
    Route::get('/student/{id}', [AdmissionController::class, 'edit_student'])->name('admission.edit_student_view');
    Route::post('/student/{id}/edit', [AdmissionController::class, 'save_student_changes'])->name('admission.save_student_changes');
    Route::get('/student/{id}/details', [AdmissionController::class, 'student_details'])->name('admission.student_details');
    Route::post('/save_tor', [AdmissionController::class, 'save_tor'])->name('admission.save_tor');
    Route::get('/get_tors/{id}', [AdmissionController::class, 'get_tors'])->name('admission.get_tors');
    Route::delete('/tor/{id}', [AdmissionController::class, 'delete_tor'])->name('admission.delete_tor');
    Route::get('/tor/{student_id}/{tor_id}', [AdmissionController::class, 'map_data'])->name('admission.map_data');
    Route::get('/subjects_for_credit/{student_id}', [AdmissionController::class, 'get_subject_for_credit'])->name('admission.get_subject_for_credit');
});

// Program Chairperson Routes
Route::middleware(['auth', 'checkRoles:2'])->prefix('chairperson')->group(function() {
    Route::get('', [ChairpersonController::class, 'dashboard'])->name('chairperson.dashboard');
    Route::get('/students', [ChairpersonController::class, 'get_students'])->name('chairperson.get_students');
    Route::get('/student/{student_id}', [ChairpersonController::class, 'get_student'])->name('chairperson.get_student');
    Route::get('/student/{student_id}/subjects', [ChairpersonController::class, 'get_subjects_for_accreditation'])->name('chairperson.get_subjects_for_accreditation');
    Route::put('/accredit/{accreditation_id}/{status}', [ChairpersonController::class, 'update_status'])->name('chairperson.update_status');
});