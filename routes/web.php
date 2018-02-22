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
    Route::get('/sistema', 'DashboardController@index');

    Route::get('/home', 'DashboardController@index')->name('index');

    // Início Usuários e pessoas

    Route::resource('users', 'UsersController');

    Route::resource('person', 'PersonController');

    Route::get('teen-create', 'PersonController@createTeen')->name('teen.create');

    Route::get('teen', 'PersonController@teenagers')->name('person.teen');

    Route::get('teen/{person}/edit', 'PersonController@editTeen')->name('teen.edit');

    Route::get('teen/{person}', 'PersonController@destroyTeen')->name('teen.destroy');

    Route::get('teen-detach/{id}/{parentId}', 'PersonController@detachTeen');

    Route::get('inactive-person', 'PersonController@inactive')->name('person.inactive');

    Route::get('turnActive/{id}', 'PersonController@turnActive')->name('person.turnActive');

    Route::post('person-imgProfile/{id}', 'PersonController@imgEditProfile')->name('person.imgEditProfile');

    Route::get('myAccount', 'UsersController@myAccount')->name('users.myAccount');

    Route::post('imgProfile', 'UsersController@imgProfile')->name('users.imgProfile');

    Route::post('changePass', 'UsersController@changePassword')->name('users.changePass');

    Route::get("email", "PersonController@email");

    Route::get("check-cpf/{cpf}", "PersonController@checkCPF");

    Route::get('/person-delete/{id}', 'PersonController@destroy');

    Route::get('/teen-delete/{id}', 'PersonController@destroy');

    Route::get('notify', 'PersonController@notify')->name('notify.user');

    Route::get('/findUserAction/{id}', 'PersonController@findUserAction');

    Route::get('/keepActions/{id}', 'PersonController@keepActions');

    Route::get('/deleteActions/{id}', 'PersonController@deleteActions');

    Route::get('/verifyMaritalStatus/{id}', "PersonController@verifyMaritalStatus");

    Route::get('/setUploadStatus/{name}', 'PersonController@setUploadStatus');

    Route::get('/getUploadStatus/{name}', 'PersonController@getUploadStatus');

    Route::get('/reactivateUser/{person}', 'PersonController@reactivate');

    Route::get('/inactive-person-delete/{person}', 'PersonController@forceDelete');

    Route::get('/make-member/{id}', 'PersonController@makeMember');

    // Fim Usuários e pessoas

    //Inicio Grupos

    Route::get('group', 'GroupController@index')->name('group.index');

    //Route::get('group/{group}', 'GroupController@show')->name('group.show');

    Route::get('group/create', 'GroupController@create')->name('group.create');

    Route::put('/group/{group}', 'GroupController@update')->name('group.update');

    Route::post('group/store', 'GroupController@store')->name('group.store');

    Route::get('group/{group}', 'GroupController@destroy')->name('group.destroy');

    Route::post('groups/addMembers/{group}', 'GroupController@addMembers')->name('group.addMembers');

    Route::post('newMember/{group}', 'GroupController@newMemberToGroup')->name('group.newMember');

    Route::post('group/deleteManyUsers', 'GroupController@destroyManyUsers')->name('group.destroyManyUsers');

    Route::get('/group-delete/{id}', 'GroupController@destroy');

    Route::get('/addUserToGroup/{personId}/{group}', 'GroupController@addUserToGroup');

    Route::get('/addNote/{id}/{notes}', 'GroupController@addNote');

    Route::get('/getChartData/{group}', 'GroupController@getChartData');

    Route::delete('deleteMemberGroup/{group}/{member}', 'GroupController@deleteMember')->name('group.deleteMember');

    Route::get('deleteMemberGroup/{group}/{member}', 'GroupController@deleteMember');

    Route::get('group/{group}/edit', 'GroupController@edit')->name('group.edit');

    Route::get("/showGroupEvents/{group}", 'GroupController@showGroupEvents');

    Route::get('/addRemoveLoggedMember/{id}', 'GroupController@addRemoveLoggedMember')->name('group.addRemoveLoggedMember');

    // Fim Grupos


    //Visitantes

    Route::get('visitors-create', 'VisitorController@create')->name('visitors.create');

    Route::post('visitors-store', 'VisitorController@store')->name('visitors.store');

    Route::get('visitors', 'VisitorController@index')->name('visitors.index');

    Route::get("visitors/{visitor}/edit", "VisitorController@edit")->name('visitors.edit');

    Route::post('visitors-update/{visitor}', "VisitorController@update")->name('visitors.update');

    Route::delete("visitors-delete/{visitor}", "VisitorController@destroy")->name('visitors.destroy');

    Route::post('visitor-imgProfile/{id}', 'VisitorController@imgEditProfile')->name('visitor.imgEditProfile');

    Route::post('/events/checkInEventVisitor/{id}', 'EventController@checkInEventVisitor')->name('event.checkInEvent.visitor');

    Route::post('/events/checkOutEventVisitor/{id}', 'EventController@checkOutEventVisitor')->name('event.checkOutEvent.visitor');

    // Fim Visitantes

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

    Route::get('/events/check/{id}', 'EventController@checkInEvent');

    Route::get("agenda-mes/{thisMonth}/{church_id?}", "EventController@nextMonth")->name("events.agenda-mes");

    Route::get('/events-delete/{id}', 'EventController@destroy');

    Route::post("/imgEvent/{event}", 'EventController@imgEvent')->name('event.edit.imgEvent');

    Route::get("/inscricoes/{event}", "EventController@getSubEventList")->name('event.subscriptions');

    Route::post("/sub/{event}", 'EventController@eventSub')->name('event.addMembers');

    Route::get('/getSubEventListAjax/{event}', 'EventController@getSubEventListAjax');

    Route::get('/getCheckInListAjax/{event}', 'EventController@getCheckInListAjax');

    Route::get('/subPeople/{people}/{event}', 'EventController@subPeople');

    Route::get('/checkInPeople/{people}/{event}', 'EventController@checkInPeople');

    Route::get('/delete-sub/{person_id}/{event_id}', 'EventController@UnsubUser');

    Route::get('/check_auto/{event_id}/{check}', 'EventController@check_auto');

    // Fim Eventos


    Route::group(['middleware' => 'check.role:1,5'], function (){
        // Inicio Configurações

        Route::get("/configuracoes", "ConfigController@index")->name('config.index');

        Route::post("/config-required/{model}", 'ConfigController@updateRule')->name('config.required.fields');

        Route::post("/config/{model}", "ConfigController@newRule")->name('config.newRule');

        Route::post("/config-model", "ConfigController@newModel")->name('config.newModel');

        Route::post("/getChurchContacts", "PersonController@getChurchContacts")->name('config.person.contacts');

        Route::get("/importar", "ConfigController@import")->name('config.person.contacts.view');

        Route::post("/addPlan", "ConfigController@addPlan")->name('config.person.contacts.example');

        Route::get("/addPlan", "ConfigController@addPlanView")->name('config.addPlan');

        Route::get('/downloadPlan', 'ConfigController@downloadPlan')->name('download.plan');

        Route::get('/showPlan', 'ConfigController@showPlan')->name('show.plan');

        Route::get('rollback/{table}', 'ImportController@rollbackLast')->name('import.rollback-last');

        Route::get('rollback-code/{code}', 'ImportController@rollback');

        Route::get('remove-inactive/{code}', 'ImportController@removeInactive');

        Route::get('remove-inactive-vis/{code}', 'ImportController@removeInactiveVisitor');

        Route::get('/newFeed/{feed_notif}/{text}/{link}/{expires_in?}', 'FeedController@newFeed');

        Route::get('/event-newFeed/{event}/{text}/{link?}/{expires_in?}', 'FeedController@eventFeed');

        Route::get('/group-newFeed/{event}/{text}/{link?}/{expires_in?}', 'FeedController@groupFeed');

        Route::get('/person-newFeed/{event}/{text}/{link?}/{expires_in?}', 'FeedController@personFeed');

        Route::get("/feeds", "FeedController@index")->name('feeds.index');

        //Relatórios

        Route::get('/relatorios-eventos', "ReportController@index")->name('report.index');

        Route::get('/relatorios-eventos/{id}', "ReportController@index")->name('report.index-id');

        Route::get('/getReport', 'ReportController@getReport');

        Route::get('/ageRange', 'ReportController@ageRange');

        Route::get('/member_visitor', 'ReportController@member_visitor');

        Route::get('/memberFrequency/{person_id}', 'ReportController@memberFrequency');

        Route::get('/visitorFrequency/{visitor_id}', 'ReportController@visitorFrequency');

        Route::get('/exportExcelReport', 'ReportController@exportExcel');
    });


    Route::get('nextEvent', 'DashboardController@nextEvent');

    Route::get("/getPusherKey", "ConfigController@getPusherKey");

    Route::get("/markAllAsRead", "ConfigController@markAllAsRead");

    Route::get("/getChurchZipCode", "ConfigController@getChurchZipCode");



    Route::get('pusher', function () {
        return view('pusher');

    });

    Route::get('/passport', function (){
        return view('home');
    });

    // Fim Configurações

});



    Auth::routes();

    Route::get('/privacy', function(){
        return view('config.privacypolicy');
    });

    //Rotas do site
    Route::get('/', 'SiteController@index');

    Route::post('/contact-site/{data}', 'ContactSiteController@store');

    //Fim Rotas Site

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

    Route::get('/person-inactive-excel/{format}', 'PersonController@inactiveExcel')->name('person-inactive.excel');

//Ajax
    Route::get('/automatic-cep/{id}/{user}', 'PersonController@automaticCep');

//Recuperação de Senha
    Route::get("/passResetView/{email}", "UsersController@passResetView");

    Route::post("/passReset", "UsersController@passReset")->name('password.reset');

    Route::post("/sendPassword/{email}", "UsersController@sendPassword")->name('recover.password');

    Route::get("/sendPassword/{person}", "UsersController@sendPasswordUser");

    Route::get("/emailTest/{email}/{church_id?}", "UsersController@hasEmail");

    Route::get("/emailTest-edit/{email}/{id}", "UsersController@emailTestEdit");

    Route::any("/forgotPassword", "UsersController@forgotPassword")->name("forgot.password");

//Instant Search
    Route::get('/search/{text}', "SearchController@search");

    Route::get("join-new-people/{input}", "SearchController@findNewPeople");

    //Route::get('/search-events/{text}', 'SearchController@searchEvents');

    Route::get('/search-person/{input}/{status}', 'SearchController@searchPerson');

    Route::get('/search-group/{input}', 'SearchController@searchGroup');

    Route::get('/search-event/{input}', 'SearchController@searchEvent');

    Route::get('/searchable-models', 'SearchController@searchableModels');

//Login Facebook
    Route::get('/pre/auth/facebook/{church}', 'Auth\RegisterController@preFbLogin');

    Route::get('/auth/facebook/', 'Auth\RegisterController@redirectToProvider');
    Route::get('/auth/facebook/callback', 'Auth\RegisterController@handleProviderCallback');

//Login Google +
    Route::get('pre/auth/google/{church}', 'Auth\RegisterController@preGoogleLogin');
    Route::get('auth/google', 'Auth\RegisterController@redirectToGoogleProvider');
    Route::get('auth/google/callback', 'Auth\RegisterController@handleGoogleProviderCallback');

//Login Linkedin
    Route::get('auth/linkedin', 'Auth\RegisterController@redirectToLinkedinProvider');
    Route::get('auth/linkedin/callback', 'Auth\RegisterController@handleLinkedinProviderCallback');

//Login Visitante
    Route::get('login-visitante', 'VisitorController@login');

    Route::post('login-visitante', 'Auth\RegisterController@loginVisitor')->name('login.visitor');

    Route::get('home-visitante/{church}', 'VisitorController@visitors')->name('home.visitor');


//Login Twitter
//Route::get('auth/twitter', 'Auth\RegisterController@redirectToTwitterProvider');
//Route::get('auth/twitter/callback', 'Auth\RegisterController@handleTwitterProviderCallback');



//Testes
Route::get('/map', function(){
    $string = 'https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyCjTs0nbQbEecUygnKpThLfzRKES8nKS0A';

    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );

    $json = file_get_contents($string, false, stream_context_create($arrContextOptions));
    $obj = json_decode($json);


    dd($obj->results[0]->geometry->location);
});

Route::get('cron', 'EventController@Cron');

Route::get('subAllMembers', 'EventController@subAllMembers');

Route::get('calendario', 'DashboardController@calendario');

Route::get('menu', 'DashboardController@menu');

Route::get('recentTable', "PersonController@clearRecentTables");

Route::get('/juquinha', 'HtmlController@teste');

Route::get('join', 'EventController@testeJoin');

Route::get('surname', "PersonController@surname");

Route::get('updateEventDate', "DashboardController@updateEventDate");

Route::get('/people', 'PersonController@listPeople');

Route::get('/api/events', 'EventController@getEventsApi');

Route::get('api/churches', 'ChurchController@getChurchesApi');

Route::get('/api', function (){
    $query = http_build_query([
        'client_id' => '4',
        'redirect_uri' => 'http://localhost:9999/callback',
        'response_type' => 'code',
        'scope' => ''
    ]);

    return redirect("http://localhost:8000/oauth/authorize?$query");
});

Route::get('/callback', function (\Illuminate\Http\Request $request){
    $code = $request->get('code');

    $http = new \GuzzleHttp\Client();

    $response = $http->post('http://localhost:8000/oauth/token', [
       'form_params' => [
           'client_id' => '4',
           'client_secret' => 'Xv7jXpyKn0VMbQ9goSvNkItuEcOsYAG7qZPytaKj',
           'redirect_uri' => 'http://localhost:9999/callback',
           'code' => $code,
           'grant_type' => 'authorization_code'
       ]
    ]);

    dd(json_decode($response->getBody(), true));
});
Route::post('/api-login', 'UsersController@login');

Route::get('list-person', 'DashboardController@check_in');

Route::get('check-in', 'DashboardController@checkin');

Route::get('getLastEvent', 'EventController@getLastEvent');


