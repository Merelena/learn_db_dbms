<?php

namespace App\Http\Controllers\api;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DBController extends Controller
{

    public function tables()
    {
        if (!$this->guard()->check()) return response()->json(['error' => 'Unauthorized'], 401);
        DB::statement('USE `'.$this->guard()->user()->email.'`;');
        $result = DB::select('SHOW TABLES');
        return response()->json($result);
    }

    public function columns(Request $req)
    {
        if (!$this->guard()->check()) return response()->json(['error' => 'Unauthorized'], 401);
        DB::statement('USE `'.$this->guard()->user()->email.'`;');
        $result = DB::select('SHOW COLUMNS FROM '.$req->table);
        return response()->json($result);
    }

    public function query(Request $req)
    {
        if (!$this->guard()->check()) return response()->json(['error' => 'Unauthorized'], 401);
        DB::statement('USE `'.$this->guard()->user()->email.'`;');
        $query = $req['query'];
        if ($this->verify_query($query)) return response('Нет прав');
        try
        {
            $result = DB::select($query);
            return response()->json(['message' => $result == [] ? 'OK' : $result]);
        }
        catch (Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
    
    protected function verify_query($query)
    {
        $regexp = preg_replace("/.+`(.+)`\..+/", '$1', $query);
        if ($regexp != $this->guard()->user()->email and $regexp != $query) return true;
        return preg_match("/(\sdatabase\s|\sdatabases|grant\s|revoke\s|deny\s|\suser\s|use\s)/ui", $query);
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
