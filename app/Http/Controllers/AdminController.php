<?php

namespace App\Http\Controllers;

use App\Models\edu_institution;
use App\Models\User;
use App\Models\edu_aid;
use App\Models\token;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show(Request $req)
    {                
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) $token = $_SERVER['HTTP_AUTHORIZATION'];
        if (isset($token))
        {
           if (!$this->isAdmin()) return abort(403);
        }
        else
        {
           $token = $req->token;
        }
        $token_db = token::find($token);
        if ($token_db == []) $token_db->token = $token;
        $token_db->expire = date("Y-m-d h:m:s", strtotime("+ 86400 seconds"));
        $token_db->save();
        return view(
            'admin',
            [
                'edu_institutions' => edu_institution::take(10)->get(),
                'users' => User::take(10)->get(),                
                'edu_aids' => edu_aid::take(10)->get(),
                'token' => $token
            ]
        );
    }

    public function users(Request $req, $field='updated_at', $order='ASC')
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $users = User::orderBy($field, $order)->simplePaginate(20)->appends(request()->except('page'));
        $users->token = $req->token;
        return view('users')->with('users', $users);
    } 

    public function edu_institutions(Request $req, $field='updated_at', $order='ASC')
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $edu_institutions = edu_institution::orderBy($field, $order)->simplePaginate(20)->appends(request()->except('page'));
        $edu_institutions->token = $req->token;
        return view('edu_institutions')->with('edu_institutions', $edu_institutions);
    } 

    public function edu_aids(Request $req, $field='updated_at', $order='ASC')
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $edu_aids = edu_aid::orderBy($field, $order)->simplePaginate(20)->appends(request()->except('page'));
        $edu_aids->token = $req->token;
        return view('edu_aids')->with('edu_aids', $edu_aids);
    }
}
