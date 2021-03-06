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

Route::post('login', 'UserController@login'); //do login
Route::post('register', 'UserController@register');


Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('login/check', "UserController@LoginCheck"); //cek token
    Route::post('logout', "UserController@logout"); //cek token
	Route::post('daily', 'DailyScrumController@store'); 
    Route::delete('daily/{id}', "DailyScrumController@delete"); 
    // Route::get('daily', "DailyScrumController@index"); 
    Route::get('dailyscrum/{limit}/{offset}/{id_users}', "DailyScrumController@getAll");




});
