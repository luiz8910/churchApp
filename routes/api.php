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

Route::get('/recover-password/{email}', 'Auth\LoginController@recoverPasswordApp');

Route::get('/get-code/{code}', 'Auth\LoginController@getCode');

Route::get('/get-social-token/{token}', 'Auth\LoginController@getSocialToken');




//------------------------- Eventos ------------------------------------------------------------------------------------

Route::get('/next-events/{qtde}/{church}', 'Api\EventController@getEventsApi');

Route::get('/events-next-week/{church}', 'Api\EventController@getNextWeekEvents');

Route::get('recent-events/{church}', 'Api\EventController@recentEventsApp');

Route::get('/today-events/{id}/{visitor?}', 'Api\EventController@eventsToday');

Route::get('/getEventInfo/{id}', 'Api\EventController@getEventInfo');

Route::post('/store-event/{person_id}', 'Api\EventController@store');




//--------------------------- Check-in ---------------------------------------------------------------------------------

Route::get('/check-in/{id}/{person_id}/{visitor?}', 'Api\EventController@checkInAPP');

Route::get('/is-check/{id}/{person_id}/{visitor?}', 'Api\EventController@isCheckedApp');

Route::get('/checkout/{id}/{person_id}', 'Api\EventController@checkout');

Route::get('/getCheckinList/{id}', 'Api\EventController@getCheckinList');

Route::get('/event-list-sub/{id}', 'Api\EventController@getListSubEvent');

Route::get('/unsubscribe/{id}/{person_id}', 'Api\EventController@unsubUser');

Route::get('/sub/{id}/{person_id}', 'Api\EventController@sub');

Route::any('/checkin-all/', 'Api\EventController@checkInPeopleAPP');





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

Route::post('/store-person-social/', 'Api\PersonController@storeAppSocial');

Route::post('/change-password/', 'Api\PersonController@changePassword');


//------------------------- Expositores --------------------------------------------------------------------------------

//Lista de Todos os expositores
Route::get('/exhibitors', 'Api\ExhibitorsController@index');

//Lista de todos os expositores por categoria (pela id da categoria)
Route::get('/exhibitors-by-cat/{category}', 'Api\ExhibitorsController@listByCategory');

//Cadastro de Expositores
Route::post('/exhibitors', 'Api\ExhibitorsController@store');

//Alteração de Expositores
Route::put('/exhibitors/{id}', 'Api\ExhibitorsController@update');

//Exclusão de Expositores
Route::delete('/exhibitors/{id}', 'Api\ExhibitorsController@delete');



//------------------------ Categorias de Expositores -------------------------------------------------------------------

//Lista de todas as Categorias
Route::get('/exhibitors-categories', 'Api\ExhibitorsController@index_cat');

//Cadastro de Categoria
Route::post('/exhibitors-categories', 'Api\ExhibitorsController@store_cat');

//Alteração de Categoria
Route::put('/exhibitors-categories/{category}', 'Api\ExhibitorsController@update_cat');

//Exclusão de Categoria
Route::delete('/exhibitors-categories/{category}', 'Api\ExhibitorsController@delete_cat');




//------------------------ Patrocinadores ------------------------------------------------------------------------------

//Lista de Todos os Patrocinadores
Route::get('/sponsors', 'Api\SponsorController@index');

//Lista de todos os Patrocinadores por categoria (pela id da categoria)
Route::get('/sponsors-by-cat/{category}', 'Api\SponsorController@listByCategory');

//Cadastro de Patrocinadores
Route::post('/sponsors', 'Api\SponsorController@store');

//Alteração de Patrocinadores
Route::put('/sponsors/{id}', 'Api\SponsorController@update');

//Exclusão de Patrocinadores
Route::delete('/sponsors/{id}', 'Api\SponsorController@delete');



//------------------------ Categorias de Patrocinadores -------------------------------------------------------------------

//Lista de todas as Categorias
Route::get('/sponsors-categories', 'Api\SponsorController@index_cat');

//Cadastro de Categoria
Route::post('/sponsors-categories', 'Api\SponsorController@store_cat');

//Alteração de Categoria
Route::put('/sponsors-categories/{category}', 'Api\SponsorController@update_cat');

//Exclusão de Categoria
Route::delete('/sponsors-categories/{category}', 'Api\SponsorController@delete_cat');


//---------------------------------- Documentos ----------------------------------------------------------------

/*
 * Lista de todos os Documentos, se passado o parâmetro event_id,
 * então lista só do evento selecionado
 */
Route::get('/doc/{event_id?}', 'Api\DocumentsController@index');

// Realiza upload de um arquivo
Route::post('/doc-upload', 'Api\DocumentsController@upload');

//Realiza o download de um arquivo
Route::get('/doc-download/{id}', 'Api\DocumentsController@download');

//Realiza a exclusão de um arquivo
Route::delete('/doc/{file_id}/{person_id}', 'Api\DocumentsController@delete');

//Busca o arquivo pelo nome completo
Route::get('/doc-find/{name}', 'Api\DocumentsController@find');

//Busca o arquivo pelo nome no modo instant search
Route::get('/doc-search/{input}', 'Api\DocumentsController@search');


//-------------------------- Outros ------------------------------------------------------------------------------------

Route::any('/new-bug/', 'BugController@storeApp');