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

<link href="../../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE LEVEL PLUGINS -->
{{--<link href="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet"
      type="text/css"/>
<link href="../../assets/pages/css/profile.min.css" rel="stylesheet" type="text/css"/>
<link href="../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>--}}
{{--<link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet"
      type="text/css"/>--}}
{{--<link href="../../assets/global/plugins/typeahead/typeahead.css" rel="stylesheet" type="text/css"/>--}}
{{--<link href="../../assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet"
      type="text/css"/>--}}
<!-- END PAGE LEVEL PLUGINS -->
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-boxed">
<!-- BEGIN HEADER -->
@include('includes.header-edit')
<!-- END HEADER -->

<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head hidden-xs hidden-sm">
            <div class="container">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>Detalhes do Evento "{{ $event->name }}"
                        <small></small>
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
        </div>

        <div class="page-content">
            <div class="container">

                @if(Session::has('event.sub'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Sucesso!</strong> {{ Session::get('event.sub') }}
                    </div>
                @endif

                @include('includes.messages')

                <div class="page-content-inner">
                    <!--<div class="row">-->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="portlet light portlet-fit ">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-directions font-green hide"></i>
                                    <span class="caption-subject bold font-dark uppercase ">
                                        Lista de Inscritos -
                                            <span id="span-sub">{{ count($sub) }}</span>
                                        pessoas inscritas
                                    </span>
                                    <span class="caption-helper"></span>



                                </div>

                                {{--<div class="clearfix"
                                        style=" z-index: 1000;
                                                float: left; overflow: hidden;
                                                width: 50%; height: 100%;">
                                    <a href="javascript:;" class="btn btn-success btn-circle pull-right" style="margin-top: 20px;" disabled>
                                        <i class="fa fa-check"></i>
                                        Check-In
                                    </a>
                                </div>--}}


                                <div class="actions">
                                    <div class="btn-group">
                                        <div class="col-md-3">

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <input type="hidden" value="Selecione um usuário" id="placeholder-select2">

                            <div class="modal fade" id="event-sub-modal" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content form">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Atribuir membros
                                                a {{ $event->name }}</h4>
                                        </div>

                                        {!! Form::open(['route' => ['event.addMembers', 'event' => $event],
                                                'class' => 'form-horizontal form-row-seperated', 'method' => 'POST']) !!}
                                        <div class="modal-body form">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" for="select_members">Membros</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                        <select id="select_members" class="select2 form-control">
                                                            <option value="">Selecione</option>
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

                            <div class="portlet-body">
                                <div class="row">
                                    <form action="{{ route('event.addMembers', ['event' => $event->id]) }}" method="POST">
                                        {{ csrf_field() }}


                                        <div class="col-md-9 col-sm-8 col-xs-8">

                                            <select class="form-control select2" id="subUser" name="person_id" required>
                                                <option></option>
                                                <optgroup label="Pessoas">
                                                    @foreach($people as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->name }} {{ $item->lastName }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                                {{--<optgroup label="Grupos">
                                                    <option value="">grupo teste</option>
                                                </optgroup>--}}
                                            </select>


                                        </div>

                                        <div class="col-md-1 col-sm-2 col-xs-2">
                                            <button type="submit" class="btn btn-success btn-sm btn-circle">
                                                <i class="fa fa-sign-in"></i>
                                                Inscrever
                                            </button>
                                        </div>

                                        <div class="col-md-1 col-sm-2 col-xs-2">
                                            <a href="{{ route('event.edit', ['event' => $event]) }}" type="button" class="btn btn-danger btn-sm btn-circle">
                                                <i class="fa fa-arrow-left"></i>
                                                Voltar
                                            </a>
                                        </div>

                                    </form>
                                </div>

                                <br><br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-scrollable table-scrollable-borderless">
                                            <table class="table table-hover table-light">
                                                <thead>
                                                <tr class="uppercase">

                                                        {{--<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" name="events" class="checkboxes check-model" id="check-0"
                                                                   value="0" />
                                                            <span></span>
                                                        </label>--}}

                                                    <th class="printable-table-header"> Nome </th>
                                                    <th class="hidden-xs hidden-sm"> Cancelar Inscrição </th>
                                                    <th class="hidden-md hidden-lg"> Cancelar </th>
                                                </tr>
                                                </thead>

                                                <input type="hidden" value="{{ $event->id }}" id="event-id">


                                                <?php $deleteForm = "delete-" . $event->id;
                                                    $i = 0;
                                                ?>

                                                <tbody>
                                                @foreach($person_sub as $person)
                                                    <tr id="tr-{{ $person->id }}">
                                                        <td>
                                                            @if(Auth::user()->person_id == $person->id)
                                                                <a href="javascript:;" style="margin-left: 10px;">
                                                                    @if($person->social_media)
                                                                        <img src="{{ $person->imgProfile }}" style="width: 50px; height: 50px;">
                                                                    @else
                                                                        <img src="../../{{ $person->imgProfile }}" style="width: 50px; height: 50px;">
                                                                    @endif
                                                                    {{ $person->name }}
                                                                    <span class="hidden-xs hidden-sm">
                                                                        {{ $person->lastName }}
                                                                    </span>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('person.edit', ['person' => $person->id]) }}"  style="margin-left: 10px;">

                                                                    @if($person->social_media)
                                                                        <img src="{{ $person->imgProfile }}" style="width: 50px; height: 50px;">
                                                                    @else
                                                                        <img src="../../{{ $person->imgProfile }}" style="width: 50px; height: 50px;">
                                                                    @endif
                                                                    {{ $person->name }}
                                                                    <span class="hidden-xs hidden-sm">
                                                                        {{ $person->lastName }}
                                                                    </span>
                                                                </a>
                                                            @endif

                                                        </td>

                                                        <td>
                                                            <a href="javascript:;" class="btn btn-danger btn-sm btn-circle btn-person"
                                                               title="Excluir Pessoa?"
                                                               id="btn-person-{{ $person->id }}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <?php $i++; ?>
                                                @endforeach

                                                </tbody>

                                            </table>
                                            <br>

                                            <div class="pull-right">
                                                {{ $person_sub->links() }}
                                            </div>

                                            <div class="progress" id="progress-danger" style="display: none;">
                                                <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100"
                                                     aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                    Excluindo...
                                                    <span class="sr-only">Excluindo...</span>
                                                </div>
                                            </div>

                                            <input type="hidden" id="notific8-title">
                                            <input type="hidden" id="notific8-text">
                                            <input type="hidden" id="notific8-type" value="danger">

                                            <a href="javascript:;" class="btn btn-danger" id="notific8" style="display: none;"></a>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@include('includes.footer')

@include('includes.core-scripts-edit')

<script src="../../assets/global/plugins/select2/js/select2.full.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/components-select2.js" type="text/javascript"></script>

<script type="text/javascript">
    $(".select2-allow-clear").select2();
</script>

</body>

</html>
