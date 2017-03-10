<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.1
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    @include('includes.head')

    <link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <link href="../assets/pages/css/search.min.css" rel="stylesheet" type="text/css" />

</head>
<!-- END HEAD -->

<body class="page-container-bg-solid">
<div class="page-wrapper">
    <div class="page-wrapper-row">
        <div class="page-wrapper-top">
            <!-- BEGIN HEADER -->
            @include('includes.header')
            <!-- END HEADER -->
        </div>
    </div>
    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <!-- BEGIN PAGE HEAD-->
                    <div class="page-head">
                        <div class="container">
                            <!-- BEGIN PAGE TITLE -->
                            <div class="page-title">
                                <h1> Eventos </h1>
                            </div>
                            <!-- END PAGE TITLE -->


                        </div>
                    </div>
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="page-content">
                        <div class="container">
                            <!-- BEGIN PAGE BREADCRUMBS -->
                            <ul class="page-breadcrumb breadcrumb">
                                <li>
                                    <a href="index.html">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <a href="#">Pages</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <a href="#">General</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Search</span>
                                </li>
                            </ul>
                            <!-- END PAGE BREADCRUMBS -->
                            <!-- BEGIN PAGE CONTENT INNER -->
                            <div class="page-content-inner">
                                <div class="search-page search-content-4">
                                    <div class="search-bar bordered">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Pesquisar Eventos">
                                                    <span class="input-group-btn">
                                                                <button class="btn green-soft uppercase bold" type="button">Pesquisar</button>
                                                            </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 extra-buttons">
                                                <button class="btn grey-steel uppercase bold" onclick="newEvent()" type="button">Novo Evento</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-success alert-dismissible" id="alert-success" role="alert" style="display: none;">
                                        <button type="button" class="close" id="button-success" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Sucesso</strong> Você está inscrito
                                    </div>

                                    <div class="alert alert-info alert-dismissible" id="alert-info" role="alert" style="display: none;">
                                        <button type="button" class="close" id="button-info" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Atenção</strong> Você cancelou sua inscrição
                                    </div>

                                    <div class="alert alert-danger alert-dismissible" id="alert-danger" role="alert" style="display: none;">
                                        <button type="button" class="close" id="button-danger" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Erro</strong> Sua solicitação foi recusada
                                    </div>

                                    <div class="search-table table-responsive">
                                        <table class="table table-bordered table-striped table-condensed">
                                            <thead class="bg-blue">
                                            <tr>
                                                <th>
                                                    <a href="javascript:;">Participantes</a>
                                                </th>
                                                <th>
                                                    <a href="javascript:;">Data</a>
                                                </th>
                                                <th>
                                                    <a href="javascript:;">Nome</a>
                                                </th>
                                                <th>
                                                    <a href="javascript:;">Descrição</a>
                                                </th>
                                                <th>
                                                    <a href="javascript:;">Inscreva-se</a>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0; ?>
                                            @foreach($events as $event)
                                                <tr>
                                                    <td class="table-download">
                                                        <a href="javascript:;" title="Clique para ver os participantes deste evento">
                                                            <i class="fa fa-users font-green-soft"></i>
                                                        </a>
                                                    </td>

                                                    <td class="table-date font-blue">
                                                        <a href="javascript:;">{{ $event->eventDate }}</a>
                                                    </td>
                                                    <td class="table-title">
                                                        <h3>
                                                            <a href="{{ route('event.edit', ['event' => $event->id]) }}">
                                                                {{ $event->name }}
                                                            </a>
                                                        </h3>
                                                        <p>Criado por:
                                                            <a
                                                                    href="{{ route('person.edit',
                                                                    ['person' => \App\Models\User::findOrFail($event->createdBy_id)->person->id]) }}">

                                                                {{ \App\Models\User::findOrFail($event->createdBy_id)->person->name }}
                                                                {{ \App\Models\User::findOrFail($event->createdBy_id)->person->lastName }}
                                                            </a> -
                                                            <span class="font-grey-cascade">{{ $event->created_at }}</span>

                                                        </p>
                                                        <p>
                                                            Grupo:
                                                            
                                                            @if($event->group_id)
                                                                <a href="{{ route('group.edit', ['group' => $event->group_id]) }}">
                                                                    {{ \App\Models\Group::findOrFail($event->group_id)->name }}
                                                                </a>
                                                            @else
                                                                Sem Grupo
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td class="table-desc">
                                                        {{ $event->description }}
                                                    </td>

                                                    @if(count($event_user[0]) == 0))
                                                        <td class="table-status">
                                                            <a href="javascript:;"
                                                               id="btn-sub-{{ $event->id }}" onclick='signUp("{{ $event->id }}")'
                                                               title="Clique aqui para se inscrever">
                                                                <i class="icon-arrow-right font-blue"></i>
                                                            </a>
                                                            <a href="javascript:;" style="display: none;"
                                                               id="btn-unsub-{{ $event->id }}" onclick='signUp("{{ $event->id }}")'
                                                               title="Clique aqui para cancelar sua inscrição">
                                                                <i class="icon-ban font-red"></i>
                                                            </a>
                                                        </td>

                                                        @else
                                                            <td class="table-status">
                                                                <a href="javascript:;"
                                                                   @if(isset($event_user[0][$i]) && $event_user[0][$i]["id"] == $event->id)
                                                                   style="display: none"
                                                                   @else

                                                                   style="display: block;"

                                                                   @endif

                                                                   id="btn-sub-{{ $event->id }}" onclick='signUp("{{ $event->id }}")'
                                                                   title="Clique aqui para se inscrever">
                                                                    <i class="icon-arrow-right font-blue"></i>
                                                                </a>
                                                                <a href="javascript:;"
                                                                   @if(isset($event_user[0][$i]) && $event_user[0][$i]["id"] == $event->id)
                                                                   style="display: block"
                                                                   @else
                                                                   style="display: none;"

                                                                   @endif

                                                                   id="btn-unsub-{{ $event->id }}" onclick='signUp("{{ $event->id }}")'
                                                                   title="Clique aqui para cancelar sua inscrição">
                                                                    <i class="icon-ban font-red"></i>
                                                                </a>
                                                            </td>
                                                    @endif

                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach


                                            <tr>
                                                <td class="table-status">
                                                    <a href="javascript:;">
                                                        <i class="icon-arrow-right font-blue"></i>
                                                    </a>
                                                </td>
                                                <td class="table-date font-blue">
                                                    <a href="javascript:;">17, Out de 2015</a>
                                                </td>
                                                <td class="table-title">
                                                    <h3>
                                                        <a href="javascript:;">Lorem ipsum dolor</a>
                                                    </h3>
                                                    <p>Last Activity:
                                                        <a href="javascript:;">Bob Robson</a> -
                                                        <span class="font-grey-cascade">25 mins ago</span>
                                                    </p>
                                                </td>
                                                <td class="table-desc"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy sead euismod dolore tincidunt ut laoreet dolore dolor sit amet </td>
                                                <td class="table-download">
                                                    <a href="javascript:;">
                                                        <i class="icon-doc font-green-soft"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-status">
                                                    <a href="javascript:;">
                                                        <i class="icon-check font-grey"></i>
                                                    </a>
                                                </td>
                                                <td class="table-date font-blue">
                                                    <a href="javascript:;">October 15, 2015</a>
                                                </td>
                                                <td class="table-title">
                                                    <h3>
                                                        <a href="javascript:;">Typi non habent</a>
                                                    </h3>
                                                    <p>Last Activity:
                                                        <a href="javascript:;">Bob Robson</a> -
                                                        <span class="font-grey-cascade">25 mins ago</span>
                                                    </p>
                                                </td>
                                                <td class="table-desc"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy sead euismod dolore tincidunt ut laoreet dolore dolor sit amet </td>
                                                <td class="table-download">
                                                    <a href="javascript:;">
                                                        <i class="icon-doc font-green-soft"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-status">
                                                    <a href="javascript:;">
                                                        <i class="icon-arrow-right font-blue"></i>
                                                    </a>
                                                </td>
                                                <td class="table-date font-blue">
                                                    <a href="javascript:;">October 12, 2015</a>
                                                </td>
                                                <td class="table-title">
                                                    <h3>
                                                        <a href="javascript:;">Metronic Admin Search Result</a>
                                                    </h3>
                                                    <p>Last Activity:
                                                        <a href="javascript:;">Bob Robson</a> -
                                                        <span class="font-grey-cascade">25 mins ago</span>
                                                    </p>
                                                </td>
                                                <td class="table-desc"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy sead euismod dolore tincidunt ut laoreet dolore dolor sit amet </td>
                                                <td class="table-download">
                                                    <a href="javascript:;">
                                                        <i class="icon-doc font-green-soft"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-status">
                                                    <a href="javascript:;">
                                                        <i class="icon-arrow-right font-blue"></i>
                                                    </a>
                                                </td>
                                                <td class="table-date font-blue">
                                                    <a href="javascript:;">October 11, 2015</a>
                                                </td>
                                                <td class="table-title">
                                                    <h3>
                                                        <a href="javascript:;">Mirum est notare</a>
                                                    </h3>
                                                    <p>Last Activity:
                                                        <a href="javascript:;">Bob Robson</a> -
                                                        <span class="font-grey-cascade">25 mins ago</span>
                                                    </p>
                                                </td>
                                                <td class="table-desc"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy sead euismod dolore tincidunt ut laoreet dolore dolor sit amet </td>
                                                <td class="table-download">
                                                    <a href="javascript:;">
                                                        <i class="icon-doc font-green-soft"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-status">
                                                    <a href="javascript:;">
                                                        <i class="icon-check font-grey"></i>
                                                    </a>
                                                </td>
                                                <td class="table-date font-blue">
                                                    <a href="javascript:;">October 9, 2015</a>
                                                </td>
                                                <td class="table-title">
                                                    <h3>
                                                        <a href="javascript:;">Metronic Admin Reborn</a>
                                                    </h3>
                                                    <p>Last Activity:
                                                        <a href="javascript:;">Bob Robson</a> -
                                                        <span class="font-grey-cascade">25 mins ago</span>
                                                    </p>
                                                </td>
                                                <td class="table-desc"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy sead euismod dolore tincidunt ut laoreet dolore dolor sit amet </td>
                                                <td class="table-download">
                                                    <a href="javascript:;">
                                                        <i class="icon-doc font-green-soft"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-status">
                                                    <a href="javascript:;">
                                                        <i class="icon-check font-grey"></i>
                                                    </a>
                                                </td>
                                                <td class="table-date font-blue">
                                                    <a href="javascript:;">October 9, 2015</a>
                                                </td>
                                                <td class="table-title">
                                                    <h3>
                                                        <a href="javascript:;">Metronic Admin Reborn</a>
                                                    </h3>
                                                    <p>Last Activity:
                                                        <a href="javascript:;">Bob Robson</a> -
                                                        <span class="font-grey-cascade">25 mins ago</span>
                                                    </p>
                                                </td>
                                                <td class="table-desc"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy sead euismod dolore tincidunt ut laoreet dolore dolor sit amet </td>
                                                <td class="table-download">
                                                    <a href="javascript:;">
                                                        <i class="icon-doc font-green-soft"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-status">
                                                    <a href="javascript:;">
                                                        <i class="icon-arrow-right font-blue"></i>
                                                    </a>
                                                </td>
                                                <td class="table-date font-blue">
                                                    <a href="javascript:;">October 6, 2015</a>
                                                </td>
                                                <td class="table-title">
                                                    <h3>
                                                        <a href="javascript:;">Metronic Admin Reborn Progress</a>
                                                    </h3>
                                                    <p>Last Activity:
                                                        <a href="javascript:;">Bob Robson</a> -
                                                        <span class="font-grey-cascade">25 mins ago</span>
                                                    </p>
                                                </td>
                                                <td class="table-desc"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy sead euismod dolore tincidunt ut laoreet dolore dolor sit amet </td>
                                                <td class="table-download">
                                                    <a href="javascript:;">
                                                        <i class="icon-doc font-green-soft"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-status">
                                                    <a href="javascript:;">
                                                        <i class="icon-arrow-right font-blue"></i>
                                                    </a>
                                                </td>
                                                <td class="table-date font-blue">
                                                    <a href="javascript:;">October 3, 2015</a>
                                                </td>
                                                <td class="table-title">
                                                    <h3>
                                                        <a href="javascript:;">Metronic Search Page 5</a>
                                                    </h3>
                                                    <p>Last Activity:
                                                        <a href="javascript:;">Bob Robson</a> -
                                                        <span class="font-grey-cascade">25 mins ago</span>
                                                    </p>
                                                </td>
                                                <td class="table-desc"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy sead euismod dolore tincidunt ut laoreet dolore dolor sit amet </td>
                                                <td class="table-download">
                                                    <a href="javascript:;">
                                                        <i class="icon-doc font-green-soft"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="search-pagination pagination-rounded">
                                        <ul class="pagination">
                                            <li class="page-active">
                                                <a href="javascript:;"> 1 </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;"> 2 </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;"> 3 </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;"> 4 </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- END PAGE CONTENT INNER -->
                        </div>
                    </div>
                    <!-- END PAGE CONTENT BODY -->
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                    <div class="page-quick-sidebar">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Users
                                    <span class="badge badge-danger">2</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data-target="#quick_sidebar_tab_2" data-toggle="tab"> Alerts
                                    <span class="badge badge-success">7</span>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> More
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-bell"></i> Alerts </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-info"></i> Notifications </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-speech"></i> Activities </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-settings"></i> Settings </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                                <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                                    <h3 class="list-heading">Staff</h3>
                                    <ul class="media-list list-items">
                                        <li class="media">
                                            <div class="media-status">
                                                <span class="badge badge-success">8</span>
                                            </div>
                                            <img class="media-object" src="../assets/layouts/layout/img/avatar3.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Bob Nilson</h4>
                                                <div class="media-heading-sub"> Project Manager </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <img class="media-object" src="../assets/layouts/layout/img/avatar1.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Nick Larson</h4>
                                                <div class="media-heading-sub"> Art Director </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-status">
                                                <span class="badge badge-danger">3</span>
                                            </div>
                                            <img class="media-object" src="../assets/layouts/layout/img/avatar4.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Deon Hubert</h4>
                                                <div class="media-heading-sub"> CTO </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <img class="media-object" src="../assets/layouts/layout/img/avatar2.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Ella Wong</h4>
                                                <div class="media-heading-sub"> CEO </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <h3 class="list-heading">Customers</h3>
                                    <ul class="media-list list-items">
                                        <li class="media">
                                            <div class="media-status">
                                                <span class="badge badge-warning">2</span>
                                            </div>
                                            <img class="media-object" src="../assets/layouts/layout/img/avatar6.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Lara Kunis</h4>
                                                <div class="media-heading-sub"> CEO, Loop Inc </div>
                                                <div class="media-heading-small"> Last seen 03:10 AM </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-status">
                                                <span class="label label-sm label-success">new</span>
                                            </div>
                                            <img class="media-object" src="../assets/layouts/layout/img/avatar7.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Ernie Kyllonen</h4>
                                                <div class="media-heading-sub"> Project Manager,
                                                    <br> SmartBizz PTL </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <img class="media-object" src="../assets/layouts/layout/img/avatar8.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Lisa Stone</h4>
                                                <div class="media-heading-sub"> CTO, Keort Inc </div>
                                                <div class="media-heading-small"> Last seen 13:10 PM </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-status">
                                                <span class="badge badge-success">7</span>
                                            </div>
                                            <img class="media-object" src="../assets/layouts/layout/img/avatar9.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Deon Portalatin</h4>
                                                <div class="media-heading-sub"> CFO, H&D LTD </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <img class="media-object" src="../assets/layouts/layout/img/avatar10.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Irina Savikova</h4>
                                                <div class="media-heading-sub"> CEO, Tizda Motors Inc </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-status">
                                                <span class="badge badge-danger">4</span>
                                            </div>
                                            <img class="media-object" src="../assets/layouts/layout/img/avatar11.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Maria Gomez</h4>
                                                <div class="media-heading-sub"> Manager, Infomatic Inc </div>
                                                <div class="media-heading-small"> Last seen 03:10 AM </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="page-quick-sidebar-item">
                                    <div class="page-quick-sidebar-chat-user">
                                        <div class="page-quick-sidebar-nav">
                                            <a href="javascript:;" class="page-quick-sidebar-back-to-list">
                                                <i class="icon-arrow-left"></i>Back</a>
                                        </div>
                                        <div class="page-quick-sidebar-chat-user-messages">
                                            <div class="post out">
                                                <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg" />
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="javascript:;" class="name">Bob Nilson</a>
                                                    <span class="datetime">20:15</span>
                                                    <span class="body"> When could you send me the report ? </span>
                                                </div>
                                            </div>
                                            <div class="post in">
                                                <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg" />
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="javascript:;" class="name">Ella Wong</a>
                                                    <span class="datetime">20:15</span>
                                                    <span class="body"> Its almost done. I will be sending it shortly </span>
                                                </div>
                                            </div>
                                            <div class="post out">
                                                <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg" />
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="javascript:;" class="name">Bob Nilson</a>
                                                    <span class="datetime">20:15</span>
                                                    <span class="body"> Alright. Thanks! :) </span>
                                                </div>
                                            </div>
                                            <div class="post in">
                                                <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg" />
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="javascript:;" class="name">Ella Wong</a>
                                                    <span class="datetime">20:16</span>
                                                    <span class="body"> You are most welcome. Sorry for the delay. </span>
                                                </div>
                                            </div>
                                            <div class="post out">
                                                <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg" />
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="javascript:;" class="name">Bob Nilson</a>
                                                    <span class="datetime">20:17</span>
                                                    <span class="body"> No probs. Just take your time :) </span>
                                                </div>
                                            </div>
                                            <div class="post in">
                                                <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg" />
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="javascript:;" class="name">Ella Wong</a>
                                                    <span class="datetime">20:40</span>
                                                    <span class="body"> Alright. I just emailed it to you. </span>
                                                </div>
                                            </div>
                                            <div class="post out">
                                                <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg" />
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="javascript:;" class="name">Bob Nilson</a>
                                                    <span class="datetime">20:17</span>
                                                    <span class="body"> Great! Thanks. Will check it right away. </span>
                                                </div>
                                            </div>
                                            <div class="post in">
                                                <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg" />
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="javascript:;" class="name">Ella Wong</a>
                                                    <span class="datetime">20:40</span>
                                                    <span class="body"> Please let me know if you have any comment. </span>
                                                </div>
                                            </div>
                                            <div class="post out">
                                                <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg" />
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="javascript:;" class="name">Bob Nilson</a>
                                                    <span class="datetime">20:17</span>
                                                    <span class="body"> Sure. I will check and buzz you if anything needs to be corrected. </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="page-quick-sidebar-chat-user-form">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Type a message here...">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn green">
                                                        <i class="icon-paper-clip"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
                                <div class="page-quick-sidebar-alerts-list">
                                    <h3 class="list-heading">General</h3>
                                    <ul class="feeds list-items">
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-info">
                                                            <i class="fa fa-check"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> You have 4 pending tasks.
                                                            <span class="label label-sm label-warning "> Take action
                                                                        <i class="fa fa-share"></i>
                                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> Just now </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bar-chart-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> Finance Report for year 2013 has been released. </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> 20 mins </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-danger">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 24 mins </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-info">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> New order received with
                                                            <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 30 mins </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 24 mins </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-info">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> Web server hardware needs to be upgraded.
                                                            <span class="label label-sm label-warning"> Overdue </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 2 hours </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-default">
                                                                <i class="fa fa-briefcase"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> IPO Report for year 2013 has been released. </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> 20 mins </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <h3 class="list-heading">System</h3>
                                    <ul class="feeds list-items">
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-info">
                                                            <i class="fa fa-check"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> You have 4 pending tasks.
                                                            <span class="label label-sm label-warning "> Take action
                                                                        <i class="fa fa-share"></i>
                                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> Just now </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-danger">
                                                                <i class="fa fa-bar-chart-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> Finance Report for year 2013 has been released. </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> 20 mins </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-default">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 24 mins </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-info">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> New order received with
                                                            <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 30 mins </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 24 mins </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-warning">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> Web server hardware needs to be upgraded.
                                                            <span class="label label-sm label-default "> Overdue </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 2 hours </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-briefcase"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> IPO Report for year 2013 has been released. </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> 20 mins </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
                                <div class="page-quick-sidebar-settings-list">
                                    <h3 class="list-heading">General Settings</h3>
                                    <ul class="list-items borderless">
                                        <li> Enable Notifications
                                            <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                        <li> Allow Tracking
                                            <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                        <li> Log Errors
                                            <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                        <li> Auto Sumbit Issues
                                            <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                        <li> Enable SMS Alerts
                                            <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                    </ul>
                                    <h3 class="list-heading">System Settings</h3>
                                    <ul class="list-items borderless">
                                        <li> Security Level
                                            <select class="form-control input-inline input-sm input-small">
                                                <option value="1">Normal</option>
                                                <option value="2" selected>Medium</option>
                                                <option value="e">High</option>
                                            </select>
                                        </li>
                                        <li> Failed Email Attempts
                                            <input class="form-control input-inline input-sm input-small" value="5" /> </li>
                                        <li> Secondary SMTP Port
                                            <input class="form-control input-inline input-sm input-small" value="3560" /> </li>
                                        <li> Notify On System Error
                                            <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                        <li> Notify On SMTP Error
                                            <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                    </ul>
                                    <div class="inner-content">
                                        <button class="btn btn-success">
                                            <i class="icon-settings"></i> Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
        </div>
    </div>
    <div class="page-wrapper-row">
        <div class="page-wrapper-bottom">
            <!-- BEGIN FOOTER -->
            <!-- BEGIN PRE-FOOTER -->
            <div class="page-prefooter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                            <h2>About</h2>
                            <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam dolore. </p>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs12 footer-block">
                            <h2>Subscribe Email</h2>
                            <div class="subscribe-form">
                                <form action="javascript:;">
                                    <div class="input-group">
                                        <input type="text" placeholder="mail@email.com" class="form-control">
                                        <span class="input-group-btn">
                                                    <button class="btn" type="submit">Submit</button>
                                                </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                            <h2>Follow Us On</h2>
                            <ul class="social-icons">
                                <li>
                                    <a href="javascript:;" data-original-title="rss" class="rss"></a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-original-title="facebook" class="facebook"></a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-original-title="twitter" class="twitter"></a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-original-title="googleplus" class="googleplus"></a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-original-title="linkedin" class="linkedin"></a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-original-title="youtube" class="youtube"></a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-original-title="vimeo" class="vimeo"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                            <h2>Contacts</h2>
                            <address class="margin-bottom-40"> Phone: 800 123 3456
                                <br> Email:
                                <a href="mailto:info@metronic.com">info@metronic.com</a>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PRE-FOOTER -->
            <!-- BEGIN INNER FOOTER -->
            <div class="page-footer">
                <div class="container"> 2016 &copy; Metronic Theme By
                    <a target="_blank" href="http://keenthemes.com">Keenthemes</a> &nbsp;|&nbsp;
                    <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase Metronic!</a>
                </div>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
            <!-- END INNER FOOTER -->
            <!-- END FOOTER -->
        </div>
    </div>
</div>
<!-- BEGIN QUICK NAV -->
<nav class="quick-nav">
    <a class="quick-nav-trigger" href="#0">
        <span aria-hidden="true"></span>
    </a>
    <ul>
        <li>
            <a href="https://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" target="_blank" class="active">
                <span>Purchase Metronic</span>
                <i class="icon-basket"></i>
            </a>
        </li>
        <li>
            <a href="https://themeforest.net/item/metronic-responsive-admin-dashboard-template/reviews/4021469?ref=keenthemes" target="_blank">
                <span>Customer Reviews</span>
                <i class="icon-users"></i>
            </a>
        </li>
        <li>
            <a href="http://keenthemes.com/showcast/" target="_blank">
                <span>Showcase</span>
                <i class="icon-user"></i>
            </a>
        </li>
        <li>
            <a href="http://keenthemes.com/metronic-theme/changelog/" target="_blank">
                <span>Changelog</span>
                <i class="icon-graph"></i>
            </a>
        </li>
    </ul>
    <span aria-hidden="true" class="quick-nav-bg"></span>
</nav>
<div class="quick-nav-overlay"></div>
<!-- END QUICK NAV -->
@include('includes.core-scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../assets/pages/scripts/search.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
    function newEvent()
    {
        window.location.href = "/events/create";
    }

    function closeButton()
    {
        $(this).css("display", "none");
    }


    function signUp(id)
    {
        var request = $.ajax({
            url: '/events/signUp/' + id,
            method: 'POST',
            data: id,
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                $("#alert-success").css('display', 'block');
                $("#btn-unsub-"+id).css('display', 'block');
                $("#btn-sub-"+id).css('display', 'none');
            }
            else{
                $("#alert-info").css('display', 'block');
                $("#btn-unsub-"+id).css('display', 'none');
                $("#btn-sub-"+id).css('display', 'block');
            }
        });

        request.fail(function (e) {
            $("#alert-danger").css('display', 'block');
        });

        return false;
    }

</script>

</body>

</html>