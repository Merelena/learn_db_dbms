<?php

namespace App\Http\Controllers;

use App\Models\edu_institution;
use App\Models\user;
use App\Models\edu_aid;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show()
    {
        if (!$this->isAdmin()) return abort(403);
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
        if (!$this->isAdmin()) return abort(403);
        $users = user::orderBy($field, $order)->simplePaginate(20);
        return view('users')->with('users', $users);
    } 

    public function edu_institutions($field='updated_at', $order='ASC')
    {
        if (!$this->isAdmin()) return abort(403);
        $edu_institutions = edu_institution::orderBy($field, $order)->simplePaginate(20);
        return view('edu_institutions')->with('edu_institutions', $edu_institutions);
    } 

    public function edu_aids($field='updated_at', $order='ASC')
    {
        if (!$this->isAdmin()) return abort(403);
        $edu_aids = edu_aid::orderBy($field, $order)->simplePaginate(20);
        return view('edu_aids')->with('edu_aids', $edu_aids);
    }

    protected function isAdmin()
    {
        return isset(auth::user()->role) ? auth::user()->role == 'Администратор' : false;
    }
}
