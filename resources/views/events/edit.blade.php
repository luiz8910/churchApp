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
    <script src="../../js/ajax.js"></script>
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
                                        <img src="../../uploads/profile/noimage.png" class="img-responsive" alt="">
                                    </div>
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name"> {{ $event->name }}</div>
                                        <div class="profile-usertitle-job"> {{ $event->eventDate }} </div>
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

                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content">
                                <!--<div class="row">-->
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

                                        </div>
                                    </div>
                                    <!-- END BASIC PORTLET-->
                                </div>
                                <!--</div>-->

                            </div>
                            <!-- END PROFILE CONTENT -->
                            </div>


                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Eventos</span>
                                    </div>
                                    <div class="actions">
                                        {!! Form::open(['route' => 'event.destroyMany', 'id' => 'form-destroyMany', 'method' => 'GET']) !!}
                                        <div class="btn-group btn-group-devided">

                                            <div id="modelToDel">

                                            </div>

                                            <a href=""
                                               class="btn btn-danger btn-circle" id="btn-delete-model"
                                               onclick="event.preventDefault();document.getElementById('form-destroyMany').submit();"
                                               style="display: none;">
                                                <i class="fa fa-close"></i>
                                                Excluir
                                            </a>


                                            <a href="javascript:;" class="btn btn-success btn-circle" id="checkIn" onclick='checkInEvent({{ $event->id }})'>
                                                <i class="fa fa-check" id="i-checkIn"></i>
                                                Check-In
                                            </a>

                                            <a href="javascript:;" class="btn btn-primary btn-circle">
                                                <i class="fa fa-plus"></i>
                                                Evento
                                            </a>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light table-striped">
                                            <thead>
                                            <tr class="uppercase">
                                                <th>
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" name="events" class="checkboxes check-model" id="check-1"
                                                               value="1" />
                                                        <span></span>
                                                    </label>
                                                </th>
                                                <th> Nome </th>
                                                @foreach($eventDays as $day)
                                                    <th>{{ $day->eventDate }}</th>
                                                @endforeach
                                                <th>Frequência</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach($eventPeople as $item)
                                                    <tr>
                                                        <td>
                                                            @if(Auth::getUser()->person->role_id == 1)
                                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                    <input type="checkbox" name="events" class="checkboxes check-model" id="check-1"
                                                                           value="1" />
                                                                    <span></span>
                                                                </label>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('person.edit', ['person' => $item->person_id]) }}">
                                                                {{ $item->name }}
                                                            </a>

                                                        </td>

                                                        @while($i < count($eventFrequency))
                                                            @if($item->person_id == $eventFrequency[$i]->person_id)
                                                                <td>
                                                                    @if($eventFrequency[$i]->$check == 1)
                                                                        <i class="fa fa-check green"></i>
                                                                        @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                            @endif
                                                                <?php $i++; ?>
                                                        @endwhile

                                                        <?php $i = 0; ?>

                                                        <td>{{ number_format($item->frequency * 100, 2) }} %</td>

                                                    </tr>
                                                @endforeach

                                            </tbody>

                                        </table>




                                    </div>
                                </div>


                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">Dados do Evento</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">
                                    {!! Form::open(['route' => ['event.update', 'event' => $event->id], 'method' => 'PUT', 'role' => 'form']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>
                                                        <input type="text" name="name" class="form-control"
                                                               placeholder="Encontro de Jovens" value="{{ $event->name }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="frequency" class="
                                                    @if($event->frequency == "Semanal" || $event->frequency == "Mensal")
                                                        col-md-3
                                                    @else
                                                        col-md-6
                                                    @endif">
                                                <div class="form-group">
                                                    <label>Frequência</label>
                                                    <div class="input-icon input-icon-sm">
                                                        <i class="fa fa-briefcase"></i>
                                                        <select class="form-control" name="frequency" id="select-frequency">
                                                            <option value="Encontro Único"
                                                            @if($event->frequency == "Encontro Único") selected @endif
                                                                >Encontro Único
                                                            </option>
                                                            <option value="Diário"
                                                                    @if($event->frequency == "Diário") selected @endif>
                                                                Diário
                                                            </option>
                                                            <option value="Semanal"
                                                                    @if($event->frequency == "Semanal") selected @endif
                                                            >Semanal</option>
                                                            <option value="Quinzenal"
                                                                    @if($event->frequency == "Quinzenal") selected @endif
                                                            >Quinzenal</option>
                                                            <option value="Mensal"
                                                                    @if($event->frequency == "Mensal") selected @endif
                                                            >Mensal</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            @if($event->frequency == "Semanal")
                                                <div class="col-md-3" id="day">
                                                    <div class="form-group">
                                                        <label>Selecione o dia da semana</label>
                                                        <div class="input-icon input-icon-sm">
                                                            <i class="fa fa-briefcase"></i>
                                                            <select class="form-control" name="day" required>
                                                                <option value="Domingo"
                                                                    @if($event->day == "Domingo") selected @endif
                                                                >Domingo</option>
                                                                <option value="Segunda-Feira"
                                                                        @if($event->day == "Segunda-Feira") selected @endif
                                                                >Segunda-Feira</option>

                                                                <option value="Terça-Feira"
                                                                @if($event->day == "Terça-Feira") selected @endif
                                                                >Terça-Feira</option>

                                                                <option value="Quarta-Feira"
                                                                @if($event->day == "Quarta-Feira") selected @endif
                                                                >Quarta-Feira</option>

                                                                <option value="Quinta-Feira"
                                                                @if($event->day == "Quinta-Feira") selected @endif
                                                                >Quinta-Feira</option>

                                                                <option value="Sexta-Feira"
                                                                @if($event->day == "Sexta-Feira") selected @endif
                                                                >Sexta-Feira</option>

                                                                <option value="Sábado"
                                                                @if($event->day == "Sábado") selected @endif
                                                                >Sábado</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif


                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Data do Próximo/Primeiro Encontro</label>
                                                    <div class="input-group date date-picker" data-date-format="dd/mm/yyyy" data-date-start-date="+0d">

                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" class="form-control" name="eventDate" id="eventDate" readonly value="{{ $event->eventDate }}">
                                                    </div>
                                                    <span class="help-block">
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" name="allDay" id="allDay" class="checkboxes" value="1"
                                                                   @if($event->allDay == 1) checked @endif />
                                                            <span></span>Dia Inteiro
                                                        </label>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Término do Evento</label>

                                                    <div class="input-group date date-picker" data-date-format="dd/mm/yyyy" data-date-start-date="+0d">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                                        <input type="text" class="form-control" name="endEventDate" id="endEventDate" readonly value="{{ $event->endEventDate }}">
                                                    </div>
                                                    <!-- /input-group -->
                                                    <span class="help-block"> Deixe em branco se a data de término é a mesma da data de ínicio </span>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Hora Inicio</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-clock-o font-blue"></i>
                                                            </span>

                                                        <select name="startTime" class="form-control" required>
                                                            <option value="">Selecione</option>
                                                            <option value="00:00"
                                                                @if($event->startTime == "00:00") selected @endif
                                                            >00:00</option>
                                                            <option value="01:00"
                                                                @if($event->startTime == "01:00") selected @endif
                                                            >01:00</option>
                                                            <option value="02:00"
                                                                    @if($event->startTime == "02:00") selected @endif
                                                            >02:00</option>
                                                            <option value="03:00"
                                                                    @if($event->startTime == "03:00") selected @endif
                                                            >03:00</option>
                                                            <option value="04:00"
                                                                    @if($event->startTime == "04:00") selected @endif
                                                            >04:00</option>
                                                            <option value="05:00"
                                                                    @if($event->startTime == "05:00") selected @endif
                                                            >05:00</option>
                                                            <option value="06:00"
                                                                    @if($event->startTime == "06:00") selected @endif
                                                            >06:00</option>
                                                            <option value="07:00"
                                                                    @if($event->startTime == "07:00") selected @endif
                                                            >07:00</option>
                                                            <option value="08:00"
                                                                    @if($event->startTime == "08:00") selected @endif
                                                            >08:00</option>
                                                            <option value="09:00"
                                                                    @if($event->startTime == "09:00") selected @endif
                                                            >09:00</option>
                                                            <option value="10:00"
                                                                    @if($event->startTime == "10:00") selected @endif
                                                            >10:00</option>
                                                            <option value="11:00"
                                                                    @if($event->startTime == "11:00") selected @endif
                                                            >11:00</option>
                                                            <option value="12:00"
                                                                    @if($event->startTime == "12:00") selected @endif
                                                            >12:00</option>
                                                            <option value="13:00"
                                                                    @if($event->startTime == "13:00") selected @endif
                                                            >13:00</option>
                                                            <option value="14:00"
                                                                    @if($event->startTime == "14:00") selected @endif
                                                            >14:00</option>
                                                            <option value="15:00"
                                                                    @if($event->startTime == "15:00") selected @endif
                                                            >15:00</option>
                                                            <option value="16:00"
                                                                    @if($event->startTime == "16:00") selected @endif
                                                            >16:00</option>
                                                            <option value="17:00"
                                                                    @if($event->startTime == "17:00") selected @endif
                                                            >17:00</option>
                                                            <option value="18:00"
                                                                    @if($event->startTime == "18:00") selected @endif
                                                            >18:00</option>
                                                            <option value="19:00"
                                                                    @if($event->startTime == "19:00") selected @endif
                                                            >19:00</option>
                                                            <option value="20:00"
                                                                    @if($event->startTime == "20:00") selected @endif
                                                            >20:00</option>
                                                            <option value="21:00"
                                                                    @if($event->startTime == "21:00") selected @endif
                                                            >21:00</option>
                                                            <option value="22:00"
                                                                    @if($event->startTime == "22:00") selected @endif
                                                            >22:00</option>
                                                            <option value="23:00"
                                                                    @if($event->startTime == "23:00") selected @endif
                                                            >23:00</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Hora Fim</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-clock-o font-blue"></i>
                                                            </span>

                                                        <select name="endTime" class="form-control" id="">
                                                            @if($event->endTime == null)
                                                                <option value="">Selecione</option>
                                                                <option value="00:00">00:00</option>
                                                                <option value="01:00">01:00</option>
                                                                <option value="02:00">02:00</option>
                                                                <option value="03:00">03:00</option>
                                                                <option value="04:00">04:00</option>
                                                                <option value="05:00">05:00</option>
                                                                <option value="06:00">06:00</option>
                                                                <option value="07:00">07:00</option>
                                                                <option value="08:00">08:00</option>
                                                                <option value="09:00">09:00</option>
                                                                <option value="10:00">10:00</option>
                                                                <option value="11:00">11:00</option>
                                                                <option value="12:00">12:00</option>
                                                                <option value="13:00">13:00</option>
                                                                <option value="14:00">14:00</option>
                                                                <option value="15:00">15:00</option>
                                                                <option value="16:00">16:00</option>
                                                                <option value="17:00">17:00</option>
                                                                <option value="18:00">18:00</option>
                                                                <option value="19:00">19:00</option>
                                                                <option value="20:00">20:00</option>
                                                                <option value="21:00">21:00</option>
                                                                <option value="22:00">22:00</option>
                                                                <option value="23:00">23:00</option>

                                                                @else

                                                                <option value="">Em Branco</option>
                                                                <option value="00:00"
                                                                        @if($event->endTime == "00:00") selected @endif
                                                                >00:00</option>
                                                                <option value="01:00"
                                                                        @if($event->endTime == "01:00") selected @endif
                                                                >01:00</option>
                                                                <option value="02:00"
                                                                        @if($event->endTime == "02:00") selected @endif
                                                                >02:00</option>
                                                                <option value="03:00"
                                                                        @if($event->endTime == "03:00") selected @endif
                                                                >03:00</option>
                                                                <option value="04:00"
                                                                        @if($event->endTime == "04:00") selected @endif
                                                                >04:00</option>
                                                                <option value="05:00"
                                                                        @if($event->endTime == "05:00") selected @endif
                                                                >05:00</option>
                                                                <option value="06:00"
                                                                        @if($event->endTime == "06:00") selected @endif
                                                                >06:00</option>
                                                                <option value="07:00"
                                                                        @if($event->endTime == "07:00") selected @endif
                                                                >07:00</option>
                                                                <option value="08:00"
                                                                        @if($event->endTime == "08:00") selected @endif
                                                                >08:00</option>
                                                                <option value="09:00"
                                                                        @if($event->endTime == "09:00") selected @endif
                                                                >09:00</option>
                                                                <option value="10:00"
                                                                        @if($event->endTime == "10:00") selected @endif
                                                                >10:00</option>
                                                                <option value="11:00"
                                                                        @if($event->endTime == "11:00") selected @endif
                                                                >11:00</option>
                                                                <option value="12:00"
                                                                        @if($event->endTime == "12:00") selected @endif
                                                                >12:00</option>
                                                                <option value="13:00"
                                                                        @if($event->endTime == "13:00") selected @endif
                                                                >13:00</option>
                                                                <option value="14:00"
                                                                        @if($event->endTime == "14:00") selected @endif
                                                                >14:00</option>
                                                                <option value="15:00"
                                                                        @if($event->endTime == "15:00") selected @endif
                                                                >15:00</option>
                                                                <option value="16:00"
                                                                        @if($event->endTime == "16:00") selected @endif
                                                                >16:00</option>
                                                                <option value="17:00"
                                                                        @if($event->endTime == "17:00") selected @endif
                                                                >17:00</option>
                                                                <option value="18:00"
                                                                        @if($event->endTime == "18:00") selected @endif
                                                                >18:00</option>
                                                                <option value="19:00"
                                                                        @if($event->endTime == "19:00") selected @endif
                                                                >19:00</option>
                                                                <option value="20:00"
                                                                        @if($event->endTime == "20:00") selected @endif
                                                                >20:00</option>
                                                                <option value="21:00"
                                                                        @if($event->endTime == "21:00") selected @endif
                                                                >21:00</option>
                                                                <option value="22:00"
                                                                        @if($event->endTime == "22:00") selected @endif
                                                                >22:00</option>
                                                                <option value="23:00"
                                                                        @if($event->endTime == "23:00") selected @endif
                                                                >23:00</option>
                                                            @endif
                                                        </select>

                                                    </div>
                                                    <span class="help-block">Deixe em branco caso o término não esteja previsto</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                {!! Form::FormGroup('description', $errors) !!}
                                                <label class="control-label">Descrição</label>
                                                <textarea class="form-control" name="description"
                                                          placeholder="Digite aqui observações importantes sobre o evento"
                                                          rows="5" >{{ $event->description }}</textarea>
                                                {!! Form::error('description', $errors) !!}
                                                {!! Form::endFormGroup() !!}
                                            </div>
                                        </div>


                                        <h3>Endereço</h3>

                                        <div class="loader"></div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>CEP (sem traços)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-location-arrow font-purple"></i>
                                                        </span>
                                                        <input type="text" class="form-control" name="zipCode"
                                                               value="{{ $event->zipCode }}" id="zipCode" placeholder="XXXXX-XXX">
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
                                                        <input class="form-control" name="street" type="text" id="street"
                                                               value="{{ $event->street }}" placeholder="Av. Antonio Carlos Comitre, 650">
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
                                                        <input class="form-control" name="neighborhood" id="neighborhood" type="text"
                                                               value="{{ $event->neighborhood }}" placeholder="Parque do Dolly">
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
                                                        <input class="form-control" name="city" id="city" type="text"
                                                               value="{{ $event->city }}" placeholder="Sorocaba">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Estado</label>
                                                    <select name="state" class="form-control" id="state">
                                                        <option value="">Selecione</option>
                                                        @foreach($state as $item)
                                                            <option value="{{ $item->initials }}"
                                                            @if($item->initials == $event->state) selected @endif >
                                                                {{ $item->state }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        {!! Form::submit('Enviar', ['class' => 'btn blue']) !!}
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

@include('includes.core-scripts-edit')

<script src="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/moment.min.js" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script src="../../assets/global/plugins/gmaps/gmaps.min.js" type="text/javascript"></script>

<script src="../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
        type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script src="../../js/maps.js"></script>


<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjTs0nbQbEecUygnKpThLfzRKES8nKS0A&callback=initMap"></script>


</body>

</html>