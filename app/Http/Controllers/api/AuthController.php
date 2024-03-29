<?php

namespace App\Http\Controllers\api;
use App\Models\User;
use App\Models\edu_institution;
use App\Models\token;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $expires_in = 24 * 60;
        $this->guard()->factory()->setTTL($expires_in);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $array = $validator->validated();
        if (! $token = $this->guard()->attempt($array)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /*public function register(Request $req) {
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
        if(!$flag){
            return response()->json(['success' => $create_success], 403);
        }

        DB::statement('create database `'.$user->email.'`;');
        $user->save();

        return response()->json([
            'message' => 'Пользователь зарегистрирован',
            'user' => $user
        ], 201);
    }*/


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        $this->guard()->logout();
        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $token_db = new token;
        $token_db->find($token)->delete();
        return response()->json(['message' => 'Пользователь вышел из аккаунта']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken($this->guard()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        return response()->json($this->guard()->user());
    }

    public function role() {
        $status = $this->guard()->check();
        $role = $status == true ? $this->guard()->user()['role'] : null;
        return response()->json(['role' => $role]);
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        $token_db = new token;
        $token_exists = token::find("Bearer $token");
        if ($token_exists == [])
        {
            $token_db->token = "Bearer $token";
            $token_db->expire = date("Y-m-d h:m:s", strtotime("+ 86400 seconds"));
            $token_db->save();
        }
        else
        {
            if ($token_exists->expire < (string)now()) $token_exists->delete();
        }
        
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
