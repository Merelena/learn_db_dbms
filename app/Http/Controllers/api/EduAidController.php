<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\edu_aid;
use App\Models\edu_institution;
use Illuminate\Support\Facades\Storage;

class EduAidController extends Controller
{
    public function all()
    {
        return response()->json(edu_aid::all());
    }

    public function delete($id)
    {
        $edu_aid = edu_aid::find($id);
        
        if (isset($edu_aid->document)) Storage::delete(str_replace('storage/', 'public/', $edu_aid['document']));
        if (isset($edu_aid->title_image)) Storage::delete(str_replace('storage/', 'public/', $edu_aid['title_image']));
        if ($edu_aid)
        {
            $edu_aid->delete();
            return response()->json(['message' => 'Материал удален']);
        }
        else
        {
            return response()->json(['error' => 'Материала не существует'], 403);
        }        
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
            return response()->json(['message' => 'Материал добавлен']);
        }
        else {
            return response()->json(['error' => $create_success], 403);
        }
    }

    public function update($id, Request $req)
    {
        $edu_aid = edu_aid::find($id);
        $edu_aid->id = $id;
        $edu_institutions = new edu_institution;
        $flag = true;
        $update_success = 'Материал не обновлен. Присутствуют пустые поля';
        $req->input('name') ? $edu_aid->name = $req->input('name') : $flag = false;
        $req->input('authors') ? $edu_aid->authors = $req->input('authors') : $flag = false;
        $req->input('edu_institution') ? $edu_aid->edu_institution = $req->input('edu_institution') : $flag = false;
        $req->input('public_year') ? $edu_aid->public_year = $req->input('public_year') : $edu_aid->public_year = null;     
        $req->input('description') ? $edu_aid->description = $req->input('description') : $edu_aid->description = '';
        $req->input('number_of_pages') ? $edu_aid->number_of_pages  = $req->input('number_of_pages') : $edu_aid->number_of_pages = null;
        if (!stristr(serialize($edu_institutions::select('name')->get()), $req->input('edu_institution'))) {
            $flag = false;
            $update_success = "Материал не обновлен. Учреждения образования не существует";
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
            return response()->json(['message' => 'Материал обновлен']);
        } else {
            return response()->json(['error' => $update_success]);
        }
    }

    public function sort(Request $req)
    {
        return response()->json(['edu_aids' => edu_aid::orderBy($req->input('field'), $req->input('order'))]);
    }

    public function search(Request $req)
    {
        return response()->json(['edu_aids' => edu_aid::where($req->input('field'), 'LIKE', "%".$req->input('search_term')."%")->get()]);
    }
}
