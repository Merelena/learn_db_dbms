<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\edu_institution;
use App\Models\token;
use Illuminate\Support\Facades\Auth;

class EduInstitutionController extends Controller
{
    public function update($name, Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        return view(
            'update_edu_institution',
            [
                'data' => edu_institution::find($name),
                'token' => $req->token
            ]
        );
    }
    public function delete($name, Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $edu_institution = edu_institution::find($name)->delete();
        return redirect()->route(
            'edu_institutions',
            [
                'edu_institutions' => edu_institution::all(),
                'token' => $req->token,
                'delete_success' => "Учреждение образования под названием \"{$name}\" удалено"
            ]
        );
    }

    public function create(Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $edu_institutions = new edu_institution;
        $flag = true;
        $req->input('name') ? $edu_institutions->name = $req->input('name') : $flag = false;
        $req->input('city') ? $edu_institutions->city = $req->input('city') : $flag = false;
        $create_success = "Учреждение образования не добавлено, не все значения заполнены";
        if (stristr(serialize($edu_institutions::select('name')->get()), $req->input('name'))) {
            $flag = false;
            $create_success = "Данное учреждение образования уже существует";
        }
        if ($flag) {
            $edu_institutions->save();
            return redirect()->route(
                'edu_institutions',
                [
                    'token' => $req->token,
                    'create_success' => 'Учреждение образования добавлено'
                ]
            );
        } else {
            return redirect()->route(
                'edu_institutions',
                [
                    'token' => $req->token,
                    'create_success' => $create_success
                ]
            );
        }
    }

    public function submit($name, Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $edu_institutions = edu_institution::find($name);
        $old_name = $edu_institutions->name;
        $flag = true;
        $req->input('name') ? $edu_institutions->name = $req->input('name') : $flag = false;
        $req->input('city') ? $edu_institutions->city = $req->input('city') : $flag = false;
        $update_success = 'Учреждение образования не обновлено. Присутствуют пустые значения';
        if (stristr(serialize($edu_institutions::select('name')->get()), $req->input('name')) && $req->input('name') != $old_name) {
            $flag = false;
            $update_success = "Учреждение образования с таким названием уже существует";
        }
        if ($flag) {
            $edu_institutions->save();
            #return redirect()->route('update_user', $id)->with('success', "Пользоватль обновлен");
            return view(
                'update_edu_institution',
                [
                    'name' => $name,
                    'data' => $edu_institutions,
                    'token' => $req->token,
                    'success' => 'Учреждение образования обновлено'
                ]
            );
        } else {
            return view(
                'update_edu_institution',
                [
                    'name' => $name,
                    'data' => $edu_institutions,
                    'token' => $req->token,
                    'success' => $update_success
                ]
            );
        }
    }

    public function sort(Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $edu_institutions = edu_institution::orderBy($req->input('field'), $req->input('order'))->simplePaginate(10)->appends(request()->except('page'));
        $edu_institutions->token = $req->token;
        return view(
            'edu_institutions',
            [
                'field' => $req->input('field'),
                'order' => $req->input('order'),
                'edu_institutions' => $edu_institutions
            ]
        );
    }

    public function search(Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $edu_institutions = edu_institution::where($req->input('field'), 'LIKE', "%".$req->input('search_term')."%")->simplePaginate(20)->appends(request()->except('page'));
        $edu_institutions->token = $req->token;
        return view(
            'edu_institutions',
            [
                'field' => $req->input('field'),
                'search_term' => $req->input('search_term'),
                'edu_institutions' => $edu_institutions
            ]
        );
    }
}
