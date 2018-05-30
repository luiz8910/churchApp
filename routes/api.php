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

//------------------------- Igrejas ------------------------------------------------------------------------------------

Route::get('/church-list', 'ChurchController@churchesApi')->middleware('cors');

//Route::get('/login/{email}/{password}/{church}', 'Auth\LoginController@loginApp');

//------------------------- Login ------------------------------------------------------------------------------------

Route::post('/login', 'Auth\LoginController@loginApp');

Route::any('/facebook/{church}/{app?}', 'Auth\RegisterController@preFbLogin');

Route::any('/google/{church}/{app?}', 'Auth\RegisterController@preGoogleLogin');

//------------------------- Eventos ------------------------------------------------------------------------------------

Route::get('/next-events/{qtde}/{church}', 'EventController@getEventsApi');

Route::get('/events-next-week/{church}', 'EventController@getNextWeekEvents');

Route::get('recent-events/{church}', 'EventController@recentEventsApp');

Route::get('/today-events/{id}/{visitor?}', 'EventController@eventsToday');

Route::get('/check-in/{id}/{person_id}/{visitor?}', 'EventController@checkInAPP');

Route::get('/is-check/{id}/{person_id}/{visitor?}', 'EventController@isCheckedApp');


//------------------------- Grupos -------------------------------------------------------------------------------------

Route::get('groups/{church}', 'GroupController@groupListApp');

Route::get('my-groups/{person_id}', 'GroupController@myGroupsApp');

Route::get('group-people/{group_id}', 'GroupController@groupPeopleApp');

Route::get('recent-groups/{church}', 'GroupController@recentGroupsApp');


//------------------------- Pessoas ------------------------------------------------------------------------------------

Route::get('/recent-people/{church}', 'PersonController@recentPeopleApp');

Route::post('/new-member/', 'PersonController@storeWaitingApprovalApp');

ROute::post('/store-person/', 'PersonController@storeApp');