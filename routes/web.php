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

Route::group(['middleware' => 'auth'], function (){
    Route::get('/', 'DashboardController@index')->name('index');

    Route::resource('users', 'UsersController');

    Route::resource('person', 'PersonController');

    Route::get('teen', 'PersonController@teenagers')->name('person.teen');

    Route::get('visitors', 'PersonController@visitors')->name('person.visitors');

    Route::get('inactive', 'PersonController@inactive')->name('person.inactive');

    Route::get('turnActive/{id}', 'PersonController@turnActive')->name('person.turnActive');

    Route::post('person-imgProfile/{id}', 'PersonController@imgEditProfile')->name('person.imgEditProfile');

    Route::get('myAccount', 'UsersController@myAccount')->name('users.myAccount');
    Route::post('imgProfile', 'UsersController@imgProfile')->name('users.imgProfile');
    Route::post('changePass', 'UsersController@changePassword')->name('users.changePass');


    Route::get('group', 'GroupController@index')->name('group.index');

    Route::get('group/{group}', 'GroupController@show')->name('group.show');

    //Eventos

    Route::get('events/create', 'EventController@create')->name('event.create');

    Route::get('events', 'EventController@index')->name('event.index');

    Route::get('events/{event}/edit', 'EventController@edit')->name('event.edit');

    Route::get('events/create/{id}', 'EventController@create')->name('group.event.create');

    Route::post('events/store', 'EventController@store')->name('event.store');

    Route::put('events/{event}', 'EventController@update')->name('event.update');

    Route::get('json-events', 'EventController@json')->name('json-events');

    Route::post('/events/checkInEvent/{id}', 'EventController@checkInEvent')->name('event.checkInEvent');

    Route::delete('events/delete/{id}', 'EventController@destroy')->name('event.destroy');

    Route::get('events/deleteMany/', 'EventController@destroyMany')->name('event.destroyMany');

    Route::get('events/test', 'EventController@testEventNotification');

    Route::get('notify', 'PersonController@notify')->name('notify.user');

    Route::get('/events/check/{id}', 'EventController@checkInEvent');

    Route::get("email", "PersonController@email");

});

Route::group(["middleware" => "check.role:1"], function () {

    Route::get('groups/create', 'GroupController@create')->name('group.create');

    Route::get('group/{group}/edit', 'GroupController@edit')->name('group.edit');

    Route::post('group/store', 'GroupController@store')->name('group.store');

    Route::put('group/{group}', 'GroupController@update')->name('group.update');

    Route::delete('group/{group}', 'GroupController@destroy')->name('group.destroy');

    Route::post('groups/addMembers/{group}', 'GroupController@addMembers')->name('group.addMembers');

    Route::delete('deleteMemberGroup/{group}/{member}', 'GroupController@deleteMember')->name('group.deleteMember');

    Route::post('newMember/{group}', 'GroupController@newMemberToGroup')->name('group.newMember');

    Route::get('group/deleteManyUsers/{id}', 'GroupController@destroyManyUsers')->name('group.destroyManyUsers');


    Route::get('pusher', function(){
        return view('pusher');
    });


});


Auth::routes();

Route::get('/home', 'HomeController@index');

//Recuperação de Senha
Route::get("/passResetView/{email}", "UsersController@passResetView");

Route::post("/passReset", "UsersController@passReset")->name('password.reset');

Route::post("/sendPassword/{email}", "UsersController@sendPassword")->name('recover.password');

Route::get("/emailTest/{email}", "UsersController@hasEmail");

Route::get("/forgotPassword", "UsersController@forgotPassword")->name("forgot.password");

//Teste Search
Route::get('teste', function(){
    $event = \App\Models\Event::search('encontro')->get();

    return $event;
});

Route::get('/search/{text}', "SearchController@search");

//Login Facebook
Route::get('auth/facebook', 'Auth\RegisterController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\RegisterController@handleProviderCallback');

//Login Linkedin
Route::get('auth/linkedin', 'Auth\RegisterController@redirectToLinkedinProvider');
Route::get('auth/linkedin/callback', 'Auth\RegisterController@handleLinkedinProviderCallback');

//Login Google +
Route::get('auth/google', 'Auth\RegisterController@redirectToGoogleProvider');
Route::get('auth/google/callback', 'Auth\RegisterController@handleGoogleProviderCallback');

//Login Twitter
//Route::get('auth/twitter', 'Auth\RegisterController@redirectToTwitterProvider');
//Route::get('auth/twitter/callback', 'Auth\RegisterController@handleTwitterProviderCallback');