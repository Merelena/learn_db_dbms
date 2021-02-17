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
Route::post('/admin/users/{id}/delete', 'UserController@delete')->name('delete_user');
Route::post('/admin/users/create', 'UserController@create')->name('create_user');
Route::post('/admin/users/sort', 'UserController@sort')->name('sort_users');
Route::post('/admin/users/search', 'UserController@search')->name('search_users');

Route::get('/admin/edu_institutions', 'AdminController@edu_institutions')->name('edu_institutions');
Route::get('/admin/edu_institutions/create', 'AdminController@create')->name('create_edu_institution');
Route::get('/admin/edu_institutions/{name}/update', 'EduInstitutionController@update')->name('update_edu_institution');
Route::post('/admin/edu_institutions/{name}/update', 'EduInstitutionController@submit')->name('update_edu_institution_submit');
Route::get('/admin/edu_institutions/{name}/delete', 'EduInstitutionController@delete');
Route::post('/admin/edu_institutions/{name}/delete', 'EduInstitutionController@delete')->name('delete_edu_institution');
Route::post('/admin/edu_institutions/create', 'EduInstitutionController@create')->name('create_edu_institution');
Route::post('/admin/edu_institutions/sort', 'EduInstitutionController@sort')->name('sort_edu_institutions');
Route::post('/admin/edu_institutions/search', 'EduInstitutionController@search')->name('search_edu_institutions');


