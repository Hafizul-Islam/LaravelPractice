<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Like route
Route::get('post','PostController@index');
Route::get('post/{slug?}','PostController@show')->name('post');
Route::post('/like','PostController@getlike');
Route::post('/like/{id}','PostController@like');

//filter 
Route::get('showpost','FilterController@index');
Route::post('showpost','FilterController@getpost');

//Crud with Ajax
Route::get('contacts','Controllers\AjaxCrudController@index');
Route::get('contacts/data','Controllers\AjaxCrudController@getcontactlist');
Route::post('contacts/store','Controllers\AjaxCrudController@store');
Route::post('contacts/update','Controllers\AjaxCrudController@update');
Route::post('contacts/delete','Controllers\AjaxCrudController@destroy');