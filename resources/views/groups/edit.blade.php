<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.5.3
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
@include('includes.head-edit')

<!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet"
          type="text/css"/>
    <link href="../../assets/pages/css/profile.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet"
          type="text/css"/>
    <link href="../../assets/global/plugins/typeahead/typeahead.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-boxed">
<!-- BEGIN HEADER -->
@include('includes.header-edit')
<!-- END HEADER -->

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
                    <h1>Perfil do Usuário
                        <small></small>
                    </h1>
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
                        <a href="{{ route('index') }}">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Minha Conta</span>
                    </li>
                </ul>
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->
                @if(Session::has('updateUser'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        {{ Session::get('updateUser') }}
                    </div>
                @endif

                @if(Session::has('group.deleteMember'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        {{ Session::get('group.deleteMember') }}
                    </div>
                @endif
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <div class="profile-sidebar">
                                <!-- PORTLET MAIN -->
                                <div class="portlet light profile-sidebar-portlet ">
                                    <!-- SIDEBAR USERPIC -->
                                    <div class="profile-userpic">
                                        <img src="../../{{ $group->imgProfile }}" class="img-responsive" alt="">
                                    </div>
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name"> {{ $group->name }}</div>
                                        <div class="profile-usertitle-job"> {{ $group->frequency }} </div>
                                        <div class="profile-usertitle-job"> {{ $group->sinceOf }} </div>
                                    </div>
                                    <!-- END SIDEBAR USER TITLE -->

                                    <!-- SIDEBAR MENU -->
                                    <div class="profile-usermenu">
                                        <ul class="nav">
                                            <li class="active">
                                                <a href="">
                                                    <i class="icon-home"></i> Visão Geral </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <i class="icon-info"></i> Detalhes </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- END MENU -->
                                </div>
                                <!-- END PORTLET MAIN -->

                            </div>
                            <!-- END BEGIN PROFILE SIDEBAR -->


                            <!-- BEGIN PAGE CONTENT INNER -->
                            <div class="page-content-inner">
                                <!--<div class="row">-->
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <div class="portlet light portlet-fit ">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="icon-directions font-green hide"></i>
                                                    <span class="caption-subject bold font-dark uppercase "> Eventos</span>
                                                    <span class="caption-helper"></span>
                                                </div>
                                                <div class="actions">
                                                    <div class="btn-group">
                                                        <a class="btn blue btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Ações
                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="{{ route('group.event.create', ['id' => $group->id]) }}">Novo Evento</a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="javascript:;">Action 2</a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;">Action 3</a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;">Action 4</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="cd-horizontal-timeline mt-timeline-horizontal" data-spacing="60">
                                                    <div class="timeline">
                                                        <div class="events-wrapper">
                                                            <div class="events">
                                                                <ol>
                                                                    <?php $i = 0; ?>
                                                                    @foreach($events as $event)
                                                                        <li>
                                                                            <a href="#0" data-date="{{ $event->eventDate }}"
                                                                               class="border-after-red bg-after-red
                                                                               @if($i == 0) selected @endif">{{ substr($event->eventDate, 0, 5) }}</a>
                                                                        </li>
                                                                        <?php $i++; ?>
                                                                    @endforeach
                                                                </ol>
                                                                <span class="filling-line bg-red" aria-hidden="true"></span>
                                                            </div>
                                                            <!-- .events -->
                                                        </div>
                                                        <!-- .events-wrapper -->
                                                        <ul class="cd-timeline-navigation mt-ht-nav-icon">
                                                            <li>
                                                                <a href="#0" class="prev inactive btn btn-outline red md-skip">
                                                                    <i class="fa fa-chevron-left"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#0" class="next btn btn-outline red md-skip">
                                                                    <i class="fa fa-chevron-right"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <!-- .cd-timeline-navigation -->
                                                    </div>
                                                    <!-- .timeline -->
                                                    <div class="events-content">
                                                        <ol>
                                                            <?php $i = 0; ?>

                                                            @foreach($events as $event)
                                                                <li class="@if($i == 0) selected @endif" data-date="{{ $event->eventDate }}">
                                                            <div class="mt-title">
                                                                <h2 class="mt-content-title">{{ $event->name }}</h2>
                                                            </div>
                                                            <div class="mt-author">
                                                                <div class="mt-avatar">
                                                                    <img src="../../{{ \App\Models\User::findOrFail($event->createdBy_id)->person->imgProfile }}"
                                                                         title="Criador do Evento" />
                                                                </div>
                                                                <div class="mt-author-name">
                                                                    <a href="javascript:;" class="font-blue-madison">
                                                                        {{ \App\Models\User::findOrFail($event->createdBy_id)->person->name }}
                                                                        {{ \App\Models\User::findOrFail($event->createdBy_id)->person->lastName }}
                                                                    </a>
                                                                </div>
                                                                @if($event->endEventDate == $event->eventDate)
                                                                <div class="mt-author-datetime font-grey-mint">
                                                                    Inicia-se em: {{ $event->eventDate }} - {{ $event->startTime }}h {{ $event->endTime or '' }}
                                                                </div>
                                                                @else
                                                                    <div class="mt-author-datetime font-grey-mint">
                                                                        Inicia-se em: {{ $event->eventDate }} - {{ $event->startTime }}h {{ $event->endTime or '' }}
                                                                    </div>
                                                                    <div class="mt-author-datetime font-grey-mint">
                                                                        Termina em: {{ $event->endEventDate }} - {{ $event->endTime or '' }}
                                                                    </div>
                                                                @endif

                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="mt-content border-grey-steel">
                                                                <p>{{ $event->description }}</p>
                                                                <a href="javascript:;" class="btn btn-circle red btn-outline">
                                                                    <i class="fa fa-users"></i>Lista de Participantes
                                                                </a>

                                                                <a href="" class="btn btn-circle green">
                                                                    <i class="fa fa-sign-in"></i>Participar
                                                                </a>
                                                            </div>
                                                        </li>

                                                                    <?php $i++; ?>
                                                            @endforeach
                                                        </ol>
                                                    </div>
                                                    <!-- .events-content -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <!--</div> Fim div row -->
                            </div>
                            <!-- END PAGE CONTENT INNER -->

                        </div>
                    </div>



                    <!-- BEGIN PROFILE CONTENT -->
                    <div class="profile-content">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN BASIC PORTLET-->
                                <div class="portlet light portlet-fit ">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class=" icon-layers font-red"></i>
                                            <span class="caption-subject font-red bold uppercase">Local do Evento</span>
                                        </div>
                                        <div class="actions">
                                            <a class="btn btn-circle btn-icon-only btn-default"
                                               href="javascript:;">
                                                <i class="icon-cloud-upload"></i>
                                            </a>
                                            <a class="btn btn-circle btn-icon-only btn-default"
                                               href="javascript:;">
                                                <i class="icon-wrench"></i>
                                            </a>
                                            <a class="btn btn-circle btn-icon-only btn-default"
                                               href="javascript:;">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div id="map" style="height: 304px; width: 100%;"></div>

                                        <input type="hidden" value="{{ $location }}" id="location">

                                        <?php $i = 0; ?>

                                        @foreach($address as $location)
                                            <input type="hidden" value="{{ $location }}" id="location-{{ $i }}">
                                            <?php $i++; ?>
                                        @endforeach

                                        <input type="hidden" value="{{ $i }}" id="qtdeMember">

                                        <input type="hidden" id="lat">
                                        <input type="hidden" id="lng">

                                        <input type="hidden" id="person-0" value="{{ $group->name }}">

                                        <?php $i = 1; ?>
                                        @foreach($members as $person)
                                            <input type="hidden"
                                                   value="{{ $person->name }} {{ $person->lastName }}"
                                                   id="person-{{ $i }}">
                                            <input type="hidden" value="{{ $person->role_id }}"
                                                   id="role-{{ $i }}">
                                            <?php $i++; ?>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- END BASIC PORTLET-->
                            </div>
                        </div>

                    </div>
                    <!-- END PROFILE CONTENT -->

                    <!-- BEGIN PROFILE CONTENT -->
                    <div class="profile-content">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN CHART PORTLET-->
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-bar-chart font-green-haze"></i>
                                            <span class="caption-subject bold uppercase font-green-haze"> 3D Pie Chart</span>
                                            <span class="caption-helper">bar and line chart mix</span>
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse"> </a>
                                            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                            <a href="javascript:;" class="reload"> </a>
                                            <a href="javascript:;" class="fullscreen"> </a>
                                            <a href="javascript:;" class="remove"> </a>
                                        </div>


                                        <input type="hidden" id="singleMother_qty_chart_label" value="Mulheres solteiras com filhos">
                                        <input type="hidden" id="singleMother_qty_chart_value" value="{{ $quantitySingleMother }}">

                                        <input type="hidden" id="singleFather_qty_chart_label" value="Homens solteiros com filhos">
                                        <input type="hidden" id="singleFather_qty_chart_value" value="{{ $quantitySingleFather }}">

                                        <input type="hidden" id="singleWomen_qty_chart_label" value="Mulheres solteiras">
                                        <input type="hidden" id="singleWomen_qty_chart_value" value="{{ $quantitySingleWomen }}">

                                        <input type="hidden" id="singleMen_qty_chart_label" value="Homens solteiros">
                                        <input type="hidden" id="singleMen_qty_chart_value" value="{{ $quantitySingleMen }}">

                                        <input type="hidden" id="marriedWomenNoKids_qty_chart_label" value="Mulheres casadas sem filhos">
                                        <input type="hidden" id="marriedWomenNoKids_qty_chart_value" value="{{ $quantityMarriedWomenNoKids }}">

                                        <input type="hidden" id="marriedMenNoKids_qty_chart_label" value="Homens casados sem filhos">
                                        <input type="hidden" id="marriedMenNoKids_qty_chart_value" value="{{ $quantityMarriedMenNoKids }}">

                                        <input type="hidden" id="marriedMenOutsideChurch_qty_chart_label" value="Homens casados com parceira fora da igreja">
                                        <input type="hidden" id="marriedMenOutsideChurch_qty_chart_value" value="{{ $quantityMarriedMenOutsideChurch }}">

                                        <input type="hidden" id="marriedWomenOutsideChurch_qty_chart_label" value="Mulheres casadas com parceiro fora da igreja">
                                        <input type="hidden" id="marriedWomenOutsideChurch_qty_chart_value" value="{{ $quantityMarriedWomenOutsideChurch }}">

                                    </div>
                                    <div class="portlet-body">
                                        <div id="chart_7" class="chart" style="height: 400px;"> </div>
                                        <div class="well margin-top-20">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="text-left">Top Radius:</label>
                                                    <input class="chart_7_chart_input" data-property="topRadius" type="range" min="0" max="1.5" value="1" step="0.01" /> </div>
                                                <div class="col-sm-3">
                                                    <label class="text-left">Angle:</label>
                                                    <input class="chart_7_chart_input" data-property="angle" type="range" min="0" max="89" value="30" step="1" /> </div>
                                                <div class="col-sm-3">
                                                    <label class="text-left">Depth:</label>
                                                    <input class="chart_7_chart_input" data-property="depth3D" type="range" min="1" max="120" value="40" step="1" /> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END CHART PORTLET-->
                            </div>
                        </div>

                    </div>
                    <!-- END PROFILE CONTENT -->

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject bold uppercase"> Membros</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle"
                                                       id="option1">Actions</label>
                                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn sbold green" data-toggle="modal"
                                                            id="sample_editable_1_new" data-target="#myModal">
                                                        <i class="fa fa-plus"></i> Novo
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            id="sample_editable_1_new" data-target="#addMemberModal">
                                                        <i class="fa fa-user"></i> Novo Membro
                                                    </button>
                                                </div>
                                            </div>


                                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                                 aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content form">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close"><span
                                                                        aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Atribuir membros
                                                                a {{ $group->name }}</h4>
                                                        </div>

                                                        {!! Form::open(['route' => ['group.addMembers', 'group' => $group],
                                                                'class' => 'form-horizontal form-row-seperated', 'method' => 'POST']) !!}
                                                        <div class="modal-body form">
                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label">Membros</label>
                                                                <div class="col-sm-9">
                                                                    <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-user"></i>
                                                                            </span>
                                                                        <select id="select_members"
                                                                                class="bs-select form-control"
                                                                                data-live-search="true" data-size="8">
                                                                            @foreach($people as $person)
                                                                                <option value="{{ $person->id }}">{{ $person->name }} {{ $person->lastName}}</option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                    <p class="help-block"> Escolha um membro </p>

                                                                    <button type="button" id="addMember"
                                                                            class="btn btn-primary pull-right">Incluir
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label">Membros
                                                                    Escolhidos</label>
                                                                <div class="col-sm-9">
                                                                    <div class="input-group">
                                                                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                                        <div class="portlet light ">

                                                                            <div class="portlet-body">
                                                                                <div class="table-scrollable">
                                                                                    <table class="table table-hover table-striped table-bordered"
                                                                                           id="table_name">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th> Nome do Membro</th>
                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>

                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- END SAMPLE TABLE PORTLET-->

                                                                        <!--<input type="text" id="typeahead_example_modal_2" name="typeahead_example_modal_2" class="form-control" />-->
                                                                    </div>
                                                                    <p class="help-block"> Para excluir, clique no nome
                                                                        do membro </code>
                                                                    </p>

                                                                    <br>

                                                                    <div id="hidden-input">

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Fechar
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Salvar
                                                            </button>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog"
                                                 aria-labelledby="addMemberModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close"><span
                                                                        aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Adicionar novo
                                                                Membro ao Grupo</h4>
                                                        </div>

                                                        {!! Form::open(['route' => ['group.newMember', 'group' => $group],
                                                                'class' => 'form-horizontal form-row-seperated', 'method' => 'POST']) !!}
                                                        <div class="modal-body" style="margin-left: 10px;">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <div class="form-group">
                                                                        <br>
                                                                        <label>Nome</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-user font-blue"></i>
                                                                            </span>
                                                                            <input type="text" name="name"
                                                                                   class="form-control"
                                                                                   placeholder="Entre com o nome aqui">
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <br>
                                                                        <label>Email</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-envelope font-blue"></i>
                                                                            </span>
                                                                            <input type="email" name="email"
                                                                                   class="form-control"
                                                                                   placeholder="Entre com o email aqui">
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <br>
                                                                        <label>Telefone</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-phone font-blue"></i>
                                                                            </span>
                                                                            <input type="text" name="tel"
                                                                                   class="form-control"
                                                                                   placeholder="Entre com o telefone aqui">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>


                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Fechar</button>
                                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="btn-group pull-right">
                                                    <button class="btn green  btn-outline dropdown-toggle"
                                                            data-toggle="dropdown">Opções
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;">
                                                                <i class="fa fa-print"></i> Print </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                           id="sample_1">
                                        <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" class="group-checkable"
                                                       data-set="#sample_1 .checkboxes"/></th>
                                            <th> Nome</th>
                                            <th> Email</th>
                                            <th> Telefone</th>
                                            <th> Celular</th>
                                            <th> Opções</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($members as $person)
                                            <tr class="odd gradeX">
                                                <td>
                                                    <input type="checkbox" class="checkboxes" value="1"/></td>
                                                <td>
                                                    <a href="{{ route('person.edit', ['person' => $person->id]) }}">
                                                        {{ $person->name }} {{ $person->lastName }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="mailto:{{ $person->user->email or null }}"> {{ $person->user->email or null }} </a>
                                                </td>
                                                <td> {{ $person->tel }} </td>
                                                <td class="center"> {{ $person->cel }} </td>
                                                <!--<span class="label label-sm label-success"> Aprovado </span>-->

                                                <?php $deleteForm = "delete-" . $person->id; ?>
                                                <td id="{{ $deleteForm }}">
                                                    {!! Form::open(['route' => ['group.deleteMember', 'group' => $group->id, 'member' => $person->id],
                                                            'method' => 'DELETE', 'id' => 'form-'.$deleteForm]) !!}

                                                    <a href="" class="btn btn-danger btn-sm"
                                                       title="Excluir membro do grupo"
                                                       onclick='event.preventDefault();document.getElementById("form-{{ $deleteForm }}").submit();'>
                                                        <i class="fa fa-close"></i>
                                                    </a>

                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">Dados do Grupo</span>
                                    </div>

                                </div>
                                <div class="portlet-body">
                                    {!! Form::open(['route' => ['group.update', 'group' => $group->id], 'method' => 'PUT', 'class' => 'repeater', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <br>
                                                    <label>Nome</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>
                                                        <input type="text" name="name" class="form-control"
                                                               value="{{ $group->name }}" placeholder="Grupo de Jovens">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"><br>
                                                    <label>Frequência</label>
                                                    <div class="input-icon input-icon-sm">
                                                        <i class="fa fa-briefcase"></i>
                                                        <select class="form-control" name="frequency">
                                                            <option value="">Selecione</option>
                                                            <option value="Diário"
                                                                    @if($group->frequency == 'Diário') selected @endif >
                                                                Diário
                                                            </option>
                                                            <option value="Semanal"
                                                                    @if($group->frequency == 'Semanal') selected @endif >
                                                                Semanal
                                                            </option>
                                                            <option value="Quinzenal"
                                                                    @if($group->frequency == 'Quinzenal') selected @endif >
                                                                Quinzenal
                                                            </option>
                                                            <option value="Mensal"
                                                                    @if($group->frequency == 'Mensal') selected @endif >
                                                                Mensal
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Data de Criação</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar font-blue"></i>
                                                            </span>
                                                        <input type="text" class="form-control" name="sinceOf"
                                                               value="{{ $group->sinceOf }}" placeholder="dd/mm/aaaa">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <h3>Endereço</h3>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>CEP</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-location-arrow font-purple"></i>
                                                        </span>
                                                        <input type="text" class="form-control" name="zipCode"
                                                               value="{{ $group->zipCode }}" placeholder="XXXXX-XXX">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Logradouro</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-home font-purple"></i>
                                                    </span>
                                                        <input class="form-control" name="street" type="text"
                                                               value="{{ $group->street }}"
                                                               placeholder="Av. Antonio Carlos Comitre, 650">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Bairro</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-home font-purple"></i>
                                                    </span>
                                                        <input class="form-control" name="neighborhood" type="text"
                                                               value="{{ $group->neighborhood }}"
                                                               placeholder="Parque do Dolly">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Cidade</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-building font-purple"></i>
                                                    </span>
                                                        <input class="form-control" name="city" type="text"
                                                               value="{{ $group->city }}" placeholder="Sorocaba">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Estado</label>
                                                    <select name="state" class="form-control">
                                                        <option value="">Selecione</option>
                                                        @foreach($state as $item)
                                                            <option value="{{ $item->initials }}"
                                                                    @if($item->initials == $group->state) selected @endif >
                                                                {{ $item->state }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail"
                                                             style="width: 200px; height: 150px;">
                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=foto+do+perfil"
                                                                 alt=""/></div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                                             style="max-width: 200px; max-height: 150px;"></div>
                                                        <div>
                                                                <span class="btn default btn-file">
                                                                    <span class="fileinput-new"> Escolher Imagem </span>
                                                                    <span class="fileinput-exists"> Alterar </span>
                                                                    <input type="file" name="img"> </span>
                                                            <a href="javascript:;" class="btn default fileinput-exists"
                                                               data-dismiss="fileinput"> Remover </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="margiv-top-10">
                                        {!! Form::submit('Salvar', ['class' => 'btn green']) !!}
                                        <a href="javascript:;" class="btn default"> Cancelar </a>
                                    </div>
                                    {!! Form::close() !!}


                                </div>
                            </div>
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
                    <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd"
                         data-wrapper-class="page-quick-sidebar-list">
                        <h3 class="list-heading">Staff</h3>
                        <ul class="media-list list-items">
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-success">8</span>
                                </div>
                                <img class="media-object" src="../assets/layouts/layout/img/avatar3.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Bob Nilson</h4>
                                    <div class="media-heading-sub"> Project Manager</div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="../assets/layouts/layout/img/avatar1.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Nick Larson</h4>
                                    <div class="media-heading-sub"> Art Director</div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-danger">3</span>
                                </div>
                                <img class="media-object" src="../assets/layouts/layout/img/avatar4.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Deon Hubert</h4>
                                    <div class="media-heading-sub"> CTO</div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="../assets/layouts/layout/img/avatar2.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Ella Wong</h4>
                                    <div class="media-heading-sub"> CEO</div>
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
                                    <div class="media-heading-sub"> CEO, Loop Inc</div>
                                    <div class="media-heading-small"> Last seen 03:10 AM</div>
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
                                        <br> SmartBizz PTL
                                    </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="../assets/layouts/layout/img/avatar8.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Lisa Stone</h4>
                                    <div class="media-heading-sub"> CTO, Keort Inc</div>
                                    <div class="media-heading-small"> Last seen 13:10 PM</div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-success">7</span>
                                </div>
                                <img class="media-object" src="../assets/layouts/layout/img/avatar9.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Deon Portalatin</h4>
                                    <div class="media-heading-sub"> CFO, H&D LTD</div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="../assets/layouts/layout/img/avatar10.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Irina Savikova</h4>
                                    <div class="media-heading-sub"> CEO, Tizda Motors Inc</div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-danger">4</span>
                                </div>
                                <img class="media-object" src="../assets/layouts/layout/img/avatar11.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Maria Gomez</h4>
                                    <div class="media-heading-sub"> Manager, Infomatic Inc</div>
                                    <div class="media-heading-small"> Last seen 03:10 AM</div>
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
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg"/>
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:15</span>
                                        <span class="body"> When could you send me the report ? </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg"/>
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:15</span>
                                        <span class="body"> Its almost done. I will be sending it shortly </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg"/>
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:15</span>
                                        <span class="body"> Alright. Thanks! :) </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg"/>
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:16</span>
                                        <span class="body"> You are most welcome. Sorry for the delay. </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg"/>
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:17</span>
                                        <span class="body"> No probs. Just take your time :) </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg"/>
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:40</span>
                                        <span class="body"> Alright. I just emailed it to you. </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg"/>
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:17</span>
                                        <span class="body"> Great! Thanks. Will check it right away. </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg"/>
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:40</span>
                                        <span class="body"> Please let me know if you have any comment. </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar3.jpg"/>
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
                                    <div class="date"> Just now</div>
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
                                                <div class="desc"> Finance Report for year 2013 has been released.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins</div>
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
                                            <div class="desc"> You have 5 pending membership that requires a quick
                                                review.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins</div>
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
                                    <div class="date"> 30 mins</div>
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
                                            <div class="desc"> You have 5 pending membership that requires a quick
                                                review.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins</div>
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
                                    <div class="date"> 2 hours</div>
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
                                                <div class="desc"> IPO Report for year 2013 has been released.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins</div>
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
                                    <div class="date"> Just now</div>
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
                                                <div class="desc"> Finance Report for year 2013 has been released.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins</div>
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
                                            <div class="desc"> You have 5 pending membership that requires a quick
                                                review.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins</div>
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
                                    <div class="date"> 30 mins</div>
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
                                            <div class="desc"> You have 5 pending membership that requires a quick
                                                review.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins</div>
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
                                    <div class="date"> 2 hours</div>
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
                                                <div class="desc"> IPO Report for year 2013 has been released.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins</div>
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
                                <input type="checkbox" class="make-switch" checked data-size="small"
                                       data-on-color="success" data-on-text="ON" data-off-color="default"
                                       data-off-text="OFF"></li>
                            <li> Allow Tracking
                                <input type="checkbox" class="make-switch" data-size="small" data-on-color="info"
                                       data-on-text="ON" data-off-color="default" data-off-text="OFF"></li>
                            <li> Log Errors
                                <input type="checkbox" class="make-switch" checked data-size="small"
                                       data-on-color="danger" data-on-text="ON" data-off-color="default"
                                       data-off-text="OFF"></li>
                            <li> Auto Sumbit Issues
                                <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning"
                                       data-on-text="ON" data-off-color="default" data-off-text="OFF"></li>
                            <li> Enable SMS Alerts
                                <input type="checkbox" class="make-switch" checked data-size="small"
                                       data-on-color="success" data-on-text="ON" data-off-color="default"
                                       data-off-text="OFF"></li>
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
                                <input class="form-control input-inline input-sm input-small" value="5"/></li>
                            <li> Secondary SMTP Port
                                <input class="form-control input-inline input-sm input-small" value="3560"/></li>
                            <li> Notify On System Error
                                <input type="checkbox" class="make-switch" checked data-size="small"
                                       data-on-color="danger" data-on-text="ON" data-off-color="default"
                                       data-off-text="OFF"></li>
                            <li> Notify On SMTP Error
                                <input type="checkbox" class="make-switch" checked data-size="small"
                                       data-on-color="warning" data-on-text="ON" data-off-color="default"
                                       data-off-text="OFF"></li>
                        </ul>
                        <div class="inner-content">
                            <button class="btn btn-success">
                                <i class="icon-settings"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
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
    <div class="container"> 2014 &copy; Metronic by keenthemes.
        <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes"
           title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase
            Metronic!</a>
    </div>
</div>
<div class="scroll-to-top">
    <i class="icon-arrow-up"></i>
</div>
<!-- END INNER FOOTER -->
<!-- END FOOTER -->

<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"
        type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="../../js/script.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>

<script src="../../assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="../../assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/charts-amcharts.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/horizontal-timeline/horizontal-timeline.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME../ LAYOUT SCRIPTS -->
<script src="../../assets/layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
<script src="../../assets/layouts/layout3/scripts/demo.min.js" type="text/javascript"></script>
<script src="../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="../../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->

<script src="../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
        type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script src="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script src="../../assets/global/plugins/gmaps/gmaps.min.js" type="text/javascript"></script>

<script src="../../assets/pages/scripts/profile.min.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/timeline.min.js" type="text/javascript"></script>


<script src="../../assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>





<!-- END PAGE LEVEL SCRIPTS -->
<script>
    $.ajaxSetup({
        async: false
    });

    function initMap() {
        groupMap();
        addressMembers();
    }

    function groupMap() {

        var location = $('#location').val();

        var script = 'https://maps.googleapis.com/maps/api/geocode/json?address=' + location + '&key=AIzaSyCz22xAk7gDzvTEXjqjL8Goxu_q12Gt_KU';

        $.getJSON(script, function (json) {
            var lat = json.results[0].geometry.location.lat;
            var lng = json.results[0].geometry.location.lng;

            localStorage.setItem('lat', lat);
            localStorage.setItem('lng', lng);

        });

        var lat = parseFloat(localStorage.getItem('lat'));
        var lng = parseFloat(localStorage.getItem('lng'));

        var uluru = {lat: lat, lng: lng};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 11,
            center: uluru
        });

        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });


        localStorage.setItem('lat', '');
        localStorage.setItem('lng', '');

        $("#lat").text(lat);
        $("#lng").text(lng);
    }

    function addressMembers() {
        var locations = [];
        var qtde = parseInt($("#qtdeMember").val());
        var lat = parseFloat($("#lat").text());
        var lng = parseFloat($("#lng").text());

        locations.push(lat);
        locations.push(lng);

        for (var i = 0; i < qtde; i++) {
            var address = $("#location-" + i).val();

            var script = 'https://maps.googleapis.com/maps/api/geocode/json?address=' + address + '&key=AIzaSyCz22xAk7gDzvTEXjqjL8Goxu_q12Gt_KU';
            //alert('script: ' + script);

            $.getJSON(script, function (json) {
                var lat = json.results[0].geometry.location.lat;
                var lng = json.results[0].geometry.location.lng;

                localStorage.setItem('lat', lat);
                localStorage.setItem('lng', lng);

                //alert('lat: ' + localStorage.getItem('lat'));

            });

            locations.push((localStorage.getItem('lat')));
            locations.push((localStorage.getItem('lng')));
        }
        //alert('locations: ' + locations);

        setMarkers(locations);

    }

    function setMarkers(locations) {
        var lat = parseFloat($("#lat").text());
        var lng = parseFloat($("#lng").text());
        var infowindow = new google.maps.InfoWindow();
        var k = 0;

        //alert('lat: ' + lat + ' lng: ' + lng);
        var uluru = {lat: lat, lng: lng};

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 11,
            center: uluru
        });

        for (var i = 0; i < locations.length; i++) {
            var position = {lat: parseFloat(locations[i]), lng: parseFloat(locations[i + 1])};

            var marker = new google.maps.Marker({
                position: position,
                map: map,
                icon: $("#role-" + k).val() == 1 ?
                        new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/icons/blue-dot.png")
                        : ''
            });


            google.maps.event.addListener(marker, 'click', (function (marker, k) {
                return function () {
                    infowindow.setContent($("#person-" + k).val());
                    infowindow.open(map, marker);
                }
            })(marker, k));

            i++;
            k++;
        }
    }

    //-23.5142994
    //-47.4623199

    //-23.5365557
    //-47.4129715

</script>


<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjTs0nbQbEecUygnKpThLfzRKES8nKS0A&callback=initMap"></script>
</body>

</html>