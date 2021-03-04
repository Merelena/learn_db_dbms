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
    Route::post('login', 'AuthController@login')->name('login'); //creds
    Route::post('registration', 'AuthController@register');
    Route::post('logout', 'AuthController@logout')->name('logout'); //token with bearer
    Route::post('refresh', 'AuthController@refresh'); //token with bearer
    Route::get('me', 'AuthController@me'); //token with bearer
    Route::get('role', 'AuthController@role'); //token with bearer
});

