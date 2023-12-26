<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    // Login View
    public function login_view() {
        return view('login');
    }

    // Login Process
    public function login_authenticate(Request $request) {
        // Get the username and password form 
    }
}
