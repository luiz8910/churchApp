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

//------------------------- Orgs ------------------------------------------------------------------------------------

Route::get('/church-list', 'ChurchController@churchesApi')->middleware('cors');

//Route::get('/login/{email}/{password}/{church}', 'Auth\LoginController@loginApp');




//------------------------- Login --------------------------------------------------------------------------------------

Route::post('/login', 'Auth\LoginController@loginApp');

Route::any('/facebook/{church}/{app?}', 'Auth\RegisterController@preFbLogin');

Route::any('/google/{church}/{app?}', 'Auth\RegisterController@preGoogleLogin');

Route::get('/recover-password/{email}', 'Auth\LoginController@recoverPasswordApp');

Route::get('/get-code/{code}', 'Auth\LoginController@getCode');

Route::get('/get-social-token/{token}', 'Auth\LoginController@getSocialToken');

Route::post('/new-password', 'Auth\LoginController@newPassword');

Route::get('/getUserRoleByEmail/{email?}', 'Auth\LoginController@getUserRoleByEmail');




//------------------------- Eventos ------------------------------------------------------------------------------------

Route::get('/next-events/{qtde}/{church}', 'Api\EventController@getEventsApi');

Route::get('/events-next-week/{church}', 'Api\EventController@getNextWeekEvents');

Route::get('recent-events/{church}', 'Api\EventController@recentEventsApp');

Route::get('/today-events/{id}/{visitor?}', 'Api\EventController@eventsToday');

Route::get('/getEventInfo/{id}', 'Api\EventController@getEventInfo');

Route::post('/store-event/{person_id}', 'Api\EventController@store');

Route::get('/search-events/{input}', 'Api\EventController@searchEvents');

Route::get('/old-events/{church_id?}', 'Api\EventController@oldEvents');

Route::get('/person-subs/{person_id}/{church_id?}', 'Api\EventController@personSubs');

Route::put('/change-notif-activity', 'Api\EventController@changeNotifyActivity');

Route::put('/change-notif-updates', 'Api\EventController@changeNotifyUpdates');

Route::get('/notif-activity/{person_id}/{event_id}', 'Api\EventController@getNotifyActivity');

Route::get('/notif-updates/{person_id}/{event_id}', 'Api\EventController@getNotifyUpdates');




//--------------------------- Check-in ---------------------------------------------------------------------------------

Route::get('/check-in/{id}/{person_id}', 'Api\EventController@checkInAPP');

Route::get('/is-check/{id}/{person_id}/{visitor?}', 'Api\EventController@isCheckedApp');

Route::get('/checkout/{id}/{person_id}', 'Api\EventController@checkout');

Route::get('/getCheckinList/{id}', 'Api\EventController@getCheckinList');

Route::get('/event-list-sub/{id}', 'Api\EventController@getListSubEvent');

Route::get('/unsubscribe/{id}/{person_id}', 'Api\EventController@unsubUser');

Route::get('/sub/{id}/{person_id}', 'Api\EventController@sub');

Route::any('/checkin-all/', 'Api\EventController@checkInPeopleAPP');

Route::get('/is-sub/{event_id}/{person_id}', 'Api\EventController@isSub');

//Check-in em Sessões
Route::post('/checkin-session', 'Api\SessionController@add_check_in');

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

Route::get('/visibility-permissions/{person_id}', 'Api\PersonController@getVisibilityPermissions');

Route::put('/change-visibility-permissions/', 'Api\PersonController@changeVisibilityPermissions');

Route::get('qrcode/{person_id}', 'Api\PersonController@qrcode');

Route::post('update-person/{person_id}', 'Api\PersonController@update');


//------------------------- Expositores --------------------------------------------------------------------------------

//Lista de Todos os expositores
Route::get('/exhibitors/{event_id?}', 'Api\ExhibitorsController@index');

//Lista de todos os expositores por categoria (pela id da categoria)
Route::get('/exhibitors-by-cat/{category}', 'Api\ExhibitorsController@listByCategory');

//Cadastro de Expositores
Route::post('/exhibitors/{event_id?}', 'Api\ExhibitorsController@store');

//Alteração de Expositores
Route::put('/exhibitors/{id}', 'Api\ExhibitorsController@update');

//Exclusão de Expositores
Route::delete('/exhibitors/{id}', 'Api\ExhibitorsController@delete');

//Feed Para Expositores
Route::post('/exhibitors-feed/', 'FeedController@exhibitorsFeed');

//Detalhes de um Expositor
Route::get('/exhibitor/{id}', 'Api\ExhibitorsController@show');



//------------------------ Categorias de Expositores -------------------------------------------------------------------

//Lista de todas as Categorias
Route::get('/exhibitors-categories/{event_id?}', 'Api\ExhibitorsController@index_cat');

//Cadastro de Categoria
Route::post('/exhibitors-categories/{event_id?}', 'Api\ExhibitorsController@store_cat');

//Alteração de Categoria
Route::put('/exhibitors-categories/{category}', 'Api\ExhibitorsController@update_cat');

//Exclusão de Categoria
Route::delete('/exhibitors-categories/{category}', 'Api\ExhibitorsController@delete_cat');


//------------------------ Patrocinadores ------------------------------------------------------------------------------

//Lista de Todos os Patrocinadores
Route::get('/sponsors/{event_id?}', 'Api\SponsorController@index');

//Lista de todos os Patrocinadores por categoria (pela id da categoria)
Route::get('/sponsors-by-cat/{category}', 'Api\SponsorController@listByCategory');

//Cadastro de Patrocinadores
Route::post('/sponsors/', 'Api\SponsorController@store');

//Alteração de Patrocinadores
Route::put('/sponsors/{id}', 'Api\SponsorController@update');

//Exclusão de Patrocinadores
Route::delete('/sponsors/{id}', 'Api\SponsorController@delete');

//Detalhes de um Expositor
Route::get('/sponsor/{id}', 'Api\SponsorController@show');


//------------------------ Categorias de Patrocinadores ----------------------------------------------------------------

//Lista de todas as Categorias
Route::get('/sponsors-categories/{event_id?}', 'Api\SponsorController@index_cat');

//Cadastro de Categoria
Route::post('/sponsors-categories/{event_id?}', 'Api\SponsorController@store_cat');

//Alteração de Categoria
Route::put('/sponsors-categories/{category}', 'Api\SponsorController@update_cat');

//Exclusão de Categoria
Route::delete('/sponsors-categories/{category}', 'Api\SponsorController@delete_cat');

//------------------------ Palestrantes --------------------------------------------------------------------------------

//Lista de Todos os Palestrantes
Route::get('/speakers/{event_id?}', 'Api\SpeakerController@index');

//Lista de todos os Palestrantes por categoria (pela id da categoria)
Route::get('/speakers-by-cat/{category}', 'Api\SpeakerController@listByCategory');

//Cadastro de Palestrantes
Route::post('/speakers/', 'Api\SpeakerController@store');

//Alteração de Palestrantes
Route::put('/speakers/{id}', 'Api\SpeakerController@update');

//Exclusão de Palestrantes
Route::delete('/speakers/{id}', 'Api\SpeakerController@delete');

//Detalhes de um Palestrante
Route::get('/speaker/{id}', 'Api\SpeakerController@show');


//------------------------ Categorias de Palestrantes ------------------------------------------------------------------

//Lista de todas as Categorias
Route::get('/speakers-categories/{event_id?}', 'Api\SpeakerController@index_cat');

//Cadastro de Categoria
Route::post('/speakers-categories/{event_id?}', 'Api\SpeakerController@store_cat');

//Alteração de Categoria
Route::put('/speakers-categories/{category}', 'Api\SpeakerController@update_cat');

//Exclusão de Categoria
Route::delete('/speakers-categories/{category}', 'Api\SpeakerController@delete_cat');

//------------------------ Fornecedores --------------------------------------------------------------------------------

//Lista de Todos os Fornecedores
Route::get('/providers/{event_id?}', 'Api\ProviderController@index');

//Lista de todos os Fornecedores por categoria (pela id da categoria)
Route::get('/providers-by-cat/{category}', 'Api\ProviderController@listByCategory');

//Cadastro de Fornecedores
Route::post('/providers/', 'Api\ProviderController@store');

//Alteração de Fornecedores
Route::put('/providers/{id}', 'Api\ProviderController@update');

//Exclusão de Fornecedores
Route::delete('/providers/{id}', 'Api\ProviderController@delete');

//Detalhes de um Expositor
Route::get('/provider/{id}', 'Api\ProviderController@show');


//------------------------ Categorias de Fornecedores ------------------------------------------------------------------

//Lista de todas as Categorias
Route::get('/providers-categories/{event_id?}', 'Api\ProviderController@index_cat');

//Cadastro de Categoria
Route::post('/providers-categories/{event_id?}', 'Api\ProviderController@store_cat');

//Alteração de Categoria
Route::put('/providers-categories/{category}', 'Api\ProviderController@update_cat');

//Exclusão de Categoria
Route::delete('/providers-categories/{category}', 'Api\ProviderController@delete_cat');


//---------------------------------- Documentos ------------------------------------------------------------------------

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



//---------------------------------- Enquetes --------------------------------------------------------------------------

/*
 * Escolhe uma alternativa da enquete.
 * $id = id da alternativa escolhida, $person_id = id da pessoa que respondeu
 */

Route::post('/choose/{id}/{person_id}', 'Api\PollController@choose');


//-------------------------- Sessões de Eventos ------------------------------------------------------------------------

//Lista de Sessões por evento
Route::get('/sessions/{event_id}', 'Api\SessionController@list');

//Encontra a sessão desejada pelo código
Route::get('/session-code/{code}', 'Api\SessionController@getCode');

//-------------------------- Questões em Sessões -----------------------------------------------------------------------

//Adiciona nova questão para sessão escolhida
Route::post('/store-question', 'Api\QuestionController@store');

/*
 * Lista de Perguntas por sessão
 * $session_id = id da sessão
 * $page = número da página (deve ser maior que 1 caso informado)
 */
Route::get('/list-questions/{session_id}/{person_id?}/{page?}', 'Api\QuestionController@index');

// Usado para dar like numa pergunta. ID da questão
Route::put('/add-like/{id}/{person_id}', 'Api\QuestionController@add_like');

// Usado para retirar like numa pergunta. ID da questão
Route::put('/remove-like/{id}/{person_id}', 'Api\QuestionController@remove_like');

//-------------------------- Feedback de Sessões -----------------------------------------------------------------------

//Adiciona novo feedback de sessão
Route::post('/store-fb-session/', 'Api\FeedbackSessionController@store');

//Recupera lista de tipos de avaliação
Route::get('/types-fb-session/{session_id}', 'Api\FeedbackSessionController@listTypes');

//Verificar se a pessoa já avaliou a sessão
Route::get('/rating-person/{person_id}/{session_id}', 'Api\FeedbackSessionController@rating_person');


//-------------------------- Outros ------------------------------------------------------------------------------------

Route::any('/new-bug/', 'BugController@storeApp');

Route::post('/feedback-store/', 'ConfigController@sendFeedback');
