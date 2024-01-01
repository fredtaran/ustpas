<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticationController extends Controller
{
    // Login View
    public function login_view() {
        return view('login');
    }

    // Login Process
    public function login_authenticate(Request $request) {
        // Get the username and password form
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Attempt to check if the user does exist, and username and password is correct
        if(Auth::attempt($credentials)) {
            // Generate session
            $request->session()->regenerate();

            // Check user role and redirect to the appropriate page
            if(Auth::user()->role == 0) {

            } else if(Auth::user()->role == 1) {
                return redirect()->intended('/admission');
            } else if(Auth::user()->role == 2) {
                return redirect()->intended('/chairperson');
            }
        }

        // If the credentials is not correct, return error message
        return back()->withErrors([
            'username' => 'The provided credentials do not match our existing records.',
        ])->onlyInput('username');
    }

    // Logout process
    public function logout(Request $request) {
        Session::flush();
        Auth::logout();
        return redirect()->intended(route('login.view'));
    }
}
