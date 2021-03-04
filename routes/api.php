<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'api\AuthController@login')->name('login'); //creds
    Route::post('registration', 'api\AuthController@register');
    Route::post('logout', 'api\AuthController@logout')->name('logout'); //token with bearer
    Route::post('refresh', 'api\AuthController@refresh'); //token with bearer
    Route::get('me', 'api\AuthController@me'); //token with bearer
    Route::get('role', 'api\AuthController@role'); //token with bearer
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'aids'
], function ($router) {
    Route::get('all', 'api\EduAidController@all');
    Route::get('create', 'api\EduAidController@create');
});

