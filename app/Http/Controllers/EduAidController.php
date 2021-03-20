<?php

namespace App\Http\Controllers;

use App\Models\edu_aid;
use App\Models\edu_institution;
use App\Models\token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EduAidController extends Controller
{
    public function update($id, Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        return view(
            'update_edu_aid',
            [
                'data' => edu_aid::all()->where('id', $id),
                'token' => $req->token
            ]
        );
    }
    public function delete($id, Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $edu_aid = edu_aid::find($id);
        if (isset($edu_aid->document)) Storage::delete(str_replace('storage/', 'public/', $edu_aid['document']));
        if (isset($edu_aid->title_image)) Storage::delete(str_replace('storage/', 'public/', $edu_aid['title_image']));
        $edu_aid->delete();
        return redirect()->route(
            'edu_aids',
            [
                'edu_aids' => edu_aid::all(),
                'token' => $req->token,
                'delete_success' => "Материал ID {$id} удален"
            ]
        );
    }

    public function create(Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $edu_aid = new edu_aid;
        $edu_institutions = new edu_institution;
        $flag = true;
        $req->input('name') ? $edu_aid->name = $req->input('name') : $flag = false;
        $req->input('authors') ? $edu_aid->authors = $req->input('authors') : $flag = false;
        $req->input('edu_institution') ? $edu_aid->edu_institution = $req->input('edu_institution') : $flag = false;
        $req->input('public_year') ? $edu_aid->public_year = $req->input('public_year') : $edu_aid->public_year = null;     
        $req->input('description') ? $edu_aid->description = $req->input('description') : $edu_aid->description = '';
        $req->input('number_of_pages') ? $edu_aid->number_of_pages  = $req->input('number_of_pages') : $edu_aid->number_of_pages = null;
        $create_success = "Материал не добавлен, поля \"Название\", \"Автор/Авторы\" и \"Учреждение обращования\" обязательны";
        if (!stristr(serialize($edu_institutions::select('name')->get()), $req->input('edu_institution'))) {
            $flag = false;
            $create_success = "Материал не добавлен. Учреждения образования не существует";
        }
        if ($req->file('document'))
        {
            $edu_aid->document = str_replace('public/', 'storage/', $req->file('document')->store('public/documents'));
        }
        else
        {
            $flag = false;
            $create_success = "Материал не добавлен. Загрузите файл";
        }
        if ($flag) {                   
            $edu_aid->title_image = $req->file('title_image') 
            ? str_replace('public/', 'storage/', $req->file('title_image')->store('public/title_images')) 
            : 'storage/title_images/no_image.png';
            $edu_aid->save();
            return redirect()->route(
                'edu_aids',
                [
                    'token' => $req->token,
                    'create_success' => 'Материал добавлен'
                ]
            );
        } else {
            return redirect()->route(
                'edu_aids',
                [
                    'token' => $req->token,
                    'create_success' => $create_success
                ]
            );
        }
    }

    public function submit($id, Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403); 
        $edu_aid = edu_aid::find($id);
        $edu_institutions = new edu_institution;
        $edu_aid->id = $id;        
        $update_success = 'Материал не обновлен. Присутствуют пустые поля';
        $flag = true;
        $req->input('name') ? $edu_aid->name = $req->input('name') : $flag = false;
        $req->input('authors') ? $edu_aid->authors = $req->input('authors') : $flag = false;
        $req->input('edu_institution') ? $edu_aid->edu_institution = $req->input('edu_institution') : $flag = false;
        $req->input('public_year') ? $edu_aid->public_year = $req->input('public_year') : $edu_aid->public_year = null;     
        $req->input('description') ? $edu_aid->description = $req->input('description') : $edu_aid->description = '';
        $req->input('number_of_pages') ? $edu_aid->number_of_pages  = $req->input('number_of_pages') : $edu_aid->number_of_pages = null;
        if (!stristr(serialize($edu_institutions::select('name')->get()), $req->input('edu_institution'))) {
            $flag = false;
            $update_success = "Материал не добавлен. Учреждения образования не существует";
        }
        if ($flag) {
            if ($req->file('document')) 
            {
                Storage::delete(str_replace('storage/', 'public/', $edu_aid['document']));
                $edu_aid->document = str_replace('public/', 'storage/', $req->file('document')->store('public/documents'));
            }
            if ($req->file('title_image')) 
            {                
                Storage::delete(str_replace('storage/', 'public/', $edu_aid['title_image']));
                $edu_aid->title_image = str_replace('public/', 'storage/', $req->file('title_image')->store('public/title_images'));
            }
            $edu_aid->save();
            #return redirect()->route('update_user', $id)->with('success', "Пользоватль обновлен");
            return view(
                'update_edu_aid',
                [
                    'id' => $id,
                    'data' => $edu_aid,
                    'token' => $req->token,
                    'success' => 'Материал обновлен'
                ]
            );
        } else {
            return view(
                'update_edu_aid',
                [
                    'id' => $id,
                    'data' => $edu_aid,
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
        $edu_aids = edu_aid::orderBy($req->input('field'), $req->input('order'))->simplePaginate(20)->appends(request()->except('page'));
        $edu_aids->token = $req->token;
        return view(
            'edu_aids',
            [
                'field' => $req->input('field'),
                'order' => $req->input('order'),
                'edu_aids' => $edu_aids
            ]
            );
    }

    public function search(Request $req)
    {
        $token_exists = token::find($req->token);
        if ($token_exists == [] or $token_exists->expire < (string)now() ) return abort(403);
        $edu_aids =  edu_aid::where($req->input('field'), 'LIKE', "%".$req->input('search_term')."%")->simplePaginate(20)->appends(request()->except('page'));
        $edu_aids->token = $req->token;
        return view(
            'edu_aids',
            [
                'field' => $req->input('field'),
                'search_term' => $req->input('search_term'),
                'edu_aids' => $edu_aids
            ]
            );
    }
}
