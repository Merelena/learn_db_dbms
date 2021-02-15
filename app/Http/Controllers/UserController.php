<?php

namespace App\Http\Controllers;
use App\Models\user;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update($id)
    {
        view(
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
}
