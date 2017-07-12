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
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    @include('includes.head')

</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-boxed">
@include('includes.header')
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
                    <h1>Dashboard
                        <small>Resumo Geral</small>
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
                        <span>Dashboard</span>
                    </li>
                </ul>
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    {{--<div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Atividades Recentes</span>
                                        <span class="caption-helper">Hoje</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">Hoje</label>
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Semana</label>
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Mês</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                            <tr class="uppercase">
                                                <th colspan="2"> Membro </th>
                                                <th> Email </th>
                                                <th> Telefone </th>
                                                <th> Ult. Edição por</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td class="fit">
                                                    <img class="user-pic rounded" src="assets/pages/media/users/avatar4.jpg"> </td>
                                                <td>
                                                    <a href="page_user_profile_1.html" class="primary-link">João da Silva</a>
                                                </td>
                                                <td> joao.silva@suaigreja.com.br </td>
                                                <td> (15) 9 9123-4567 </td>
                                                <td>
                                                    <span class="bold theme-font">Administrador</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fit">
                                                    <img class="user-pic rounded" src="assets/pages/media/users/avatar5.jpg"> </td>
                                                <td>
                                                    <a href="page_user_profile_1.html" class="primary-link">José Ferreira</a>
                                                </td>
                                                <td> jose.ferreira@suaigreja.com.br </td>
                                                <td> (15) 9 9123-4567 </td>
                                                <td>
                                                    <span class="bold theme-font">Administrador</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fit">
                                                    <img class="user-pic rounded" src="assets/pages/media/users/avatar6.jpg"> </td>
                                                <td>
                                                    <a href="page_user_profile_1.html" class="primary-link">Timóteo Junqueira</a>
                                                </td>
                                                <td> tim.junqueira@suaigreja.com.br </td>
                                                <td> (15) 9 9123-4567 </td>
                                                <td>
                                                    <span class="bold theme-font">Administrador</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fit">
                                                    <img class="user-pic rounded" src="assets/pages/media/users/avatar7.jpg"> </td>
                                                <td>
                                                    <a href="page_user_profile_1.html" class="primary-link">Bartolomeu dos Santos</a>
                                                </td>
                                                <td> bart.santos@suaigreja.com.br </td>
                                                <td> (15) 9 9123-4567 </td>
                                                <td>
                                                    <span class="bold theme-font">Administrador</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>--}}

                    <br><br>

                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="page-content-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN BORDERED TABLE PORTLET-->
                                <div class="portlet light portlet-fit ">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-settings font-red"></i>
                                            <span class="caption-subject font-red sbold uppercase">Meus Grupos</span>
                                        </div>
                                        <div class="actions">
                                            <div class="btn-group btn-group-devided">
                                                <a role="button" class="btn btn-info btn-circle" href="{{ route('group.create') }}" style="margin-top: 2px;">
                                                    <i class="fa fa-plus"></i>
                                                    <span class="hidden-xs hidden-sm">Novo Grupo</span>
                                                </a>

                                            </div>
                                            <div class="btn-group">
                                                <a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
                                                    <i class="fa fa-share"></i>
                                                    <span class="hidden-xs"> Opções </span>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-menu pull-right" id="sample_3_tools">
                                                    <li>
                                                        <a href="javascript:;" data-action="0" class="tool-action">
                                                            <i class="icon-printer"></i> Imprimir</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" data-action="1" class="tool-action">
                                                            <i class="icon-check"></i> Copiar</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" data-action="2" class="tool-action">
                                                            <i class="icon-doc"></i> PDF</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" data-action="3" class="tool-action">
                                                            <i class="icon-paper-clip"></i> Excel</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" data-action="4" class="tool-action">
                                                            <i class="icon-cloud-upload"></i> CSV</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable table-scrollable-borderless">
                                            <table class="table table-hover table-light">
                                                <thead>
                                                <tr class="uppercase">
                                                    <th> Foto </th>
                                                    <th> Nome </th>
                                                    <th> Inicio em </th>
                                                    <th> Participantes </th>
                                                    <th> Opções </th>

                                                </tr>
                                                </thead>

                                                <input type="hidden" id="person_id" value="{{ Auth::getUser()->person_id }}">

                                                <tbody>
                                                    @if($groups)
                                                        <?php $i = 0; ?>
                                                        @foreach($groups as $item)
                                                            <tr>
                                                                <td> <img src="{{ $item->imgProfile }}" style="width: 50px; height: 50px;"> </td>
                                                                <td> <a href="{{ route('group.edit', ['group' => $item->id]) }}"> {{ $item->name }}</a></td>
                                                                <td> {{ $item->sinceOf }} </td>
                                                                <td> <span class="badge badge-info">{{ $countMembers[$i] }}</span></td>

                                                                @if(Auth::getUser()->person)


                                                                    <?php $deleteForm = "delete-" . $item->id; ?>
                                                                    <td>

                                                                        <a href="" class="btn btn-danger btn-sm btn-circle pop-leave-group"
                                                                           title="Excluir membro do grupo"
                                                                           data-toggle="confirmation" data-placement="top" data-original-title="Deseja Excluir?"
                                                                           data-popout="true" onclick="event.preventDefault()"
                                                                           id="btn-{{ $deleteForm }}">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>


                                                                    </td>

                                                                @endif

                                                            </tr>
                                                            <?php $i++; ?>
                                                        @endforeach

                                                    @endif
                                                </tbody>
                                            </table>
                                            <br>
                                            <div class="pull-right">
                                                @if($groups) {{ $groups->links() }} @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END BORDERED TABLE PORTLET-->
                            </div>
                        </div>

                    </div>
                    <!-- END PAGE CONTENT INNER -->

                    <br><br>

                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="page-content-inner">
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
                                            <div class="btn-group btn-group-devided">
                                                <a role="button" class="btn btn-info btn-circle" href="{{ route('event.create') }}" style="margin-top: 2px;">
                                                    <i class="fa fa-plus"></i>
                                                    <span class="hidden-xs hidden-sm">Novo Evento</span>
                                                </a>

                                            </div>
                                            <div class="btn-group">
                                                <a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
                                                    <i class="fa fa-share"></i>
                                                    <span class="hidden-xs"> Opções </span>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-menu pull-right" id="sample_3_tools">
                                                    <li>
                                                        <a href="javascript:;" data-action="0" class="tool-action">
                                                            <i class="icon-printer"></i> Imprimir</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" data-action="1" class="tool-action">
                                                            <i class="icon-check"></i> Copiar</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" data-action="2" class="tool-action">
                                                            <i class="icon-doc"></i> PDF</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" data-action="3" class="tool-action">
                                                            <i class="icon-paper-clip"></i> Excel</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" data-action="4" class="tool-action">
                                                            <i class="icon-cloud-upload"></i> CSV</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable table-scrollable-borderless">
                                            <table class="table table-hover table-light">
                                                <thead>
                                                <tr class="uppercase">
                                                    <th> Criado Por</th>
                                                    <th> Nome </th>
                                                    <th> Próximo Encontro em </th>
                                                    <th> Pertence ao Grupo </th>

                                                </tr>
                                                </thead>

                                                <input type="hidden" id="person_id" value="{{ Auth::getUser()->person_id }}">

                                                <tbody>
                                                @if($events)
                                                    <?php $i = 0; ?>
                                                    @foreach($event_person as $item)
                                                        <tr>
                                                            <td>
                                                                <span class="hidden-xs hidden-sm">
                                                                    @if(Auth::user()->id != $events[$i]->createdBy_id)
                                                                        <a href="{{ route('person.edit', ['person' => $events[$i]->createdBy_id]) }}">
                                                                            <img src="{{ '../'.$events[$i]->imgProfileUser }}"
                                                                                 class="img-circle" style="height: 50px; width: 50px; margin-right: 10px;">

                                                                            {{ $events[$i]->createdBy_name }}
                                                                        </a>

                                                                        @else
                                                                            <img src="{{ '../'.$events[$i]->imgProfileUser }}"
                                                                                 class="img-circle" style="height: 50px; width: 50px; margin-right: 10px;">

                                                                            {{ $events[$i]->createdBy_name }}
                                                                    @endif
                                                                </span>
                                                                <span class="hidden-md hidden-lg" >
                                                                    @if(Auth::user()->id != $events[$i]->createdBy_id)
                                                                        <a href="{{ route('person.edit', ['person' => $events[$i]->createdBy_id]) }}">
                                                                            <img src="{{ '../'.$events[$i]->imgProfileUser }}"
                                                                                 class="img-circle" style="height: 30px; width: 30px;">

                                                                            {{ $events[$i]->createdBy_name }}
                                                                        </a>

                                                                    @else
                                                                        <img src="{{ '../'.$events[$i]->imgProfileUser }}"
                                                                             class="img-circle" style="height: 30px; width: 30px;">

                                                                        {{ $events[$i]->createdBy_name }}
                                                                    @endif
                                                                </span>

                                                            </td>
                                                            <td> <a href="{{ route('event.edit', ['event' => $item->id]) }}"> {{ $item->name }}</a></td>
                                                            <td>
                                                                @if(isset($eventDate[$i]->eventDate))
                                                                    {{ $eventDate[$i]->eventDate }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(isset($item->group_name))
                                                                    <a href="{{ route('group.edit', ['group' => $item->group_id]) }}">
                                                                        {{ $item->group_name }}
                                                                    </a>
                                                                @else
                                                                    Sem Grupo
                                                                @endif
                                                            </td>

                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach

                                                @endif
                                                </tbody>
                                            </table>
                                            <br>
                                            <div class="pull-right">
                                                {{ $events->links() }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- END BORDERED TABLE PORTLET-->
                            </div>
                        </div>

                    </div>
                    <!-- END PAGE CONTENT INNER -->


                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light portlet-fit calendar">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class=" icon-layers font-green"></i>
                                        <span class="caption-subject font-green sbold uppercase ">Agenda</span>

                                    </div>
                                    <div class="actions" style="margin-bottom: 25px;">
                                        <div class="btn-group">
                                            <a class="btn blue btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown"
                                               data-hover="dropdown" data-close-others="true"> Ações
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="{{ route('event.create') }}">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        Novo Evento
                                                    </a>
                                                </li>
                                                <li class="divider"> </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                                        Exportar para Excel
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                        Exportar para .PDF
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-print" aria-hidden="true"></i>
                                                        Imprimir
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-clipboard" aria-hidden="true"></i>
                                                        Copiar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                @if(count($events) > 0)
                                    <div class="portlet-body">
                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="thisMonth">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($days), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" id="btnThisRight" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" id="btnThisLeft" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($days))
                                                            <tr>
                                                                <td @if(date("Y-m-d") == $days[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($days[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $days[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $days[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($days[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $days[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $days[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($days[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $days[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $days[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($days[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $days[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $days[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($days[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $days[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $days[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($days[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $days[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $days[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($days[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $days[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- This Month -->
                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="nextMonth" style="display: none;">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($nextMonth), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" id="btnNextRight" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" id="btnNextLeft" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($nextMonth))
                                                            <tr>
                                                                <td @if(date("Y-m-d") == $nextMonth[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($nextMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($nextMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($nextMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($nextMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($nextMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($nextMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth[$i]) class="today-back" @endif>
                                                                    <h6>{{ substr($nextMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Next Month  -->

                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="nextMonth2" style="display: none;">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($nextMonth2), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" id="btnNextRight2" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" id="btnNextLeft2" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($nextMonth2))
                                                            <tr>
                                                                <td @if(date("Y-m-d") == $nextMonth2[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth2[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth2[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth2[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth2[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth2[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth2[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Next Month 2 -->

                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="nextMonth3" style="display: none;">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($nextMonth3), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" id="btnNextRight3" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" id="btnNextLeft3" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($nextMonth3))
                                                            <tr>
                                                                <td @if(date("Y-m-d") == $nextMonth3[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth3[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth3[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth3[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth3[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth3[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth3[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Next Month 3 -->

                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="nextMonth4" style="display: none;">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($nextMonth4), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" id="btnNextRight4" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" id="btnNextLeft4" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($nextMonth4))
                                                            <tr>
                                                                <td @if(date("Y-m-d") == $nextMonth4[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth4[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth4[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth4[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth4[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth4[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth4[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Next Month 4 -->

                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="nextMonth5" style="display: none;">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($nextMonth5), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" id="btnNextRight5" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" id="btnNextLeft5" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($nextMonth5))
                                                            <tr>
                                                                <td @if(date("Y-m-d") == $nextMonth5[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth5[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth5[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth5[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth5[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth5[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth5[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Next Month 5 -->

                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="nextMonth6" style="display: none;">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($nextMonth6), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" id="btnNextLeft6" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($nextMonth6))
                                                            <tr>
                                                                <td @if(date("Y-m-d") == $nextMonth6[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth6[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth6[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth6[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth6[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth6[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td @if(date("Y-m-d") == $nextMonth6[$i]) style="background-color: #FFFFEE;" @endif>
                                                                    <h6>{{ substr($nextMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $nextMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Next Month 6 -->

                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="prevMonth6" style="display: none;">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($prevMonth6), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" id="btnPrevRight6" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($prevMonth6))
                                                            <tr>
                                                                <td>
                                                                    <h6>{{ substr($prevMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth6[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth6[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Prev Month 6 -->

                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="prevMonth5" style="display:none;">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($prevMonth5), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" id="btnPrevRight5" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" id="btnPrevLeft5" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($prevMonth5))
                                                            <tr>
                                                                <td>
                                                                    <h6>{{ substr($prevMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth5[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth5[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Prev Month 5 -->

                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="prevMonth4" style="display:none;">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($prevMonth4), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" id="btnPrevRight4" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" id="btnPrevLeft4" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($prevMonth4))
                                                            <tr>
                                                                <td>
                                                                    <h6>{{ substr($prevMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth4[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth4[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Prev Month 4 -->

                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="prevMonth3" style="display:none;">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($prevMonth3), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" id="btnPrevRight3" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" id="btnPrevLeft3" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($prevMonth3))
                                                            <tr>
                                                                <td>
                                                                    <h6>{{ substr($prevMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth3[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth3[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Prev Month 3 -->

                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="prevMonth2" style="display:none;">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($prevMonth2), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" id="btnPrevRight2" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" id="btnPrevLeft2" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($prevMonth2))
                                                            <tr>
                                                                <td>
                                                                    <h6>{{ substr($prevMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth2[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth2[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Prev Month 2 -->

                                    <div class="row desktop-row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default" id="prevMonth" style="display:none;">
                                                <div class="panel-heading desktop">
                                                    <?php $i = 0; ?>
                                                    <h5>Próximos Eventos -
                                                        @while($i < count($allMonths))
                                                            @if($i == (int) substr(end($prevMonth), 5, 2))
                                                                {{ $allMonths[$i] }}
                                                            @endif
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    </h5>
                                                    <a href="javascript:;" id="btnPrevRight" class="btn btn-default btn-sm btn-circle pull-right">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="javascript:;" id="btnPrevLeft" class="btn btn-default btn-sm btn-circle pull-right" style="margin-right: 33px;">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-striped table-responsive" id="table-fixed">
                                                        <thead class="thead-agenda">
                                                        <tr>
                                                            <th>Segunda</th>
                                                            <th>Terça</th>
                                                            <th>Quarta</th>
                                                            <th>Quinta</th>
                                                            <th>Sexta</th>
                                                            <th>Sábado</th>
                                                            <th>Domingo</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody class="tbody-agenda-desktop">

                                                        <?php $i = 0; ?>
                                                        <?php $x = 0; ?>

                                                        @while($i < count($prevMonth))
                                                            <tr>
                                                                <td>
                                                                    <h6>{{ substr($prevMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>


                                                                <td>
                                                                    <h6>{{ substr($prevMonth[$i], 8) }}</h6>

                                                                    @while($x < count($allEvents))
                                                                        @if($allEvents[$x]->eventDate == $prevMonth[$i])
                                                                            <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                                {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                            </label>

                                                                            <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                                        @endif
                                                                        <?php $x++; ?>
                                                                    @endwhile
                                                                </td>


                                                                <?php $i++; ?>
                                                                <?php $x = 0; ?>

                                                            </tr>

                                                        @endwhile
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Prev Month  -->

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>

                                    <div class="row agenda mobile" id="agenda-mobile">
                                        @while($i < count($days))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile @if(date("Y-m-d") == $days[$i]) today-back @endif">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($days[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($days[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $days[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile


                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>

                                    <div class="row agenda" style="display: none;" id="nextMonth-mobile">
                                        @while($i < count($nextMonth))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($nextMonth[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($nextMonth[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $nextMonth[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile
                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>

                                    <div class="row agenda" style="display: none;" id="nextMonth2-mobile">
                                        @while($i < count($nextMonth2))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($nextMonth2[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($nextMonth2[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $nextMonth2[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile
                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>

                                    <div class="row agenda" style="display: none;" id="nextMonth3-mobile">
                                        @while($i < count($nextMonth3))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($nextMonth3[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($nextMonth3[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $nextMonth3[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile
                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>

                                    <div class="row agenda" style="display: none;" id="nextMonth4-mobile">
                                        @while($i < count($nextMonth4))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($nextMonth4[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($nextMonth4[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $nextMonth4[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile
                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>

                                    <div class="row agenda" style="display: none;" id="nextMonth5-mobile">
                                        @while($i < count($nextMonth5))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($nextMonth5[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($nextMonth5[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $nextMonth5[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile
                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>

                                    <div class="row agenda" style="display: none;" id="nextMonth6-mobile">
                                        @while($i < count($nextMonth6))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($nextMonth6[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($nextMonth6[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $nextMonth6[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile
                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>

                                    <div class="row agenda" style="display: none;" id="prevMonth-mobile">
                                        @while($i < count($prevMonth))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($prevMonth[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($prevMonth[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $prevMonth[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile
                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>

                                    <div class="row agenda" style="display: none;" id="prevMonth2-mobile">
                                        @while($i < count($prevMonth2))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($prevMonth2[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($prevMonth2[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $prevMonth2[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile
                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>

                                    <div class="row agenda" style="display: none;" id="prevMonth3-mobile">
                                        @while($i < count($prevMonth3))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($prevMonth3[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($prevMonth3[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $prevMonth3[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile
                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>


                                    <div class="row agenda" style="display: none;" id="prevMonth4-mobile">
                                        @while($i < count($prevMonth4))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($prevMonth4[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($prevMonth4[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $prevMonth4[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile
                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>


                                    <div class="row agenda" style="display: none;" id="prevMonth5-mobile">
                                        @while($i < count($prevMonth5))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($prevMonth5[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($prevMonth5[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $prevMonth5[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile
                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>

                                    <div class="row agenda" style="display: none;" id="prevMonth6-mobile">
                                        @while($i < count($prevMonth6))
                                            <div class="col-md-12">
                                                <div class="panel panel-default panel-mobile">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">

                                                            {{ $allDays[
                                                                date_format(date_create($prevMonth6[$i]), 'N')
                                                            ] }}
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <small class="pull-right day-panel-mobile"> {{ substr($prevMonth6[$i], 8) }}</small><br>
                                                        @while($x < count($allEvents))
                                                            @if($allEvents[$x]->eventDate == $prevMonth6[$i])
                                                                <label onclick="goToEvent({{ $allEvents[$x]->event_id }})">
                                                                    {{ \App\Models\Event::find($allEvents[$x]->event_id)->name }}
                                                                </label>

                                                                <h5>{{ \App\Models\Event::find($allEvents[$x]->event_id)->startTime }}h</h5>
                                                            @endif
                                                            <?php $x++; ?>
                                                        @endwhile
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>
                                        @endwhile
                                    </div>

                                    <?php $i = 0; ?>
                                    <?php $x = 0; ?>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <br>
                    <div class="row">

                        @if(Auth::getUser()->person)
                            <div class="col-md-6">
                            <!-- BEGIN BASIC PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class=" icon-layers font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Próximo Evento - dia {{ $nextEvent[1] }}</span>
                                    </div>
                                    <div class="actions">
                                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                            <i class="icon-cloud-upload"></i>
                                        </a>
                                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                            <i class="icon-wrench"></i>
                                        </a>
                                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                            <i class="icon-trash"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="map" style="height: 320px; width: 100%;"></div>

                                    <input type="hidden" value="@if(isset($location)) {{ $location }} @endif" id="location">

                                    <input type="hidden" name="street" id="street"
                                           value="@if(isset($location)) {{ $event->name }} - {{ $street }} @endif">
                                </div>
                            </div>
                            <!-- END BASIC PORTLET-->
                        </div>
                            @else
                            <div class="col-md-6">
                                <!-- BEGIN BASIC PORTLET-->
                                <div class="portlet light portlet-fit ">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class=" icon-layers font-red"></i>
                                            <span class="caption-subject font-red bold uppercase">Local do Evento</span>
                                        </div>
                                        <div class="actions">
                                            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                <i class="icon-cloud-upload"></i>
                                            </a>
                                            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                <i class="icon-wrench"></i>
                                            </a>
                                            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div id="map" style="height: 320px; width: 100%;"></div>
                                    </div>
                                </div>
                                <!-- END BASIC PORTLET-->
                            </div>

                        @endif

                        <div class="col-md-6 col-sm-6">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-globe font-green-sharp"></i>
                                        <span class="caption-subject font-green-sharp bold uppercase">Feeds</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" class="active" data-toggle="tab"> Geral </a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_2" data-toggle="tab"> Outros </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <!--BEGIN TABS-->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1_1">
                                            <div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
                                                <ul class="feeds">
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-success">
                                                                        <i class="fa fa-bell-o"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc"> Célula de Casais (Jorge e Lígia).
                                                                                <span class="label label-sm label-info"> Ver mais
                                                                                    <i class="fa fa-share"></i>
                                                                                </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date"> Agora </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> Pedido de oração anônimo: "Ore por minha família nessa semana" </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"> 20 min </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-danger">
                                                                        <i class="fa fa-bolt"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        Teremos almoço comunitário nesse domingo. Não deixe de levar seu prato e aproveitar o tempo com os irmãos.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date"> 24 min </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-info">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc"> Pedido de oração por Alberto Fiochi : "Ore pelo Brasil!" </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date"> 30 min </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-success">
                                                                        <i class="fa fa-bullhorn"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">
                                                                        <a href="page_user_profile_1.html">
                                                                            Novo usuário registrado : "João da Silva"
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date"> 40 min </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-warning">
                                                                        <i class="fa fa-plus"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc"> Acampamento de Jovens em 04/2017 - Inscreva-se já! </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date"> 2 dias </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_1_2">
                                            <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                                                <ul class="feeds">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> New user registered </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"> Just now </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> New order received </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"> 10 mins </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-danger">
                                                                        <i class="fa fa-bolt"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc"> Order #24DOP4 has been rejected.
                                                                                <span class="label label-sm label-danger "> Take action
                                                                                    <i class="fa fa-share"></i>
                                                                                </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date"> 24 mins </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> New user registered </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"> Just now </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> New user registered </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"> Just now </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> New user registered </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"> Just now </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> New user registered </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"> Just now </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> New user registered </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"> Just now </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> New user registered </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"> Just now </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> New user registered </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"> Just now </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--END TABS-->
                                </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-red">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject bold uppercase">Frequência</span>
                                        <span class="caption-helper">Culto</span>
                                    </div>
                                    <div class="actions">
                                        <a href="#" class="btn btn-circle green btn-outline btn-sm">
                                            <i class="fa fa-pencil"></i> Exportar </a>
                                        <a href="#" class="btn btn-circle green btn-outline btn-sm">
                                            <i class="fa fa-print"></i> Imprimir </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="chartdiv" style="width: 100%; height: 400px;"></div>
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
                    <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                        <h3 class="list-heading">Staff</h3>
                        <ul class="media-list list-items">
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-success">8</span>
                                </div>
                                <img class="media-object" src="assets/layouts/layout/img/avatar3.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Bob Nilson</h4>
                                    <div class="media-heading-sub"> Project Manager </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="assets/layouts/layout/img/avatar1.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Nick Larson</h4>
                                    <div class="media-heading-sub"> Art Director </div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-danger">3</span>
                                </div>
                                <img class="media-object" src="assets/layouts/layout/img/avatar4.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Deon Hubert</h4>
                                    <div class="media-heading-sub"> CTO </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="assets/layouts/layout/img/avatar2.jpg" alt="...">
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
                                <img class="media-object" src="assets/layouts/layout/img/avatar6.jpg" alt="...">
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
                                <img class="media-object" src="assets/layouts/layout/img/avatar7.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Ernie Kyllonen</h4>
                                    <div class="media-heading-sub"> Project Manager,
                                        <br> SmartBizz PTL </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="assets/layouts/layout/img/avatar8.jpg" alt="...">
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
                                <img class="media-object" src="assets/layouts/layout/img/avatar9.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Deon Portalatin</h4>
                                    <div class="media-heading-sub"> CFO, H&D LTD </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="media-object" src="assets/layouts/layout/img/avatar10.jpg" alt="...">
                                <div class="media-body">
                                    <h4 class="media-heading">Irina Savikova</h4>
                                    <div class="media-heading-sub"> CEO, Tizda Motors Inc </div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-status">
                                    <span class="badge badge-danger">4</span>
                                </div>
                                <img class="media-object" src="assets/layouts/layout/img/avatar11.jpg" alt="...">
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
                                    <img class="avatar" alt="" src="assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:15</span>
                                        <span class="body"> When could you send me the report ? </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:15</span>
                                        <span class="body"> Its almost done. I will be sending it shortly </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:15</span>
                                        <span class="body"> Alright. Thanks! :) </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:16</span>
                                        <span class="body"> You are most welcome. Sorry for the delay. </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:17</span>
                                        <span class="body"> No probs. Just take your time :) </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:40</span>
                                        <span class="body"> Alright. I just emailed it to you. </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="assets/layouts/layout/img/avatar3.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Bob Nilson</a>
                                        <span class="datetime">20:17</span>
                                        <span class="body"> Great! Thanks. Will check it right away. </span>
                                    </div>
                                </div>
                                <div class="post in">
                                    <img class="avatar" alt="" src="assets/layouts/layout/img/avatar2.jpg" />
                                    <div class="message">
                                        <span class="arrow"></span>
                                        <a href="javascript:;" class="name">Ella Wong</a>
                                        <span class="datetime">20:40</span>
                                        <span class="body"> Please let me know if you have any comment. </span>
                                    </div>
                                </div>
                                <div class="post out">
                                    <img class="avatar" alt="" src="assets/layouts/layout/img/avatar3.jpg" />
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
@include('includes.footer')
@include('includes.core-scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
<script src="assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>

<script src="../js/events.js" type="text/javascript"></script>

<script src="assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/fullcalendar/lang/pt-br.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

<script src="assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>

<!--<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>-->
<script src="../js/agenda.js"></script>

<script src="../js/maps.js"></script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjTs0nbQbEecUygnKpThLfzRKES8nKS0A&callback=initMap"></script>


@include('includes.charts')

<!-- Am Charts -->
<script>
    var chartData = [ {
        "country": "11/12",
        "visits": 25
    }, {
        "country": "18/12",
        "visits": 81
    }, {
        "country": "25/12",
        "visits": 73
    }, {
        "country": "01/01",
        "visits": 40
    } ];

    AmCharts.makeChart( "chartdiv", {
        "type": "serial",
        "dataProvider": chartData,
        "categoryField": "country",
        "graphs": [ {
            "valueField": "visits",
            "type": "column",
            "fillAlphas": 0.8,
            "angle": 30,
            "depth3D": 15,
            "balloonText": "[[category]]: <b>[[value]]</b>"
        } ],
        "categoryAxis": {
            "autoGridCount": false,
            "gridCount": chartData.length,
            "gridPosition": "start",
            "title": "Membros x Dias"
        }


    } );
</script>

<!-- Google maps function
<script>
    function initMap() {
        var infowindow = new google.maps.InfoWindow();

        var uluru = {lat: -23.4792232, lng: -47.4554208};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infowindow.setContent('Igreja Metodista Livre Sorocaba');
                infowindow.open(map, marker);
            }
        })(marker));
    }
</script>


<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjTs0nbQbEecUygnKpThLfzRKES8nKS0A&callback=initMap"></script>-->

<!--<script src="assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>-->
<script src="assets/apps/scripts/calendar.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->

<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script src="app.js" type="text/javascript"></script>


<script>
    function newEvent()
    {
        window.location.href = "/events/create";
    }

    function closeButton()
    {
        $(this).css("display", "none");
    }

    function goToEvent(id)
    {
        window.location.href = "/events/"+id+"/edit";
    }

</script>
</body>

</html>