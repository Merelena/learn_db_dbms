<?php

namespace App\Http\Controllers\api;

use Exception;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DBController extends Controller
{
    public function tables(Request $req)
    {
        DB::statement('USE `'.$req->email.'`;');
        $query = DB::select('SHOW TABLES');
        return response()->json($query);
    }

    public function columns(Request $req)
    {
        DB::statement('USE `'.$req->email.'`;');
        $query = DB::select('SHOW COLUMNS FROM '.$req->table);
        return response()->json($query);
    }

    public function query(Request $req)
    {
        DB::statement('USE `'.$req->email.'`;');
        $query = $req['query'];
        if ($this->verify_query($query, $req->email)) return response('Нет прав');
        try
        {
            $result = DB::select($query);
            return response()->json($result == [] ? 'OK' : $result);
        }
        catch (Exception $ex)
        {
            return response($ex->getMessage());
        }
    }
    
    protected function verify_query($query, $email)
    {
        $regexp = preg_replace("/.+`(.+)`\..+/", '$1', $query);
        if ($regexp != $email and $regexp != $query) return true;
        return preg_match('/\s(database|grant|revoke|deny|user)\s/ui', $query);
    }
}
