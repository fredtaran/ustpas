<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChairpersonController extends Controller
{
    public function dashboard(Request $request) {
        echo "Chairperson Controller";
    }
}
