<?php

use App\Services\PagSeguroServices;
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
    Route::get('/sistema', 'EventController@index');

    Route::get('/home', 'EventController@index')->name('index');

    // Início Usuários e pessoas



    // Fim Eventos


    Route::group(['middleware' => 'check.role:1,5'], function (){
        // Inicio Configurações

        Route::get("/configuracoes", "ConfigController@index")->name('config.index');

        Route::post("/config-required/{model}", 'ConfigController@updateRule')->name('config.required.fields');

        Route::post("/config/{model}", "ConfigController@newRule")->name('config.newRule');

        Route::post("/config-model", "ConfigController@newModel")->name('config.newModel');

        Route::post("/getChurchContacts", "PersonController@getSimpleContact")->name('config.person.contacts');

        Route::post('/planSize', 'PersonController@planSize')->name('plan.size');

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

        Route::post('/event-newFeed', 'FeedController@eventFeed')->name('event-newFeed');

        Route::get('/group-newFeed/{event}/{text}/{link?}/{expires_in?}', 'FeedController@groupFeed');

        Route::get('/person-newFeed/{event}/{text}/{link?}/{expires_in?}', 'FeedController@personFeed');

        Route::get("/feeds", "FeedController@index")->name('feeds.index');

        //Relatórios

        Route::get('/relatorios-eventos', "ReportController@index")->name('report.index');

        Route::post('/relatorios-eventos', "ReportController@eventReport")->name('report.index');

        Route::get('/getReport', 'ReportController@getReport');

        Route::get('/ageRange', 'ReportController@ageRange');

        Route::get('/member_visitor', 'ReportController@member_visitor');

        Route::get('/memberFrequency/{person_id}', 'ReportController@memberFrequency');

        Route::get('/visitorFrequency/{visitor_id}', 'ReportController@visitorFrequency');

        Route::get('/exportExcelReport/{event_id}', 'ReportController@exportXLS');
    });

    Route::group(['middleware' => 'check.role:5'], function (){

        //-------------------------------- Expositores -----------------------------------------------------------------

        Route::get('/expositores', "ExhibitorsController@index")->name('exhibitors.index');

        Route::get('/expositores_cat/{id}', "ExhibitorsController@listByCategory")->name('exhibitors.index.listByCat');

        Route::get('/expositores_novo', 'ExhibitorsController@create')->name('exhibitors.create');

        Route::get('/expositores_editar/{id}', 'ExhibitorsController@edit')->name('exhibitors.edit');

        Route::post('/exhibitors', 'ExhibitorsController@store')->name('exhibitors.store');

        Route::put('/exhibitors/{id}', 'ExhibitorsController@update')->name('exhibitors.update');

        Route::delete('/exhibitors/{id}', 'ExhibitorsController@delete')->name('exhibitors.delete');

        //--------------------------------- Categorias de Expositores --------------------------------------------------

        Route::get('/categorias-expositores', 'ExhibitorsController@index_cat')->name('exhibitors.index.cat');

        Route::post('/categorias-expositores', 'ExhibitorsController@store_cat')->name('exhibitors.store.cat');

        Route::put('/categorias-expositores/{id}', 'ExhibitorsController@update_cat')->name('exhibitors.update.cat');

        Route::delete('/categorias-expositores/{id}', 'ExhibitorsController@delete_cat')->name('exhibitors.delete.cat');


        //---------------------------------- Patrocinadores ------------------------------------------------------------

        Route::get('/patrocinadores', "SponsorController@index")->name('sponsors.index');

        Route::get('/patrocinadores_cat/{id}', "SponsorController@listByCategory")->name('sponsors.index.listByCat');

        Route::get('/patrocinadores_novo', 'SponsorController@create')->name('sponsors.create');

        Route::get('/patrocinadores_editar/{id}', 'SponsorController@edit')->name('sponsors.edit');

        Route::post('/sponsors', 'SponsorController@store')->name('sponsors.store');

        Route::put('/sponsors/{id}', 'SponsorController@update')->name('sponsors.update');

        Route::delete('/sponsors/{id}', 'SponsorController@delete')->name('sponsors.delete');

        //--------------------------------- Categorias de Expositores --------------------------------------------------

        Route::get('/categorias-patrocinadores', 'SponsorController@index_cat')->name('sponsors.index.cat');

        Route::post('/categorias-patrocinadores', 'SponsorController@store_cat')->name('sponsors.store.cat');

        Route::put('/categorias-patrocinadores/{id}', 'SponsorController@update_cat')->name('sponsors.update.cat');

        Route::delete('/categorias-patrocinadores/{id}', 'SponsorController@delete_cat')->name('sponsors.delete.cat');

        //---------------------------------- Documentos ----------------------------------------------------------------


        /*
         * Lista de todos os Documentos, se passado o parâmetro event_id,
         * então lista só do evento selecionado
         */
        Route::get('/doc/{event_id?}', 'DocumentsController@index')->name('documents.index');

        // Realiza upload de um arquivo
        Route::post('/doc-upload', 'DocumentsController@upload')->name('documents.upload');

        //Realiza o download de um arquivo
        Route::get('/doc-download/{id}', 'DocumentsController@download')->name('documents.download');

        //Redireciona para o download
        Route::get('/redirect-download/{id}', 'DocumentsController@redirectDownload')->name('documents.download.redirect');

        //Realiza a exclusão de um arquivo
        Route::delete('/documents/{file_id}/{person_id}', 'Api\DocumentsController@delete')->name('documents.delete');

        //Busca o arquivo pelo nome completo
        Route::get('/doc-find/{name}', 'Api\DocumentsController@find');

        //Busca o arquivo pelo nome no modo instant search
        Route::get('/doc-search/{input}', 'Api\DocumentsController@search');

        //Exibe os documentos excluidos
        Route::get('/docs-deleted', 'DocumentsController@deleted')->name('documents.deleted');

        //Recupera o documento
        Route::put('/documents-activate/{id}', 'DocumentsController@activate');



        //---------------------------------- Enquetes ------------------------------------------------------------------

        //Lista de Enquetes, separação por eventos é opcional
        Route::get('/enquetes/{event_id?}', 'PollController@index')->name('polls.index');

        //Criação de Enquete
        Route::get('/enquetes-criar/', 'PollController@create')->name('polls.create');

        //Persistência de criação de enquete
        Route::post('/polls/', 'PollController@store')->name('polls.store');

        //Alteração de Enquete
        Route::get('/enquetes-editar/{id}', 'PollController@edit')->name('polls.edit');

        //Persistência de alteração de enquete
        Route::put('/polls/{id}', 'PollController@update')->name('polls.update');

        //Lista de enquetes expiradas
        Route::get('/enquetes-expiradas/{id?}', 'PollController@expired')->name('polls.expired');

        //Lista de enquetes excluidas
        Route::get('/enquetes-excluidas/{id?}', 'PollController@deleted')->name('polls.deleted');

        //Persistência de exclusão de enquete
        Route::delete('/delete-poll/{id}/{person_id}', 'PollController@delete');

        //Persistência de expiração de enquete
        Route::put('/expire-poll/{id}/{person_id}', 'PollController@expire');

        //Persistência de exclusão de alternativa de enquete
        Route::delete('/delete-item-poll/{id}', 'PollController@deleteItem');

        //Resultados da enquete
        Route::get('/poll-report/{id}', 'PollController@report')->name('poll.report');









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

        Route::get('aguardando-aprovacao', 'PersonController@waitingApproval')->name('person.waitingApproval');

        Route::get('approve-member/{id}', 'PersonController@approveMember');

        Route::post('/denyMember/{id}', 'PersonController@denyMember');

        Route::get('/deny-details/{id}', 'PersonController@denyDetails');

        Route::post('/waiting-approval', 'PersonController@storeWaitingApproval')->name('person.store.waitingApproval');

        Route::get('/delete-all-inactives', 'PersonController@forceDeleteAll');

        Route::get('new-password/{person_id}', 'UsersController@newPassword');

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

        Route::get('visitors', 'PersonController@visitors')->name('visitors.index');

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

        Route::post("/imgEventBg/{event}", 'EventController@imgEventBg')->name('event.edit.imgEvent_bg');

        Route::get("/inscricoes/{event}", "EventController@getSubEventList")->name('event.subscriptions');

        Route::post("/sub/{event}", 'EventController@eventSub')->name('event.addMembers');

        Route::get('/getSubEventListAjax/{event}', 'EventController@getSubEventListAjax');

        Route::get('/getCheckInListAjax/{event}', 'EventController@getCheckInListAjax');

        Route::get('/subPeople/{people}/{event}', 'EventController@subPeople');

        Route::any('/checkInPeople/{people}/{event}', 'EventController@checkInPeople');

        Route::get('/delete-sub/{person_id}/{event_id}', 'EventController@UnsubUser');

        Route::get('/check_auto/{event_id}/{check}', 'EventController@check_auto');

        Route::get('/sessoes-lista/{event_id}', 'SessionController@list')->name('event.sessions');

        Route::post('/sessoes-store/{event_id}', 'SessionController@store')->name('event.session.store');

        Route::post('/sessoes-update/{event_id}', 'SessionController@update')->name('event.session.update');

        Route::get('sessoes-check-in/{id}', 'SessionController@check_in_list')->name('event.session.check_in_list');

        Route::get('check-in_manual/{event_id}/{person_id}', 'EventController@checkin_manual');

        Route::get('uncheck-in_manual/{event_id}/{person_id}', 'EventController@uncheckin_manual');

        Route::get('/findSubUsers/{input}/{event_id}', 'EventController@findSubUsers');





        
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

    //Pagamentos Zoop

        //Criar Cartão
            Route::post('store-payment', 'PaymentController@store')->name('payment.store');

        //Planos

            Route::get('/payu-store-plan', 'PaymentController@planStore');

            Route::get('payu-get-plan/{code}', 'PaymentController@planGet');

            Route::get('payu-update-plan/{code}', 'PaymentController@planUpdate');

            Route::get('payu-delete-plan/{code}', 'PaymentController@planDelete');

        //Clientes

            Route::get('/payu-get-customer/{id}', 'PaymentController@customerGet');

            Route::get('/payu-update-customer/{id}', 'PaymentController@customerUpdate');

            Route::get('/payu-delete-customer/{id}', 'PaymentController@customerDelete');

            Route::get('payu-store-customer', 'PaymentController@customerStore');

        //Cartões

            Route::get('/payu-store-card/{customer_id}', 'PaymentController@cardStore');

            Route::get('payu-get-card/{token}', 'PaymentController@cardGet');

            Route::get('payu-update-card/{token}', 'PaymentController@cardUpdate');

            Route::get('payu-delete-card/{customer_id}/{token}', 'PaymentController@cardDelete');

        //Teste

            Route::get('payment-event', function (){
                return view('site.payment-event');
            });

    // Fim Pagamentos


    Auth::routes();

    Route::any('/log-out', 'Auth\LoginController@logout')->name('log-out');

    Route::get('/privacy', function(){
        return view('config.privacypolicy');
    });

    //Rotas do site
    Route::get('/', 'SiteController@index')->name('site.home');

    Route::post('/contact-site/{data}', 'ContactSiteController@store');

    Route::get('/teste-gratis/{id}', 'SiteController@trial')->name('site.trial');

    Route::get('/change-plan/{type}/{id}', 'SiteController@changePlan');

    Route::get('/confirma-cadastro/{id}', 'ChurchController@postConfirmation')->name('post.confirmation');

    Route::post('new-responsible/{plan}', 'ChurchController@newResponsible')->name('new.church-responsible');

    Route::get('/verify-credit-card/{number}', 'ChurchController@verifyCreditCard');

    Route::post('/responsible-side-data', 'ChurchController@storeResponsible')->name('responsible.store');

    //Fim Rotas Site

    /*
     * Admin do Site
     */

    Route::group(['middleware' => 'check.admin:6'], function (){

        Route::get('/admin', 'SiteController@adminHome')->name('admin.home');

        Route::get('/admin-features', 'SiteController@adminFeatures')->name('admin.features');

        Route::get('/admin-plans', 'SiteController@adminPlans')->name('admin.plans');

        Route::post('/newFeature/{data}', 'SiteController@newFeature');

        Route::get('/delete-feature/{id}', 'SiteController@deleteFeature');

        Route::post('/new-feature-item/{data}/{id}', 'SiteController@newFeatureItem');

        Route::get('/deleteItemFeature/{id}', 'SiteController@deleteItemFeature');

        Route::post('/editFeatures/{data}/{id}', 'SiteController@editFeatures');

        Route::post('/edit-main-site/{data}', 'SiteController@editMain');

        Route::post('/edit-about-site/{data}', 'SiteController@editAbout');

        Route::post('/edit-about-item-site/{data}', 'SiteController@editAboutItem');

        Route::post('/edit-features-site/{data}', 'SiteController@editFeatures');

        Route::post('/new-icon', 'SiteController@uploadIcons');

        Route::post('/new-icons', 'SiteController@uploadIconsBatch');

        Route::get('/change-icon/{feature_item_id}/{icon_id}', 'SiteController@changeIcons');

        Route::post('/new-faq/{data}', 'SiteController@newFaq');

        Route::post('/edit-faq/{data}/{id}', 'SiteController@editFaq');

        Route::get('/delete-faq/{id}', 'SiteController@deleteFaq');

        Route::post('/newPlan', 'AdminController@storePlan')->name('admin.new-plan');

        Route::post('/newPlanType', 'AdminController@newPlanType')->name('admin.new-plan-type');

        Route::post('/editPlan', 'AdminController@updatePlan')->name('admin.update-plan');

        Route::post('/editPlanType', 'SiteController@editPlanType')->name('admin.edit-plan-type');

        Route::get('/deletePlan/{id}', 'AdminController@deletePlan');

        Route::post('/new-plan-item', 'SiteController@newPlanItem');

        Route::get('/delete-plan-item/{id}', 'SiteController@deletePlanItem');

        Route::get('/delete-plan-type/{id}', 'SiteController@deletePlanType');

        Route::get('/igrejas', 'ChurchController@index')->name('admin.churches');

        Route::get("/delete-church/{id}", 'ChurchController@delete');

        Route::get('/edit-church/{id}', 'ChurchController@edit');

        Route::post('/update-church/{id}', 'ChurchController@update');

        Route::get('/inactive-churches', 'ChurchController@inactive')->name('inactive.churches');

        Route::get('/waiting-churches', 'ChurchController@waiting')->name('waiting.churches');

        Route::get('/activate-church/{id}', 'ChurchController@activate');

        Route::get('/full-activate-church/{id}', 'ChurchController@fullActivate');

        Route::post('/new-church', 'ChurchController@store')->name('new.church');

    });

    Route::get('/url/{public_url}', 'EventController@subUrl');

    Route::post('/url', 'EventController@subFromUrl')->name('event.url.sub');

    Route::get('/login-admin', 'Auth\LoginController@loginAdmin')->name('login.admin');

    Route::post('/login-admin', 'Auth\LoginController@authenticateAdmin')->name('login.admin.authenticate');

    Route::post('/recover-pass-admin', 'Auth\LoginController@recoverPass')->name('admin.recover-pass');

    Route::get('/check-email/{email}', 'ChurchController@checkEmail');

    Route::get('getSubDays/{event_id}', 'ReportController@getSubDays');

    Route::get('getFrequency/{event_id}', 'ReportController@getFrequency');

    // Fim Admin site

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

    Route::get('/search-person/{input}/{status}/{approval?}', 'SearchController@searchPerson');

    Route::get('/search-group/{input}', 'SearchController@searchGroup');

    Route::get('/search-event/{input}', 'SearchController@searchEvent');

    Route::get('/searchable-models', 'SearchController@searchableModels');

    Route::get('/general-search/{input}/{model}/{deleted?}/{column?}', 'SearchController@generalSearch');

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

    Route::post('/new-bug/', 'BugController@store');

    Route::get('bugs', 'BugController@bugs');


    //Documentação da API
    Route::get('docs', function(){
        return view('docs.api');
    })->name('docs');

    Route::get('docs/igrejas', function(){
        return view('docs.churchs');
    })->name('docs.churchs');

    Route::get('docs/login', function(){
        return view('docs.login');
    })->name('docs.login');

    Route::get('docs/eventos', function(){
        return view('docs.events');
    })->name('docs.events');

    Route::get('docs/grupos', function(){
        return view('docs.groups');
    })->name('docs.groups');

    Route::get('docs/ativ-recentes', function(){
        return view('docs.activity');
    })->name('docs.activity');

    Route::get('docs/pessoas', function(){
        return view('docs.people');
    })->name('docs.people');

    Route::get('docs/check-in', function(){
        return view('docs.check-in');
    })->name('docs.check-in');

    Route::get('docs/expositores', function(){
        return view('docs.exhibitors');
    })->name('docs.exhibitors');

    Route::get('docs/patrocinadores', function(){
        return view('docs.sponsors');
    })->name('docs.sponsors');

    Route::get('docs/documentos', function(){
        return view('docs.documents');
    })->name('docs.documents');

    Route::get('docs/enquetes', function(){
        return view('docs.polls');
    })->name('docs.polls');

    Route::get('docs/config', function(){
        return view('docs.config');
    })->name('docs.config');

    Route::get('docs/sessoes', function(){
        return view('docs.sessions');
    })->name('docs.events.sessions');


//Login Twitter
//Route::get('auth/twitter', 'Auth\RegisterController@redirectToTwitterProvider');
//Route::get('auth/twitter/callback', 'Auth\RegisterController@handleTwitterProviderCallback');



//Testes
Route::get('/map', function(){
    $string = 'https://maps.googleapis.com/maps/api/geocode/json?address=375+Avenida+Londres,+Sorocaba+,+SP&key=AIzaSyCjTs0nbQbEecUygnKpThLfzRKES8nKS0A';

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

Route::get('getListSubEvent/{event_id}', 'EventController@listEvent');

Route::get('whatsapp/{event_id}/{person_id}', 'EventController@sendWhatsApp');

Route::get('email-qr/{event_id}/{person_id}', 'EventController@sendEmailQR');

Route::get('email-qr-all/{event_id}', 'EventController@sendQREmailAll')->name('sendqr.email.all');

Route::get('teste-zap/', 'EventController@testezap');

Route::get('resub-test/{event_id}', 'EventController@reSub');

Route::get('resub/{event_id}', 'EventController@reSub_event_person');

Route::get('report-test', 'ReportController@reportTest');

Route::get('sub-test', 'EventController@subTest');

Route::get('sub-test-email/{event_id}/{person_id}', 'EventController@send_sub_email_test');

Route::get('cron', 'EventController@Cron');

Route::get('subAllMembers', 'EventController@subAllMembers');

Route::get('calendario', 'DashboardController@calendario');

Route::get('menu', 'DashboardController@menu');

Route::get('recentTable', "PersonController@clearRecentTables");

//Route::get('/juquinha', 'HtmlController@teste');

Route::get('join', 'EventController@testeJoin');

Route::get('surname', "PersonController@surname");

Route::get('updateEventDate', "DashboardController@updateEventDate");

Route::get('/people', 'PersonController@listPeople');

Route::get('/api/events', 'EventController@getEventsApi');

Route::get('api/churches', 'ChurchController@getChurchesApi');

Route::get('phpinfo', function(){
    phpinfo();
});

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

Route::get('/checkout-pagseguro/{id}', function($id){

    $data['email'] = 'luiz.sanches8910@gmail.com';

    $data['token'] = 'B9435321E5E04AD099AB3E714430A8A9';

    $response = (new PagSeguroServices())->request(PagSeguroServices::SESSION_SANDBOX, $data);

    $session = new \SimpleXMLElement($response->getContents());

    $session = $session->id;

    //$amount = number_format(500, 2, '.', '');

    return view('pagseguro', compact('id', 'session'));
});

Route::get('/pagseguro/{plan_id}', 'ChurchController@payment')->name('pagseguro.payment');

Route::post('transaction', 'ChurchController@transaction')->name('new.transaction');

Route::get('delete-visitors', 'PersonController@ExcludeVisitorsModel');

Route::get('api-teste', function(){

    return view('teste-api');
});

Route::get('basic-config', 'ChurchController@setBasicConfig');

Route::get('prod-changes', 'ChurchController@sendChangesProd');

Route::get('generate-users/{stop_number}', 'PersonController@generateUsers');

Route::get('check_in-test', 'PersonController@check_inQr');

Route::get('subTestUsers/{event_id}', 'PersonController@subTestUsers');

Route::get('teste-telefone', 'PersonController@testeTelefone');

Route::get('change-name', 'PersonController@changeName');
