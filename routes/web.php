<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', 'AdminController@show')->name('admin');
Route::get('/admin/users', 'AdminController@users')->name('users');
Route::get('/admin/users/create', 'AdminController@create')->name('create_user');

Route::get('/admin/users/{id}/update', 'UserController@update')->name('update_user');
Route::post('/admin/users/{id}/update', 'UserController@submit')->name('update_user_submit');

Route::get('/admin/users/{id}/delete', 'UserController@delete');

