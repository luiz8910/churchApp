<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/church', function (){
    return Auth::user()->church_id;
})->middleware('auth:api');

Route::get('/log', function (){
    return 'token valido';
})->middleware('jwt.auth');

Route::get('/church-list', 'ChurchController@churchesApi');

//Route::get('/login/{email}/{password}/{church}', 'Auth\LoginController@loginApp');

Route::post('/login', 'Auth\LoginController@loginApp');