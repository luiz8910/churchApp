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

    Route::resource('group', 'GroupController');

});


Auth::routes();

Route::get('/home', 'HomeController@index');

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