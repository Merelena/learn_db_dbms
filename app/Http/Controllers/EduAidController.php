<?php

namespace App\Http\Controllers;

use App\Models\edu_aid;
use App\Models\edu_institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EduAidController extends Controller
{
    public function update($id)
    {
        return view(
            'update_edu_aid',
            [
                'data' => edu_aid::all()->where('id', $id)
            ]
        );
    }
    public function delete($id)
    {
        $edu_aid = edu_aid::find($id);
        if (isset($edu_aid->document)) Storage::delete(str_replace('storage/', 'public/', $edu_aid['document']));
        if (isset($edu_aid->title_image)) Storage::delete(str_replace('storage/', 'public/', $edu_aid['title_image']));
        $edu_aid->delete();
        return redirect()->route(
            'edu_aids',
            [
                'edu_aids' => edu_aid::all(),
                'delete_success' => "Материал ID {$id} удален"
            ]
        );
    }

    public function create(Request $req)
    {
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
        if ($flag) {            
            $edu_aid->document = str_replace('public/', 'storage/', $req->file('document')->store('public/documents'));        
            $edu_aid->title_image = str_replace('public/', 'storage/', $req->file('title_image')->store('public/title_images'));
            $edu_aid->save();
            return redirect()->route(
                'edu_aids',
                [
                    'create_success' => 'Материал добавлен'
                ]
            );
        } else {
            return redirect()->route(
                'edu_aids',
                [
                    'create_success' => $create_success
                ]
            );
        }
    }

    public function submit($id, Request $req)
    {
        $edu_aid = edu_aid::find($id);
        $edu_aid->id = $id;
        $flag = true;
        $req->input('name') ? $edu_aid->name = $req->input('name') : $flag = false;
        $req->input('authors') ? $edu_aid->authors = $req->input('authors') : $flag = false;
        $req->input('edu_institution') ? $edu_aid->edu_institution = $req->input('edu_institution') : $flag = false;
        $req->input('public_year') ? $edu_aid->public_year = $req->input('public_year') : $edu_aid->public_year = null;     
        $req->input('description') ? $edu_aid->description = $req->input('description') : $edu_aid->description = '';
        $req->input('number_of_pages') ? $edu_aid->number_of_pages  = $req->input('number_of_pages') : $edu_aid->number_of_pages = null;
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
                    'success' => 'Материал обновлен'
                ]
            );
        } else {
            return view(
                'update_edu_aid',
                [
                    'id' => $id,
                    'data' => $edu_aid,
                    'success' => 'Материал не обновлен, поля "Название", "Автор/Авторы" и "УЧреждение образования"!'
                ]
            );
        }
    }

    public function sort(Request $req)
    {
        return view(
            'edu_aids',
            [
                'field' => $req->input('field'),
                'order' => $req->input('order'),
                'edu_aids' => edu_aid::orderBy($req->input('field'), $req->input('order'))->paginate(20)
            ]
            );
    }

    public function search(Request $req)
    {
        return view(
            'edu_aids',
            [
                'field' => $req->input('field'),
                'search_term' => $req->input('search_term'),
                'edu_aids' => edu_aid::where($req->input('field'), 'LIKE', "%".$req->input('search_term')."%")->paginate(20)
            ]
            );
    }
}
