<?php

namespace App\Http\Controllers;

use App\Models\edu_institution;
use App\Models\user;
use App\Models\edu_aid;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show()
    {
        return view(
            'admin',
            [
                'edu_institutions' => edu_institution::take(10)->get(),
                'users' => user::take(10)->get(),                
                'edu_aids' => edu_aid::take(10)->get()
            ]
        );
    }

    public function users($field='updated_at', $order='ASC')
    {
        $users = user::orderBy($field, $order)->simplePaginate(20);
        return view('users')->with('users', $users);
    } 

    public function edu_institutions($field='updated_at', $order='ASC')
    {
        $edu_institutions = edu_institution::orderBy($field, $order)->simplePaginate(20);
        return view('edu_institutions')->with('edu_institutions', $edu_institutions);
    } 

}
