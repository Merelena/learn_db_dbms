<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\edu_institution;
use App\Models\token;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update($id, Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $data = User::all()->where('id', $id);
        return view(
            'update_user',
            [
                'data' => $data,
                'token' => $req->token
            ]
        );
    }
    public function delete($id, Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $user = User::find($id);
        # exception exists only for test users without db
        try{
        DB::statement('drop database `'.$user->email.'`;');
        }
        catch (Exception) {}
        $user->delete();
        $users = User::all();
        return redirect()->route(
            'users',
            [
                'delete_success' => "Пользователь ID {$id} удален",
                'users' => $users,
                'token' => $req->token
            ]
        );
    }

    public function create(Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $user = new User;
        $edu_institutions = new edu_institution;
        $flag = true;
        $req->input('surname') ? $user->surname = $req->input('surname') : $flag = false;
        $req->input('first_name') ? $user->first_name = $req->input('first_name') : $flag = false;
        $req->input('middle_name') ? $user->middle_name = $req->input('middle_name') : $user->middle_name = '';
        $req->input('role') ? $user->role = $req->input('role') : $flag = false;
        $req->input('edu_institution') ? $user->edu_institution = $req->input('edu_institution') : $flag = false;
        $req->input('email') ? $user->email = $req->input('email') : $flag = false;
        $create_success = "Пользователь не добавлен, только поле Отчество может быть пустым!";
        if ($req->input('password_1') == $req->input('password_2') && $req->input('password_1')) {
            $user->password = bcrypt($req->input('password_1'));
        } else {
            $flag = false;
            $create_success = "Пользователь не добавлен, пароли не совпадают либо пусты";
        }
        if (!stristr(serialize($edu_institutions::select('name')->get()), $req->input('edu_institution'))) {
            $flag = false;
            $create_success = "Пользователь не добавлен. Учреждения образования не существует";
        }
        if (stristr(serialize($user::select('email')->get()), $req->input('email'))) {
            $flag = false;
            $create_success = "Пользователь не добавлен. Данный адрес электронной почты уже существует";
        }
        if ($flag) {
            $user->save();
            DB::statement('CREATE DATABASE `'.$user->email.'`;');
            return redirect()->route(
                'users',
                [
                    'create_success' => 'Пользователь добавлен',
                    'token' => $req->token
                ]
            );
        } else {
            return redirect()->route(
                'users',
                [
                    'create_success' => $create_success,
                    'token' => $req->token
                ]
            );
        }
    }

    public function submit($id, Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $user = User::find($id);
        $user->id = $id;
        $flag = true;
        $req->input('surname') ? $user->surname = $req->input('surname') : $flag = false;
        $req->input('first_name') ? $user->first_name = $req->input('first_name') : $flag = false;
        $req->input('middle_name') ? $user->middle_name = $req->input('middle_name') : $user->middle_name = '';
        $req->input('role') ? $user->role = $req->input('role') : $flag = false;
        $req->input('edu_institution') ? $user->edu_institution = $req->input('edu_institution') : $flag = false;
        $req->input('email') ? $user->email = $req->input('email') : $flag = false;
        if ($req->input('password')) $user->password = bcrypt($req->input('password'));
        if ($flag) {
            $user->save();
            #return redirect()->route('update_user', $id)->with('success', "Пользоватль обновлен");
            return view(
                'update_user',
                [
                    'id' => $id,
                    'data' => $user,
                    'token' => $req->token,
                    'success' => 'Пользователь обновлен'
                ]
            );
        } else {
            return view(
                'update_user',
                [
                    'id' => $id,
                    'data' => $user,
                    'token' => $req->token,
                    'success' => 'Пользователь не обновлен, только поле Отчество может быть пустым!'
                ]
            );
        }
    }

    public function sort(Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $users = User::orderBy($req->input('field'), $req->input('order'))->simplePaginate(20)->appends(request()->except('page'));
        $users->token = $req->token;
        return view(
            'users',
            [
                'field' => $req->input('field'),
                'order' => $req->input('order'),
                'users' => $users
            ]
            );
    }

    public function search(Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $users =  User::where($req->input('field'), 'LIKE', "%".$req->input('search_term')."%")->simplePaginate(20)->appends(request()->except('page'));
        $users->token = $req->token;
        return view(
            'users',
            [
                'field' => $req->input('field'),
                'search_term' => $req->input('search_term'),
                'users' => $users
            ]
            );
    }
}
