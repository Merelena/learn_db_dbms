<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user;
use App\Models\edu_institution;
use Illuminate\Support\Facades\DB;

class ApiUserController extends Controller
{
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
        $success = "Пользователь не добавлен, только поле Отчество может быть пустым!";
        if ($req->input('password_1') == $req->input('password_2') && $req->input('password_1')) {
            $user->password = $req->input('password_1');
        } else {
            $flag = false;
            $success = "Пользователь не добавлен, пароли не совпадают либо пусты";
        }
        if (!stristr(serialize($edu_institutions::select('name')->get()), $req->input('edu_institution'))) {
            $flag = false;
            $success = "Пользователь не добавлен. Учреждения образования не существует";
        }
        if (stristr(serialize($user::select('email')->get()), $req->input('email'))) {
            $flag = false;
            $success = "Пользователь не добавлен. Данный адрес электронной почты уже существует";
        }
        if ($flag) {
            $user->save();
            DB::statement('create database `'.$user->email.'`;');
            return ['success' => 'OK'];
        } else {
            return ['success' => $success];
        }
    }

    function login(Request $req)
    {
        $users = new User();
        $user = user::where('email', '=', $req->input('email'))->first();
        if (isset($user))
        {
            $email = $user->email;
            $password = $user->password;
        }       
        if (isset($email) and $password == $req->input('password'))
        {
            $_SESSION['user_id'] = $user->id;
            $url = str_replace($_SERVER['HTTP_ORIGIN'], '', $_SERVER['HTTP_REFERER']);
            header("Location: $url");
            http_response_code(200);
            return true;
        }
        http_response_code(400);
        return false;
    }

    function logout(Request $req)
    {
        session_unset();
    }

    function check_login()
    {
        dd(isset($_SESSION));
        return isset($_SESSION['user_id']);
    }

    function generateFormHash($salt)
    {
        $hash = md5(mt_rand(1,1000000) . $salt);
        $_SESSION['csrf_hash'] = $hash;
        return $hash;
    }

    function isValidFormHash($hash)
    {
        return $_SESSION['csrf_hash'] === $hash;
    }
}
