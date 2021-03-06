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
    <script src="../js/ajax.js"></script>


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
                                    <div class="search-bar bordered hidden-lg hidden-md">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="input-group ">
                                                    <input type="text" class="form-control" id="search-input-mobile" placeholder="Pesquisar Eventos">
                                                    <span class="input-group-btn">
                                                        <button class="btn green-soft uppercase bold small-button" type="button">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>

                                                <ul id="ul-results-mobile">

                                                </ul>
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

                                    <div class="alert alert-danger alert-dismissible"  role="alert" style="display: none;">
                                        <button type="button" class="close" id="button-danger" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Erro</strong> Sua solicitação não foi processada
                                    </div>

                                    @if(Session::has('event.deleted'))
                                        <div class="alert alert-danger alert-dismissible" id="alert-danger" role="alert" style="display: block;">
                                            <button type="button" class="close" id="button-danger" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong>Atenção</strong> {{ Session::get('event.deleted') }}
                                        </div>
                                    @endif

                                    <?php $route = "events";?>

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

                                                            <a href="javascript:;" onclick="newEvent()" class="btn btn-primary btn-circle">
                                                                <i class="fa fa-plus"></i>
                                                                Evento
                                                            </a>



                                                            <div class="btn-group">
                                                                <a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
                                                                    <i class="fa fa-share"></i>
                                                                    <span class="hidden-xs"> Opções </span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right" id="sample_3_tools">
                                                                    <li>
                                                                        <a href="javascript:;" id="print" onclick="printDiv('printable-table')"
                                                                           data-action="0" class="tool-action">
                                                                            <i class="icon-printer"></i> Imprimir
                                                                        </a>
                                                                    </li>
                                                                    <!--<li>
                                                                        <a href="javascript:;" data-action="1" class="tool-action">
                                                                            <i class="icon-check"></i> Copiar</a>
                                                                    </li>-->
                                                                    <li>
                                                                        <a href="javascript:;" data-action="2"
                                                                           onclick="printDiv('printable-table', 'pdf')" class="tool-action">
                                                                            <i class="icon-doc"></i> PDF</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="{{ route($route.'.excel', ['format' => 'xls']) }}"
                                                                           data-action="3" target="_blank"
                                                                           class="tool-action">
                                                                            <i class="icon-paper-clip"></i> Excel</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="{{ route($route.'.excel', ['format' => 'csv']) }}"
                                                                           data-action="4" target="_blank" class="tool-action">
                                                                            <i class="icon-cloud-upload"></i> CSV</a>
                                                                    </li>

                                                                </ul>
                                                            </div>


                                                        </div>
                                                        {!! Form::close() !!}

                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="pull-right hidden-xs hidden-sm">
                                                                <!--<a href="javascript:;" class="btn btn-default btn-circle" style="margin-left: 3px;">
                                                                    <i class="fa fa-search"></i>
                                                                </a>-->

                                                                <input type="text" class="form-control" id="search-input" placeholder="Pesquisar Eventos">

                                                                <ul id="ul-results">

                                                                </ul>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="table-scrollable table-scrollable-borderless">
                                                        <table class="table table-hover table-light">
                                                            <thead>
                                                            <tr class="uppercase">
                                                                <th>
                                                                    @if(Auth::getUser()->person && Auth::getUser()->person->role_id == 1)
                                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                            <input type="checkbox" name="events" class="checkboxes check-model" id="check-0"
                                                                                   value="0" />
                                                                            <span></span>
                                                                        </label>
                                                                    @endif
                                                                </th>
                                                                <th class="printable-table-header"> Nome </th>
                                                                <th class="printable-table-header"> Frequência </th>
                                                                <th class="printable-table-header"> Criado Por </th>
                                                                <th class="printable-table-header"> Grupo </th>
                                                            </tr>
                                                            </thead>



                                                            <tbody>
                                                            @foreach($events as $event)
                                                                <tr class="printable-table-tr">
                                                                    <td>
                                                                        @if(Auth::getUser()->person && Auth::getUser()->person->role_id == 1)
                                                                            <fieldset>
                                                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                                    <input type="checkbox" name="events" class="checkboxes check-model" id="check-{{ $event->id }}"
                                                                                           value="{{ $event->id }}" />
                                                                                    <span></span>
                                                                                </label>
                                                                            </fieldset>

                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('event.edit', ['event' => $event->id]) }}" rel="external" class="printable-table">
                                                                            {{ $event->name }}
                                                                        </a>
                                                                    </td>
                                                                    <td class="printable-table"> {{ $event->frequency }} </td>
                                                                    <td>
                                                                        <a href="{{ route('person.edit',
                                                                            ['person' => \App\Models\User::find($event->createdBy_id)->person->id]) }}" rel="external" class="printable-table">
                                                                            {{ \App\Models\User::find($event->createdBy_id)->person->name }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        @if($event->group_id)
                                                                            <a href="{{ route("group.edit", ['group' => $event->group_id]) }}" rel="external" class="printable-table">
                                                                                {{ $event['group_name'] }}
                                                                            </a>
                                                                            @else Sem Grupo
                                                                        @endif
                                                                    </td>

                                                                    @if(Auth::getUser()->person && Auth::getUser()->person->role_id == 1)
                                                                        <?php $deleteForm = "delete-" . $event->id; ?>
                                                                        <td id="{{ $deleteForm }}">
                                                                            {!! Form::open(['route' => ['event.destroy', 'event' => $event->id],
                                                                                    'method' => 'DELETE', 'id' => 'form-'.$deleteForm]) !!}

                                                                            <a href="" class="btn btn-danger btn-sm btn-circle"
                                                                               title="Excluir evento"
                                                                               onclick='event.preventDefault();document.getElementById("form-{{ $deleteForm }}").submit();'>
                                                                                <i class="fa fa-trash"> Excluir</i>
                                                                            </a>

                                                                            {!! Form::close() !!}
                                                                        </td>
                                                                    @endif

                                                                </tr>
                                                            @endforeach

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
                                                                    <h6>

                                                                            {{ substr($days[$i], 8) }}

                                                                    </h6>

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


<!-- END QUICK NAV -->
@include('includes.core-scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
<script src="../assets/global/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../assets/pages/scripts/search.min.js" type="text/javascript"></script>
<script src="../js/agenda.js"></script>


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

    function goToEvent(id)
    {
        window.location.href = "/events/"+id+"/edit";
    }

</script>

</body>

</html>