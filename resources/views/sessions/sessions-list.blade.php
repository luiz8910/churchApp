<!DOCTYPE html>

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
    <link href="../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet"
          type="text/css"/>
    <link href="../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-boxed">
<div class="page-wrapper">
    <div class="page-wrapper-row">
        <div class="page-wrapper-top">
            <!-- BEGIN HEADER -->
        @if(!isset($church_id) || $church_id == null)
            @include('includes.header')
        @else
            @include('includes.header-edit')
        @endif
        <!-- END HEADER -->
        </div> <!-- FIM DIV.page-wrapper-top -->
    </div> <!-- FIM DIV.page-wrapper-row -->

    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <div class="page-container">
                <div class="page-content-wrapper">
                    <div class="page-head">
                        <div class="container">
                            <div class="page-title">
                                <h1>Sessões do Evento "{{ $event->name }}"
                                    <small></small>
                                </h1>
                            </div>
                        </div> <!-- FIM DIV .container -->
                    </div> <!-- FIM DIV .page-head -->

                    <div class="page-content">
                        <div class="container">
                            @include('includes.messages')


                            <div class="page-content-inner">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption font-green-haze">
                                                    <i class="fa fa-user font-green-haze"></i>
                                                    <span class="caption-subject font-green-haze bold ">Sessões</span>
                                                </div>
                                                <div class="actions">
                                                    <div class="btn-group btn-group-sm">
                                                        @if(Auth::user()->person->role_id == $leader
                                                        || Auth::user()->person->role_id == $admin)



                                                            <div class="col-lg-3">
                                                                <div class="btn-group-devided">
                                                                    <a role="button" id="btn-new-session"
                                                                       class="btn btn-info btn-circle btn-sm"
                                                                       href="javascript:;"
                                                                       style="margin-top: 2px;">
                                                                        <i class="fa fa-plus"></i>
                                                                        <span class="hidden-xs hidden-sm">Nova Sessão</span>
                                                                    </a>

                                                                </div>
                                                            </div>

                                                            <!--<div class="col-lg-3">
                                                                <a class="btn red btn-outline btn-circle btn-sm"
                                                                   href="javascript:;" data-toggle="dropdown">
                                                                    <i class="fa fa-share"></i>
                                                                    <span class="hidden-xs"> Opções </span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right"
                                                                    id="sample_3_tools">
                                                                    <li>
                                                                        <a href="javascript:;" id="print"
                                                                           onclick="printDiv('printable-table')"
                                                                           data-action="0" class="tool-action">
                                                                            <i class="icon-printer"></i> Imprimir
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" data-action="1" class="tool-action">
                                                                            <i class="icon-check"></i> Copiar</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" data-action="2"
                                                                           onclick="printDiv('printable-table', 'pdf')"
                                                                           class="tool-action">
                                                                            <i class="icon-doc"></i> PDF</a>
                                                                    </li>
                                                                </ul>
                                                            </div>-->

                                                        @else

                                                            <div class="col-lg-12">
                                                                <div class="btn-group-devided">
                                                                    <a role="button"
                                                                       class="btn btn-info btn-circle btn-sm"
                                                                       href="javascript:;"
                                                                       style="margin-top: 2px;">
                                                                        <i class="fa fa-plus"></i>
                                                                        <span class="hidden-xs hidden-sm">Nova Sessão</span>
                                                                    </a>

                                                                </div>
                                                            </div>

                                                        @endif


                                                    </div> <!-- FIM DIV .btn-group -->
                                                </div> <!-- FIM DIV .actions -->
                                            </div> <!-- FIM DIV .portlet-title -->

                                            <div class="portlet-body form">
                                                <div class="portlet-body-config">
                                                    <div class="col-md-12">
                                                        <div class="div-loading" id="loading-results">
                                                            <i class="fa fa-refresh fa-spin fa-5x fa-fw"
                                                               id="icon-loading-cep">
                                                            </i>
                                                            <p class="text-center" id="p-loading-cep">
                                                                Carregando ...
                                                            </p>
                                                        </div>

                                                        <p class="text-center" id="p-zero" style="display: none;">
                                                            Nenhum resultado
                                                        </p>

                                                    </div>

                                                    @if(!$sessions)
                                                        <p>Não há sessões para o evento selecionado</p>

                                                    @else
                                                        <div class="table-scrollable table-scrollable-borderless table-striped">
                                                            <table class="table table-hover table-light table-striped">
                                                                <thead>
                                                                <tr class="uppercase">
                                                                    <th> Nome</th>
                                                                    <th> Local</th>
                                                                    <th> Ínicio</th>
                                                                    <th> Opções</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="hide" id="tbody-search"></tbody>
                                                                <tbody>
                                                                @foreach($sessions as $item)
                                                                    <tr id="tr_{{ $item->id }}">

                                                                        <td id="td_name_{{ $item->id }}" style="max-width: 350px;">
                                                                            {{ $item->name }}
                                                                        </td>
                                                                        <td id="td_location_{{ $item->id }}">
                                                                            {{ $item->location }}
                                                                        </td>
                                                                        <td id="td_start_time_{{ $item->id }}">
                                                                            {{ $item->start_time }}
                                                                        </td>

                                                                        <input type="hidden" id="session_date_{{ $item->id }}" value="{{ $item->session_date }}">

                                                                        <td>
                                                                            {{--<a href="{{ route('event.session.check_in_list', ['id' => $item->id]) }}"
                                                                               class="btn btn-info btn-sm btn-circle" title="Inscritos">
                                                                                <i class="fa fa-users"></i>
                                                                            </a>--}}
                                                                            <button class="btn btn-success btn-sm btn-circle btn-edit-session"
                                                                                    title="Editar" id="btn-edit-session-{{ $item->id }}">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </button>
                                                                            <button class="btn btn-danger btn-sm btn-circle btn-delete-session"
                                                                                    title="Excluir" id="btn-delete-session-{{ $item->id }}">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>
                                                                            <a href="{{ route('event.session.modal_code', ['id' => $item->id]) }}"
                                                                               class="btn btn-warning btn-sm btn-circle" title="Visualizar Código"
                                                                                    data-toggle="modal" data-target="#modal-padrao" data-remote="false" modal-remote="true">
                                                                                <i class="fa fa-barcode"></i>
                                                                            </a>
                                                                            <a href="{{ route('event.session.list_questions', ['id' => $item->id]) }}"
                                                                               class="btn btn-warning btn-sm btn-circle" title="Listar Perguntas Recebidas">
                                                                                <i class="fa fa-question"></i>
                                                                            </a>
                                                                            <a href="{{ route('event.session.poll.index', ['id' => $item->id]) }}"
                                                                               class="btn btn-warning btn-sm btn-circle" title="Listar Quizz">
                                                                                <i class="fa fa-check-square"></i>
                                                                            </a>
                                                                            <a href="{{ route('event.session.list_types_rates', ['id' => $item->id]) }}"
                                                                               class="btn btn-warning btn-sm btn-circle" title="Listar Tipos de Avaliações">
                                                                                <i class="fa fa-star"></i>
                                                                            </a>
                                                                            <a href="{{ route('event.session.feedback', ['id' => $item->id]) }}"
                                                                               class="btn btn-warning btn-sm btn-circle" title="Listar Avaliações">
                                                                                <i class="fa fa-comments"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>

                                                                    <input type="hidden" id="short_start_time_{{ $item->id }}"
                                                                           value="{{ $item->short_start_time}}">
                                                                    <input type="hidden" id="end_time_{{ $item->id }}" value="{{ $item->end_time}}">
                                                                    <input type="hidden" id="max_capacity_{{ $item->id }}" value="{{ $item->max_capacity}}">
                                                                    <input type="hidden" id="description_{{ $item->id }}" value="{{ $item->description}}">
                                                                    <input type="hidden" id="category_{{ $item->id }}" value="{{ $item->tag}}">



                                                                @endforeach

                                                                </tbody>
                                                            </table>
                                                            <br>
                                                            <div class="pull-right" id="pagination">
                                                                {{ $sessions->links() }}
                                                            </div>

                                                        </div>
                                                @endif
                                                <!-- FIM DIV .table-scrollable table-scrollable-borderless -->
                                                </div> <!-- FIM DIV .portlet-body-config -->


                                                <div id="new-session" style="display: none;">
                                                    <br><br>
                                                    <div class="caption caption-md">
                                                        <i class="icon-globe theme-font hide"></i>
                                                        <span class="caption-subject font-blue-madison bold uppercase">Sessões de Eventos</span>
                                                    </div>
                                                    <hr>
                                                    <br>


                                                    <form action="{{ route('event.session.store', ['event_id' => $event->id]) }}" method="POST">
                                                        <input type="hidden" value="{{ $event->id }}" id="event_id">

                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="" class="control-label">Nome da Sessão</label>
                                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar font-blue"></i>
                                                            </span>

                                                                        <input type="text" name="name" id="name" class="form-control"
                                                                               autocomplete="new-password" required
                                                                               placeholder="Ex: Coffee Break, Introdução, Sessão de Perguntas"
                                                                               value="{{ old('name') }}">
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="max_capacity" class="control-label">Capacidade Máxima</label>
                                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>


                                                                        <input type="text" name="max_capacity" id="max_capacity"
                                                                               value="{{ old('max_capacity') }}"
                                                                               placeholder="Deixe em Branco quando não houver limite"
                                                                               class="form-control number">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="speakers" class="control-label">
                                                                        Palestrantes ({{ count($speakers) }} no total)
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-microphone font-blue"></i>
                                                                        </span>

                                                                        <input type="hidden" value="Selecione um usuário" id="placeholder-select2">

                                                                        @if(count($speakers) == 0)
                                                                            <input type="text" placeholder="Não há palestrantes para este evento" class="form-control" readonly>
                                                                        @else
                                                                            <select name="speaker_id[]" id="speakers" class="select2 form-control" multiple>
                                                                                <option value="">Selecione</option>
                                                                                <optgroup label="Palestrantes">

                                                                                    @foreach($speakers as $item)

                                                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>

                                                                                    @endforeach

                                                                                </optgroup>
                                                                            </select>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="control-label">Abordagem (categoria)</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-globe font-blue"></i>
                                                                        </span>

                                                                        <input type="text" name="tag" id="category" class="form-control"
                                                                               autocomplete="new-pass"
                                                                               placeholder="Ex: Prática, Aula Teórica"
                                                                               value="{{ old('tag') }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="control-label">Local</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-globe font-blue"></i>
                                                                        </span>

                                                                        <input type="text" name="location" id="location" class="form-control"
                                                                               autocomplete="new-pass"
                                                                               placeholder="Ex: Auditório Principal, Sala de Reuniões, Refeitório"
                                                                               value="{{ old('location') }}">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group @if(Session::has('invalidDate')) has-error @endif ">
                                                                    <label>Data</label>
                                                                    <div class="input-group date @if(!$eventDate) date-picker @endif" data-date-format="dd/mm/yyyy"
                                                                         data-date-start-date="+0d">

                                                                        <span class="input-group-btn">
                                                                            <button class="btn default" type="button">
                                                                                <i class="fa fa-calendar font-blue"></i>
                                                                            </button>
                                                                        </span>

                                                                        <input type="text" class="form-control" name="session_date" id="session_date" required
                                                                               value="@if(old('session_date')) {{ old('session_date') }} @else @if($eventDate) {{$eventDate}} @endif @endif" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="control-label">Início</label>
                                                                    <div class="input-group timepicker timepicker-24">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                                                        <input type="text" name="start_time" id="start_time" class="form-control number" required maxlength="5">

                                                                        {{--<select name="start_time" id="start_time" class="form-control" required
                                                                                value="{{ old('start_time') }}">
                                                                            <option value="">Selecione</option>
                                                                            <option value="06:00">06:00</option>

                                                                            <option value="06:30">06:30</option>
                                                                            <option value="07:00">07:00</option>
                                                                            <option value="07:30">07:30</option>
                                                                            <option value="08:00">08:00</option>
                                                                            <option value="08:30">08:30</option>
                                                                            <option value="09:00">09:00</option>
                                                                            <option value="09:30">09:30</option>
                                                                            <option value="10:00">10:00</option>
                                                                            <option value="10:30">10:30</option>
                                                                            <option value="11:00">11:00</option>
                                                                            <option value="11:30">11:30</option>
                                                                            <option value="12:00">12:00</option>
                                                                            <option value="12:30">12:30</option>
                                                                            <option value="13:00">13:00</option>
                                                                            <option value="13:30">13:30</option>
                                                                            <option value="14:00">14:00</option>
                                                                            <option value="14:30">14:30</option>
                                                                            <option value="15:00">15:00</option>
                                                                            <option value="15:30">15:30</option>
                                                                            <option value="16:00">16:00</option>
                                                                            <option value="16:30">16:30</option>
                                                                            <option value="17:00">17:00</option>
                                                                            <option value="17:30">17:30</option>
                                                                            <option value="18:00">18:00</option>
                                                                            <option value="18:30">18:30</option>
                                                                            <option value="19:00">19:00</option>
                                                                            <option value="19:30">19:30</option>
                                                                            <option value="20:00">20:00</option>
                                                                            <option value="20:30">20:30</option>
                                                                            <option value="21:00">21:00</option>
                                                                            <option value="21:30">21:30</option>
                                                                            <option value="22:00">22:00</option>
                                                                            <option value="22:30">22:30</option>
                                                                            <option value="23:00">23:00</option>
                                                                            <option value="23:30">23:30</option>
                                                                        </select>--}}

                                                                    </div>
                                                                    <small id="error-start-time" style="color: red; display: none;">
                                                                        Selecione o início antes do término
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="control-label">Término</label>
                                                                    <div class="input-group date timepicker-24" data-date-format="dd/mm/yyyy"
                                                                         data-date-start-date="+0d">
                                                                        <span class="input-group-btn">
                                                                            <button class="btn default" type="button">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </button>
                                                                        </span>

                                                                        <input type="text" name="end_time" id="end_time" class="form-control number" maxlength="5">
                                                                        {{--<select name="end_time" id="end_time" class="form-control"
                                                                                value="{{ old('end_time') }}">
                                                                            <option value="">Selecione</option>

                                                                            <option value="06:00">06:00</option>
                                                                            <option value="06:30">06:30</option>
                                                                            <option value="07:00">07:00</option>
                                                                            <option value="07:30">07:30</option>
                                                                            <option value="08:00">08:00</option>
                                                                            <option value="08:30">08:30</option>
                                                                            <option value="09:00">09:00</option>
                                                                            <option value="09:30">09:30</option>
                                                                            <option value="10:00">10:00</option>
                                                                            <option value="10:30">10:30</option>
                                                                            <option value="11:00">11:00</option>
                                                                            <option value="11:30">11:30</option>
                                                                            <option value="12:00">12:00</option>
                                                                            <option value="12:30">12:30</option>
                                                                            <option value="13:00">13:00</option>
                                                                            <option value="13:30">13:30</option>
                                                                            <option value="14:00">14:00</option>
                                                                            <option value="14:30">14:30</option>
                                                                            <option value="15:00">15:00</option>
                                                                            <option value="15:30">15:30</option>
                                                                            <option value="16:00">16:00</option>
                                                                            <option value="16:30">16:30</option>
                                                                            <option value="17:00">17:00</option>
                                                                            <option value="17:30">17:30</option>
                                                                            <option value="18:00">18:00</option>
                                                                            <option value="18:30">18:30</option>
                                                                            <option value="19:00">19:00</option>
                                                                            <option value="19:30">19:30</option>
                                                                            <option value="20:00">20:00</option>
                                                                            <option value="20:30">20:30</option>
                                                                            <option value="21:00">21:00</option>
                                                                            <option value="21:30">21:30</option>
                                                                            <option value="22:00">22:00</option>
                                                                            <option value="22:30">22:30</option>
                                                                            <option value="23:00">23:00</option>
                                                                            <option value="23:30">23:30</option>
                                                                        </select>--}}
                                                                    </div>
                                                                    <small id="error-end-time" style="color: red; display: none;">
                                                                        Horário de término não pode ser menor que o ínicio
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="" class="control-label">Descrição</label>
                                                                    <textarea name="description" class="form-control" value="{{ old('description') }}"
                                                                              placeholder="Entre com a Descrição da Sessão" id="description"
                                                                              rows="5"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br><br>
                                                        <button id="btn-submit-session" type="submit" class="btn btn-success btn-outline">
                                                            <i class="fa fa-check"></i>
                                                            Enviar
                                                        </button>
                                                        <button id="clear-fields" type="button" class="btn btn-default">
                                                            <i class="fa fa-paint-brush"></i>
                                                            Limpar
                                                        </button>

                                                    </form>

                                                </div>


                                                <div id="edit-session" style="display: none;">
                                                    <br><br>
                                                    <div class="caption caption-md">
                                                        <i class="icon-globe theme-font hide"></i>
                                                        <span class="caption-subject font-blue-madison bold uppercase">Sessões de Eventos</span>
                                                    </div>
                                                    <hr>
                                                    <br>


                                                    <form action="{{ route('event.session.update', ['event_id' => $event->id]) }}" method="POST" id="modal-form">
                                                        {{ method_field('PUT') }}
                                                        {{ csrf_field() }}

                                                        <input type="hidden" id="session-id" name="session-id">

                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="" class="control-label">Nome da Sessão</label>
                                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar font-blue"></i>
                                                            </span>

                                                                        <input type="text" name="name" id="modal_name" class="form-control"
                                                                               autocomplete="new-password" required
                                                                               placeholder="Ex: Coffee Break, Introdução, Sessão de Perguntas"
                                                                               value="">
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="max_capacity" class="control-label">Capacidade Máxima</label>
                                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>


                                                                        <input type="text" name="max_capacity" id="modal_max_capacity"
                                                                               value=""
                                                                               placeholder="Deixe em Branco quando não houver limite"
                                                                               class="form-control number">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="speakers" class="control-label">
                                                                        Palestrantes ({{ count($speakers) }} no total)
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-microphone font-blue"></i>
                                                                        </span>

                                                                        <input type="hidden" value="Selecione um usuário" id="placeholder-select2">

                                                                        @if(count($speakers) == 0)
                                                                            <input type="text" placeholder="Não há palestrantes para este evento" class="form-control" readonly>
                                                                        @else
                                                                            <select name="speaker_id[]" id="speakers" class="select2 form-control" multiple>
                                                                                <option value="">Selecione</option>
                                                                                <optgroup label="Palestrantes">

                                                                                    @foreach($speakers as $item)

                                                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>

                                                                                    @endforeach

                                                                                </optgroup>
                                                                            </select>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="control-label">Abordagem (categoria)</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-globe font-blue"></i>
                                                                        </span>

                                                                        <input type="text" name="tag" id="modal_category" class="form-control"
                                                                               autocomplete="new-pass"
                                                                               placeholder="Ex: Prática, Aula Teórica"
                                                                               value="{{ old('tag') }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="control-label">Local</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-globe font-blue"></i>
                                                                        </span>

                                                                        <input type="text" name="location" id="modal_location" class="form-control"
                                                                               autocomplete="new-pass"
                                                                               placeholder="Ex: Auditório Principal, Sala de Reuniões, Refeitório"
                                                                               value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group @if(Session::has('invalidDate')) has-error @endif ">
                                                                    <label>Data</label>
                                                                    <div class="input-group date @if(!$eventDate) date-picker @endif" data-date-format="dd/mm/yyyy"
                                                                         data-date-start-date="+0d">

                                                                        <span class="input-group-btn">
                                                                            <button class="btn default" type="button">
                                                                                <i class="fa fa-calendar font-blue"></i>
                                                                            </button>
                                                                        </span>

                                                                        <input type="text" class="form-control" name="session_date" id="modal_session_date" required
                                                                               value="@if($eventDate) {{$eventDate}} @endif" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="control-label">Início</label>
                                                                    <div class="input-group timepicker timepicker-24">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn default" type="button">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </button>
                                                                    </span>

                                                                        <input type="text" name="start_time" id="modal_start_time" class="form-control number" required maxlength="5">

                                                                        {{--<select name="start_time" id="modal_start_time" class="form-control" required>
                                                                            <option value="">Selecione</option>
                                                                            <option value="06:00">06:00</option>
                                                                            <option value="06:30">06:30</option>
                                                                            <option value="07:00">07:00</option>
                                                                            <option value="07:30">07:30</option>
                                                                            <option value="08:00">08:00</option>
                                                                            <option value="08:30">08:30</option>
                                                                            <option value="09:00">09:00</option>
                                                                            <option value="09:30">09:30</option>
                                                                            <option value="10:00">10:00</option>
                                                                            <option value="10:30">10:30</option>
                                                                            <option value="11:00">11:00</option>
                                                                            <option value="11:30">11:30</option>
                                                                            <option value="12:00">12:00</option>
                                                                            <option value="12:30">12:30</option>
                                                                            <option value="13:00">13:00</option>
                                                                            <option value="13:30">13:30</option>
                                                                            <option value="14:00">14:00</option>
                                                                            <option value="14:30">14:30</option>
                                                                            <option value="15:00">15:00</option>
                                                                            <option value="15:30">15:30</option>
                                                                            <option value="16:00">16:00</option>
                                                                            <option value="16:30">16:30</option>
                                                                            <option value="17:00">17:00</option>
                                                                            <option value="17:30">17:30</option>
                                                                            <option value="18:00">18:00</option>
                                                                            <option value="18:30">18:30</option>
                                                                            <option value="19:00">19:00</option>
                                                                            <option value="19:30">19:30</option>
                                                                            <option value="20:00">20:00</option>
                                                                            <option value="20:30">20:30</option>
                                                                            <option value="21:00">21:00</option>
                                                                            <option value="21:30">21:30</option>
                                                                            <option value="22:00">22:00</option>
                                                                            <option value="22:30">22:30</option>
                                                                            <option value="23:00">23:00</option>
                                                                            <option value="23:30">23:30</option>
                                                                        </select>--}}

                                                                    </div>
                                                                    <small id="error-start-time" style="color: red; display: none;">
                                                                        Selecione o início antes do término
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="control-label">Término</label>
                                                                    <div class="input-group date timepicker-24" data-date-format="dd/mm/yyyy"
                                                                         data-date-start-date="+0d">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn default" type="button">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </button>
                                                                    </span>

                                                                        <input type="text" name="end_time" id="modal_end_time" class="form-control number" required maxlength="5">

                                                                        {{--<select name="end_time" id="modal_end_time" class="form-control">
                                                                            <option value="">Selecione</option>

                                                                            <option value="06:00">06:00</option>
                                                                            <option value="06:30">06:30</option>
                                                                            <option value="07:00">07:00</option>
                                                                            <option value="07:30">07:30</option>
                                                                            <option value="08:00">08:00</option>
                                                                            <option value="08:30">08:30</option>
                                                                            <option value="09:00">09:00</option>
                                                                            <option value="09:30">09:30</option>
                                                                            <option value="10:00">10:00</option>
                                                                            <option value="10:30">10:30</option>
                                                                            <option value="11:00">11:00</option>
                                                                            <option value="11:30">11:30</option>
                                                                            <option value="12:00">12:00</option>
                                                                            <option value="12:30">12:30</option>
                                                                            <option value="13:00">13:00</option>
                                                                            <option value="13:30">13:30</option>
                                                                            <option value="14:00">14:00</option>
                                                                            <option value="14:30">14:30</option>
                                                                            <option value="15:00">15:00</option>
                                                                            <option value="15:30">15:30</option>
                                                                            <option value="16:00">16:00</option>
                                                                            <option value="16:30">16:30</option>
                                                                            <option value="17:00">17:00</option>
                                                                            <option value="17:30">17:30</option>
                                                                            <option value="18:00">18:00</option>
                                                                            <option value="18:30">18:30</option>
                                                                            <option value="19:00">19:00</option>
                                                                            <option value="19:30">19:30</option>
                                                                            <option value="20:00">20:00</option>
                                                                            <option value="20:30">20:30</option>
                                                                            <option value="21:00">21:00</option>
                                                                            <option value="21:30">21:30</option>
                                                                            <option value="22:00">22:00</option>
                                                                            <option value="22:30">22:30</option>
                                                                            <option value="23:00">23:00</option>
                                                                            <option value="23:30">23:30</option>
                                                                        </select>--}}
                                                                    </div>
                                                                    <small id="error-end-time" style="color: red; display: none;">
                                                                        Horário de término não pode ser menor que o ínicio
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="" class="control-label">Descrição</label>
                                                                    <textarea name="description" class="form-control" value=""
                                                                              placeholder="Entre com a Descrição da Sessão" id="modal_description"
                                                                              rows="5"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br><br>
                                                        <button id="btn-submit-session" type="submit" class="btn btn-success btn-outline">
                                                            <i class="fa fa-check"></i>
                                                            Enviar
                                                        </button>
                                                        <button id="clear-fields" type="button" class="btn btn-default">
                                                            <i class="fa fa-paint-brush"></i>
                                                            Limpar
                                                        </button>

                                                    </form>

                                                </div>
                                            </div> <!-- FIM DIV .portlet-body form -->
                                        </div> <!-- FIM DIV .portlet light -->
                                    </div> <!-- FIM DIV .col-md-12 -->
                                </div> <!-- FIM DIV .row -->
                            </div> <!-- FIM DIV .page-content-inner -->
                        </div> <!-- FIM DIV .container -->
                    </div> <!-- FIM DIV .page-content -->
                </div> <!-- FIM DIV .page-content-wrapper -->
            </div> <!-- FIM DIV.page-container -->
        </div> <!-- FIM DIV .page-wrapper-middle -->
    </div> <!-- FIM DIV .page-wrapper-row full-height -->
</div> <!-- FIM DIV .page-wrapper -->


{{--<div class="modal fade" id="edit-session" tabindex="-1" role="dialog" aria-labelledby="edit-session">
    <div class="modal-dialog" role="document">
        <form action="{{ route('event.session.update', ['event_id' => $event->id]) }}" method="POST" id="modal-form">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <input type="hidden" id="session-id" name="session-id">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Editar Sessão</h4>
                </div>
                <div class="modal-body">

                    <label for="" class="control-label">Nome</label>
                    <input type="text" class="form-control" placeholder="Ex: Coffee Break, Introdução, Sessão de Perguntas" name="name" id="modal_name">

                    <br>

                    <label for="" class="control-label">Local</label>
                    <input type="text" class="form-control" placeholder="Auditório Principal, Sala de Reuniões, Refeitório" name="location" id="modal_location">

                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-scrollable table-scrollable-borderless table-striped">
                                <table class="table table-hover table-light table-striped">
                                    <thead>
                                    <tr class="uppercase">
                                        <th> Nome</th>
                                        <th> Opções</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Teste</td>
                                            <td>
                                                <div class="col-md-4">
                                                    <a href="javascript:" class="btn btn-success btn-sm btn-circle">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>


                    --}}{{--<select name="speaker_id[]" id="speaker_id" multiple class="form-control">


                            @foreach($speakers as $speaker)

                                <option value="{{ $speaker->id }}">
                                    {{ $speaker->name }}
                                </option>

                            @endforeach

                    </select>--}}{{--

                    <br>

                    <label for="" class="control-label">Data da Sessão</label>
                    <div class="input-group date @if(!$eventDate) date-picker @endif" data-date-format="dd/mm/yyyy" data-date-start-date="+0d">

                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar font-blue"></i>
                            </button>
                        </span>

                        <input type="text" class="form-control" name="session_date" id="modal_session_date" required readonly>
                    </div>

                    <br>

                    <label for="" class="control-label">Ínicio</label>
                    <select id="modal_start_time" name="start_time" class="form-control" required>
                        <option value="">Selecione</option>
                        <option value="06:00">06:00</option>
                        <option value="06:30">06:30</option>
                        <option value="07:00">07:00</option>
                        <option value="07:30">07:30</option>
                        <option value="08:00">08:00</option>
                        <option value="08:30">08:30</option>
                        <option value="09:00">09:00</option>
                        <option value="09:30">09:30</option>
                        <option value="10:00">10:00</option>
                        <option value="10:30">10:30</option>
                        <option value="11:00">11:00</option>
                        <option value="11:30">11:30</option>
                        <option value="12:00">12:00</option>
                        <option value="12:30">12:30</option>
                        <option value="13:00">13:00</option>
                        <option value="13:30">13:30</option>
                        <option value="14:00">14:00</option>
                        <option value="14:30">14:30</option>
                        <option value="15:00">15:00</option>
                        <option value="15:30">15:30</option>
                        <option value="16:00">16:00</option>
                        <option value="16:30">16:30</option>
                        <option value="17:00">17:00</option>
                        <option value="17:30">17:30</option>
                        <option value="18:00">18:00</option>
                        <option value="18:30">18:30</option>
                        <option value="19:00">19:00</option>
                        <option value="19:30">19:30</option>
                        <option value="20:00">20:00</option>
                        <option value="20:30">20:30</option>
                        <option value="21:00">21:00</option>
                        <option value="21:30">21:30</option>
                        <option value="22:00">22:00</option>
                        <option value="22:30">22:30</option>
                        <option value="23:00">23:00</option>
                        <option value="23:30">23:30</option>
                    </select>

                    <br>

                    <label for="" class="control-label">Fim</label>
                    <select id="modal_end_time" name="end_time" class="form-control" required>
                        <option value="">Selecione</option>
                        <option value="06:00">06:00</option>
                        <option value="06:30">06:30</option>
                        <option value="07:00">07:00</option>
                        <option value="07:30">07:30</option>
                        <option value="08:00">08:00</option>
                        <option value="08:30">08:30</option>
                        <option value="09:00">09:00</option>
                        <option value="09:30">09:30</option>
                        <option value="10:00">10:00</option>
                        <option value="10:30">10:30</option>
                        <option value="11:00">11:00</option>
                        <option value="11:30">11:30</option>
                        <option value="12:00">12:00</option>
                        <option value="12:30">12:30</option>
                        <option value="13:00">13:00</option>
                        <option value="13:30">13:30</option>
                        <option value="14:00">14:00</option>
                        <option value="14:30">14:30</option>
                        <option value="15:00">15:00</option>
                        <option value="15:30">15:30</option>
                        <option value="16:00">16:00</option>
                        <option value="16:30">16:30</option>
                        <option value="17:00">17:00</option>
                        <option value="17:30">17:30</option>
                        <option value="18:00">18:00</option>
                        <option value="18:30">18:30</option>
                        <option value="19:00">19:00</option>
                        <option value="19:30">19:30</option>
                        <option value="20:00">20:00</option>
                        <option value="20:30">20:30</option>
                        <option value="21:00">21:00</option>
                        <option value="21:30">21:30</option>
                        <option value="22:00">22:00</option>
                        <option value="22:30">22:30</option>
                        <option value="23:00">23:00</option>
                        <option value="23:30">23:30</option>
                    </select>

                    <br>

                    <label for="" class="control-label">Capacidade Máxima (Deixe em branco caso não tenha limite máximo)</label>
                    <input type="text" class="form-control number" placeholder="Ex: 50, 70" id="modal_max_capacity" name="max_capacity">

                    <br>
                    <label for="" class="control-label">Descrição</label>
                    <textarea name="description" class="form-control" id="modal_description" cols="20" rows="5"
                              placeholder="Digite aqui informações sobre essa sessão"></textarea>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="resetSpeakers()">
                        <i class="fa fa-close"></i>
                        Fechar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i>
                        Salvar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>--}}

<!-- END CONTAINER -->
@include('includes.footer')
@include('includes.core-scripts-edit')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
        type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script src="../../assets/global/plugins/select2/js/select2.full.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/components-select2.js" type="text/javascript"></script>
</body>

</html>
