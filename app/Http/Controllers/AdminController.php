<?php

namespace App\Http\Controllers;
use App\Models\edu_institution;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function response() {
        return view('admin', ['edu_institutions' => edu_institution::all()]);
    }
}
