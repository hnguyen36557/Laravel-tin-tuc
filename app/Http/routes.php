<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('admin/login','Admin\AuthController@getLogin');
Route::post('admin/login','Admin\AuthController@postLogin');

Route::get('admin','Admin\AdminController@getIndex');
Route::controller('admin','Admin\AdminController');
// Route::auth();

Route::get('/home', 'HomeController@index');


