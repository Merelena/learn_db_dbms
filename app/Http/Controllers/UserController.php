<?php

namespace App\Http\Controllers;
use App\Models\user;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update($id)
    {
        return view(
            'update_user',
            [
                'data'=> user::all()->where('id', $id)
            ]
        );
    }
    public function delete($id)
    {
        return "deleted";
    }

    public function create($id)
    {
        return "created";
    }

    public function submit($id, Request $req)
    {
        $user = user::find($id);        
        $user->id = $id;
        $flag = true;
        $req->input('surname') ? $user->surname = $req->input('surname') : $flag = false;
        $req->input('first_name') ? $user->first_name = $req->input('first_name') : $flag = false;
        $req->input('middle_name') ? $user->middle_name = $req->input('middle_name') : $user->middle_name = '';
        $req->input('role') ? $user->role = $req->input('role') : $flag = false;
        $req->input('edu_institution') ? $user->edu_institution = $req->input('edu_institution') : $flag = false;
        $req->input('email') ? $user->email = $req->input('email') : $flag = false;
        $req->input('password') ? $user->password = $req->input('password') : $flag = false;
        if ($flag)
        {
            $user->save();
            #return redirect()->route('update_user', $id)->with('success', "Пользоватль обновлен");
            return view(
                'update_user',
                [
                    'id' => $id,
                    'data' => $user,
                    'success' => 'Пользователь обновлен'
                ]
                );
        }
        else
        {
            return view(
                'update_user',
                [
                    'id' => $id,
                    'data' => $user,
                    'success' => 'Пользователь не обновлен, только поле Отчество может быть пустым!'
                ]
                );
        }
    }
}
