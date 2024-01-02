<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ChairpersonController;

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
    Route::get('/course_list', [AdmissionController::class, 'courses_table'])->name('admission.course_list');
    Route::delete('/courses/{id}', [AdmissionController::class, 'delete_course'])->name('admission.delete_course');
    Route::get('/courses/{id}', [AdmissionController::class, 'get_course'])->name('admission.get_course');
    Route::post('/courses/{id}/edit', [AdmissionController::class, 'update_course'])->name('admission.update_course');

    // Subject
    Route::get('/subjects', [AdmissionController::class, 'subjects'])->name('admission.subjects');
});

// Program Chairperson Routes
Route::middleware(['auth', 'checkRoles:2'])->prefix('chairperson')->group(function() {
    Route::get('', [ChairpersonController::class, 'dashboard'])->name('chairperson.dashboard');
});