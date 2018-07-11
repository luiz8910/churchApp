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

Route::get('/recover-password/{person_id}', 'Auth\LoginController@recoverPasswordApp');

Route::get('/get-code/{code}', 'Auth\LoginController@getCode');

//------------------------- Eventos ------------------------------------------------------------------------------------

Route::get('/next-events/{qtde}/{church}', 'Api\EventController@getEventsApi');

Route::get('/events-next-week/{church}', 'Api\EventController@getNextWeekEvents');

Route::get('recent-events/{church}', 'Api\EventController@recentEventsApp');

Route::get('/today-events/{id}/{visitor?}', 'Api\EventController@eventsToday');

Route::get('/check-in/{id}/{person_id}/{visitor?}', 'Api\EventController@checkInAPP');

Route::get('/is-check/{id}/{person_id}/{visitor?}', 'Api\EventController@isCheckedApp');

Route::get('/getEventInfo/{id}', 'Api\EventController@getEventInfo');

Route::get('/checkout/{id}/{person_id}', 'Api\EventController@checkout');

Route::get('/getCheckinList/{id}', 'Api\EventController@getCheckinList');

Route::post('/store-event/{person_id}', 'Api\EventController@store');

Route::get('/event-list-sub/{id}', 'Api\EventController@getListSubEvent');

Route::get('/unsubscribe/{id}/{person_id}', 'Api\EventController@unsubUser');

Route::get('/sub/{id}/{person_id}', 'Api\EventController@sub');

Route::post('/checkin-all/', 'Api\EventController@checkInPeopleAPP');






//------------------------- Grupos -------------------------------------------------------------------------------------

Route::get('groups/{church}', 'Api\GroupController@groupListApp');

Route::get('my-groups/{person_id}', 'Api\GroupController@myGroupsApp');

Route::get('group-people/{group_id}', 'Api\GroupController@groupPeopleApp');

Route::get('recent-groups/{church}', 'Api\GroupController@recentGroupsApp');

Route::get('getGroupInfo/{id}', 'Api\GroupController@getGroupInfo');





//------------------------- Pessoas ------------------------------------------------------------------------------------

Route::get('/recent-people/{church}', 'Api\PersonController@recentPeopleApp');

Route::post('/new-member/', 'Api\PersonController@storeWaitingApprovalApp');

Route::post('/store-person/', 'Api\PersonController@storeApp');

Route::post('/change-password/', 'Api\PersonController@changePassword');