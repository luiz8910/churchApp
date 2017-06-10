<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name('index');

    Route::get('/home', 'DashboardController@index');

    Route::resource('users', 'UsersController');

    Route::resource('person', 'PersonController');

    Route::get('teen-create', 'PersonController@createTeen')->name('teen.create');

    Route::get('teen', 'PersonController@teenagers')->name('person.teen');

    Route::get('teen/{person}/edit', 'PersonController@editTeen')->name('teen.edit');

    Route::get('teen/{person}', 'PersonController@destroyTeen')->name('teen.destroy');

    Route::get('teen-detach/{id}/{parentId}', 'PersonController@detachTeen');

    Route::get('inactive', 'PersonController@inactive')->name('person.inactive');

    Route::get('turnActive/{id}', 'PersonController@turnActive')->name('person.turnActive');

    Route::post('person-imgProfile/{id}', 'PersonController@imgEditProfile')->name('person.imgEditProfile');

    Route::get('myAccount', 'UsersController@myAccount')->name('users.myAccount');

    Route::post('imgProfile', 'UsersController@imgProfile')->name('users.imgProfile');

    Route::post('changePass', 'UsersController@changePassword')->name('users.changePass');

    Route::get('group', 'GroupController@index')->name('group.index');

    Route::get('group/{group}', 'GroupController@show')->name('group.show');

    Route::get('visitors-create', 'VisitorController@create')->name('visitors.create');

    Route::post('visitors-store', 'VisitorController@store')->name('visitors.store');

    Route::get('visitors', 'VisitorController@index')->name('visitors.index');

    Route::get("visitors/{visitor}/edit", "VisitorController@edit")->name('visitors.edit');

    Route::post('visitors-update/{visitor}', "VisitorController@update")->name('visitors.update');

    Route::delete("visitors-delete/{visitor}", "VisitorController@destroy")->name('visitors.destroy');

    Route::post('visitor-imgProfile/{id}', 'VisitorController@imgEditProfile')->name('visitor.imgEditProfile');

    Route::delete('deleteMemberGroup/{group}/{member}', 'GroupController@deleteMember')->name('group.deleteMember');

    Route::get('deleteMemberGroup/{group}/{member}', 'GroupController@deleteMember');

    Route::get('group/{group}/edit', 'GroupController@edit')->name('group.edit');

    //Eventos

    Route::get('events/create', 'EventController@create')->name('event.create');

    Route::get('events', 'EventController@index')->name('event.index');

    Route::get('events/{event}/edit', 'EventController@edit')->name('event.edit');

    Route::get('events/create/{id}', 'EventController@create')->name('group.event.create');

    Route::post('events/store', 'EventController@store')->name('event.store');

    Route::put('events/{event}', 'EventController@update')->name('event.update');

    Route::get('json-events', 'EventController@json')->name('json-events');

    Route::post('/events/checkInEvent/{id}', 'EventController@checkInEvent')->name('event.checkInEvent');

    Route::post('/events/checkOutEvent/{id}', 'EventController@checkOutEvent')->name('event.checkOutEvent');

    Route::delete('events/delete/{id}', 'EventController@destroy')->name('event.destroy');

    Route::get('events/deleteMany/', 'EventController@destroyMany')->name('event.destroyMany');

    Route::get('events/test', 'EventController@testEventNotification');

    Route::get('notify', 'PersonController@notify')->name('notify.user');

    Route::get('/events/check/{id}', 'EventController@checkInEvent');

    Route::get("email", "PersonController@email");

    Route::get("agenda-mes/{thisMonth}", "EventController@nextMonth")->name("events.agenda-mes");

    Route::get("join-new-people/{input}", "SearchController@findNewPeople");

    Route::get("check-cpf/{cpf}", "PersonController@checkCPF");

    Route::get("/getPusherKey", "ConfigController@getPusherKey");

    Route::get("/markAllAsRead", "ConfigController@markAllAsRead");

    Route::get("/showGroupEvents/{group}", 'GroupController@showGroupEvents');

    Route::get('/addRemoveLoggedMember/{id}', 'GroupController@addRemoveLoggedMember')->name('group.addRemoveLoggedMember');

    Route::get('/addNote/{id}/{notes}', 'GroupController@addNote');

    Route::get('/getChartData/{group}', 'GroupController@getChartData');

    Route::get('groups/create', 'GroupController@create')->name('group.create');

    Route::post('group/store', 'GroupController@store')->name('group.store');

    Route::put('group/{group}', 'GroupController@update')->name('group.update');

    Route::delete('group/{group}', 'GroupController@destroy')->name('group.destroy');

    Route::post('groups/addMembers/{group}', 'GroupController@addMembers')->name('group.addMembers');

    Route::post('newMember/{group}', 'GroupController@newMemberToGroup')->name('group.newMember');

    Route::get('group/deleteManyUsers/{id}', 'GroupController@destroyManyUsers')->name('group.destroyManyUsers');

    Route::get('/person-delete/{id}', 'PersonController@destroy');

    Route::get('/group-delete/{id}', 'GroupController@destroy');

    Route::get('/events-delete/{id}', 'EventController@destroy');

    Route::get('/addUserToGroup/{personId}/{group}', 'GroupController@addUserToGroup');

    Route::get('pusher', function () {
        return view('pusher');


    });

});

    Auth::routes();

    Route::get('/events-ajax', 'EventController@getListEvents');

    Route::get('/events-excel/{format}', 'EventController@excel')->name('events.excel');

    Route::get('/group-ajax', 'GroupController@getListGroups');

    Route::get('/group-excel/{format}', 'GroupController@excel')->name('group.excel');

    Route::get('/person-ajax', 'PersonController@getListPeople');

    Route::get('/teen-ajax', 'PersonController@getListTeen');

    Route::get('/visitors-ajax', 'VisitorController@getList');

    Route::get('/person-excel/{format}', 'PersonController@PersonExcel')->name('person.excel');

    Route::get('/teen-excel/{format}', 'PersonController@teenExcel')->name('teen.excel');

    Route::get('/visitors-excel/{format}', 'PersonController@visitorsExcel')->name('visitors.excel');

//Ajax
    Route::get('/automatic-cep/{id}', 'PersonController@automaticCep');

//Recuperação de Senha
    Route::get("/passResetView/{email}", "UsersController@passResetView");

    Route::post("/passReset", "UsersController@passReset")->name('password.reset');

    Route::post("/sendPassword/{email}", "UsersController@sendPassword")->name('recover.password');

    Route::get("/emailTest/{email}", "UsersController@hasEmail");

    Route::get("/emailTest-edit/{email}/{id}", "UsersController@emailTestEdit");

    Route::any("/forgotPassword", "UsersController@forgotPassword")->name("forgot.password");

//Instant Search
    Route::get('/search/{text}', "SearchController@search");

//Instant Search na tabela de eventos
    Route::get('/search-events/{text}', 'SearchController@searchEvents');

//Login Facebook
    Route::get('auth/facebook/', 'Auth\RegisterController@redirectToProvider');
    Route::get('auth/facebook/callback', 'Auth\RegisterController@handleProviderCallback');

//Login Linkedin
    Route::get('auth/linkedin', 'Auth\RegisterController@redirectToLinkedinProvider');
    Route::get('auth/linkedin/callback', 'Auth\RegisterController@handleLinkedinProviderCallback');

//Login Google +
    Route::get('auth/google', 'Auth\RegisterController@redirectToGoogleProvider');
    Route::get('auth/google/callback', 'Auth\RegisterController@handleGoogleProviderCallback');

//Login Visitante
    Route::get('login-visitante', 'VisitorController@login');

    Route::post('login-visitante', 'Auth\RegisterController@loginVisitor')->name('login.visitor');


//Login Twitter
//Route::get('auth/twitter', 'Auth\RegisterController@redirectToTwitterProvider');
//Route::get('auth/twitter/callback', 'Auth\RegisterController@handleTwitterProviderCallback');


//Testes
Route::get('testeData/{id}', 'EventController@testeData');