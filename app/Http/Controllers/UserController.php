<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\edu_institution;
use Exception;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update($id)
    {
        return view(
            'update_user',
            [
                'data' => user::all()->where('id', $id)
            ]
        );
    }
    public function delete($id)
    {
        $user = user::find($id);
        # exception exists only for test users without db
        try{
        DB::statement('drop database `'.$user->email.'`;');
        }
        catch (Exception) {}
        $user->delete();
        return redirect()->route(
            'users',
            [
                'users' => user::all(),
                'delete_success' => "Пользователь ID {$id} удален"
            ]
        );
    }

    public function create(Request $req)
    {
        $user = new user;
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
            $user->password = $req->input('password_1');
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
                    'create_success' => 'Пользователь добавлен'
                ]
            );
        } else {
            return redirect()->route(
                'users',
                [
                    'create_success' => $create_success
                ]
            );
        }
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
        if ($flag) {
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
        } else {
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

    public function sort(Request $req)
    {
        return view(
            'users',
            [
                'field' => $req->input('field'),
                'order' => $req->input('order'),
                'users' => user::orderBy($req->input('field'), $req->input('order'))->paginate(20)
            ]
            );
    }

    public function search(Request $req)
    {
        return view(
            'users',
            [
                'field' => $req->input('field'),
                'search_term' => $req->input('search_term'),
                'users' => user::where($req->input('field'), 'LIKE', "%".$req->input('search_term')."%")->paginate(20)
            ]
            );
    }
}
