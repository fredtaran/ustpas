<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AdmissionController;

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
Route::get('/login', [AuthenticationController::class, 'login_view'])->name('login.view');
Route::post('/login', [AuthenticationController::class, 'login_authenticate'])->name('login.authenticate');

// Admission Routes
Route::middleware(['auth', 'checkRoles: 1'])->prefix('admission')->group(function() {
    Route::get('', [AdmissionController::class, 'dashboard'])->name('admission.dashboard');
});