<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\edu_institution;

class EduInstitutionController extends Controller
{
    public function update($name)
    {
        return view(
            'update_edu_institution',
            [
                'edu_institutions' => edu_institution::find($name)
            ]
        );
    }
    public function delete($name)
    {
        $edu_institution = edu_institution::find($name)->delete();
        return redirect()->route(
            'edu_institutions',
            [
                'edu_institutions' => edu_institution::all(),
                'delete_success' => "Учреждение образования под названием \"{$name}\" удалено"
            ]
        );
    }

    public function create(Request $req)
    {
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
                    'create_success' => 'Учреждение образования добавлено'
                ]
            );
        } else {
            return redirect()->route(
                'edu_institutions',
                [
                    'create_success' => $create_success
                ]
            );
        }
    }

    public function submit($name, Request $req)
    {
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
                    'success' => 'Учреждение образования обновлено'
                ]
            );
        } else {
            return view(
                'update_edu_institution',
                [
                    'name' => $name,
                    'data' => $edu_institutions,
                    'success' => $update_success
                ]
            );
        }
    }

    public function sort(Request $req)
    {
        return view(
            'edu_institutions',
            [
                'field' => $req->input('field'),
                'order' => $req->input('order'),
                'edu_institutions' => edu_institution::orderBy($req->input('field'), $req->input('order'))->paginate(20)
            ]
        );
    }

    public function search(Request $req)
    {
        return view(
            'edu_institutions',
            [
                'field' => $req->input('field'),
                'search_term' => $req->input('search_term'),
                'edu_institutions' => edu_institution::where($req->input('field'), 'LIKE', $req->input('search_term'))->paginate(20)
            ]
        );
    }
}
