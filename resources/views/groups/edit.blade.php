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

    <script src="../../assets/global/plugins/highcharts/highcharts.js"></script>
    <script src="../../assets/pages/scripts/highcharts-exporting.js"></script>
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
        <div class="page-head hidden-sm hidden-xs">
            <div class="container">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>Perfil do Grupo - {{ $model->name }}
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
                <!-- BEGIN PAGE BREADCRUMBS
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href=" route('index') ">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href=" route('group.index') ">Grupos</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Grupo " $model->name "</span>
                    </li>
                </ul>-->
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

                @if(Session::has('member.deleted'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        {{ Session::get('member.deleted') }}
                    </div>
                @endif

                @if(Session::has("error.required-fields"))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Erro!</strong> {{ Session::get("error.required-fields") }}
                    </div>
                @endif

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
                    <strong>Erro</strong> Sua solicitação não foi processada
                </div>

                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <div class="profile-sidebar">
                                <!-- PORTLET MAIN -->
                                <div class="portlet light profile-sidebar-portlet ">
                                    <!-- SIDEBAR USERPIC -->
                                    <div class="profile-userpic">
                                        <img src="../../{{ $model->imgProfile }}" class="img-responsive" alt="">
                                    </div>
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name"> {{ $model->name }}</div>
                                        <div class="profile-usertitle-job"> {{ $model->sinceOf }} </div>
                                    </div>
                                    <!-- END SIDEBAR USER TITLE -->

                                    <!-- SIDEBAR MENU -->
                                    <div class="profile-usermenu">
                                        <ul class="nav">
                                            <li class="active">
                                                <a href="">
                                                    <i class="icon-home"></i> Visão Geral </a>
                                            </li>
                                            {{--<li>
                                                <a href="">
                                                    <i class="icon-info"></i> Detalhes </a>
                                            </li>--}}
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
                                                    <span class="caption-subject bold font-dark uppercase "> Detalhes </span>
                                                    <span class="caption-helper"></span>
                                                </div>
                                                <div class="actions">
                                                    <div class="btn-group">
                                                        <a class="btn purple btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Ações
                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                        @if(Auth::getUser()->person)
                                                            @if(Auth::getUser()->person->role_id == $leader
                                                            || Auth::user()->person->role_id == $admin)
                                                                <ul class="dropdown-menu pull-right">
                                                                    <li>
                                                                        <a href="{{ route('group.event.create', ['id' => $model->id]) }}">
                                                                            <i class="fa fa-bookmark font-purple"></i>
                                                                            Novo Evento
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a href="{{ route('group.addRemoveLoggedMember', ['id' => $model->id]) }}">
                                                                            <i class="fa fa-sign-in font-purple"></i>
                                                                            @if($sub)
                                                                                Sair do grupo
                                                                            @else
                                                                                Entrar no grupo
                                                                            @endif
                                                                        </a>
                                                                    </li>

                                                                        <li class="divider"> </li>
                                                                        <li>
                                                                            <a href="javascript:;" data-toggle="modal" data-target="#modal-note">
                                                                                <i class="fa fa-book font-purple"></i>
                                                                                Nova Nota
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:;" data-toggle="modal" data-target=".group-delete-modal-sm">
                                                                                <i class="fa fa-ban font-red"></i>
                                                                                Excluir Grupo
                                                                            </a>
                                                                        </li>

                                                                </ul>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Excluir Grupo -->
                                            <div class="modal fade group-delete-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                                <div class="modal-dialog modal-md" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title text-center" id="myModalLabel">Atenção</h4>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            Deseja Excluir o Grupo "{{ $model->name }}" ?
                                                            <br>
                                                            (Esta ação não pode ser revertida)
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                            <button type="button" id="btn-delete-{{ $model->id }}" class="btn btn-danger group-delete">
                                                                Excluir Grupo
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="portlet-body">
                                                <div class="col-md-12">
                                                    <p>
                                                        <i class="fa fa-calendar font-purple"></i> Data de Criação: {{ $model->sinceOf }}
                                                    </p>

                                                    <p>
                                                        <i class="fa fa-user font-purple"></i> Criado Por:

                                                        @if(Auth::user()->person_id == $owner_person_id || !Auth::user()->person)
                                                            <label>
                                                                {{ $owner_name }}

                                                                    <img src="{{ $imgProfile }}" class="img-circle hidden-xs hidden-sm"
                                                                         style="width: 25px; margin-left: 10px;">

                                                            </label>
                                                        @else
                                                            <a href="{{ route('person.edit', ['person' => $owner_person_id]) }}">
                                                                {{ $owner_name }}
                                                                <img src="{{ $imgProfile }}" class="img-circle hidden-xs hidden-sm"
                                                                     style="width: 25px; margin-left: 10px;">
                                                            </a>
                                                        @endif
                                                    </p>

                                                    <p>
                                                        <i class="fa fa-users font-purple"></i>
                                                        Participantes: {{ $qtdeMembers }}
                                                    </p>

                                                    <p>
                                                        <i class="fa fa-bookmark font-purple"></i>

                                                        Qtde de Eventos: {{ $events }}

                                                        @if($events > 0)
                                                            <a href="javascript:;" class="btn btn-circle btn-xs purple"
                                                               id="showGroupEvents" style="margin-left: 10px;">
                                                                <i class="fa fa-list"></i>
                                                                <span class="hidden-xs hidden-sm">Listar</span>
                                                            </a>

                                                        @endif

                                                        <br>
                                                        <i class="fa fa-refresh fa-spin fa-3x fa-fw"
                                                           id="icon-loading" style="margin-top: 20px; display: none;">
                                                        </i>

                                                        <div id="div-showGroupEvents">

                                                        </div>
                                                    </p>

                                                    <p>
                                                        <i class="fa fa-map-marker font-purple"></i>
                                                        {{ $model->street }} , {{ $model->number }} -
                                                        {{ $model->neighborhood }} - {{ $model->city }} - {{ $model->state }}
                                                    </p>

                                                    <p id="p-note" @if($model->notes == '') style="display: none;" @endif >

                                                        <i class="fa fa-refresh fa-spin fa-3x fa-fw"
                                                           id="icon-loading-note" style="margin-top: 20px; display: none;">
                                                        </i>

                                                        <div id="div-note" @if($model->notes == '') style="display: none;" @endif>
                                                            <i class="fa fa-comments font-purple"></i>
                                                            Observações: <span> {{ $model->notes }} </span>
                                                        </div>

                                                    </p>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                <!--</div> Fim div row -->
                            </div>
                            <!-- END PAGE CONTENT INNER -->

                        </div>
                    </div>

                    <input type="hidden" id="notific8-title">
                    <input type="hidden" id="notific8-text">
                    <input type="hidden" id="notific8-type" value="amethyst">

                    <a href="javascript:;" class="btn btn-danger" id="notific8" onclick="console.log('teste')" style="display: none;"></a>

                    <!-- Modal -->
                    <div class="modal fade" id="modal-note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="">Adicionar Notas</h4>
                                </div>
                                <div class="modal-body">

                                    <label for="note">Escreva as observações necessárias para o {{ $model->name }}</label>
                                    <textarea class="form-control" name="" id="note" cols="50" rows="10"></textarea>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                    <button type="button" class="btn btn-primary" id="addNote">Salvar Nota</button>
                                </div>
                            </div>
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
                                            <i class="fa fa-map-marker font-red"></i>
                                            <span class="caption-subject font-red bold uppercase">Endereços</span>
                                        </div>
                                        {{--<div class="actions">
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
                                        </div>--}}
                                    </div>
                                    <div class="portlet-body">
                                        <div id="map" style="height: 400px; width: 100%;"></div>

                                        <input type="hidden" value="{{ $location }}" id="location">

                                        <?php $i = 0; ?>

                                        @foreach($address as $location)
                                            <input type="hidden" value="{{ $location }}" id="location-{{ $i }}">
                                            <?php $i++; ?>
                                        @endforeach

                                        <input type="hidden" value="{{ $i }}" id="qtdeMember">

                                        <input type="hidden" id="lat">
                                        <input type="hidden" id="lng">

                                        <input type="hidden" id="person-0" value="{{ $model->name }}">

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

                    @if(Auth::getUser()->person)
                        @if(Auth::getUser()->person->role_id == $leader || Auth::user()->person->role_id == $admin)
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- BEGIN CHART PORTLET-->
                                        <div class="portlet light ">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="icon-bar-chart font-green-haze"></i>
                                                    <span class="caption-subject bold uppercase font-green-haze"> Dados do Grupo</span>
                                                </div>

                                                    @if($qtdeMembers > 1)
                                                        <div id="container"></div>
                                                    @endif



                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                    @if(Auth::getUser()->person)
                        @if((Auth::getUser()->person->role_id == $leader || Auth::user()->person->role_id == $admin)
                            && $qtdeMembers < 2)
                            <p class="text-center" style="margin-top: -15px;">Não há dados a serem exibidos</p>
                        @endif
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-users font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Membros do Grupo</span>
                                    </div>

                                    <div class="actions">

                                        <div class="btn-group btn-group-devided">
                                            {!! Form::open(['route' => 'group.destroyManyUsers', 'id' => 'form-destroyMany', 'method' => 'POST']) !!}
                                            <div id="modelToDel"></div>

                                            <input type="hidden" name="group" value="{{ $model->id }}">

                                            <a href="javascript:;"
                                               class="btn red btn-outline btn-sm btn-circle" id="btn-delete-model"
                                               onclick="event.preventDefault();document.getElementById('form-destroyMany').submit();"
                                               style="display: none;">
                                                <i class="fa fa-close"></i>
                                                Excluir
                                            </a>
                                            {!! Form::close() !!}
                                        </div>


                                        <div class="btn-group">
                                            <a class="btn purple btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Ações
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            @if(Auth::getUser()->person)
                                                @if(Auth::getUser()->person->role_id == $leader
                                                    || Auth::user()->person->role_id == $admin)
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;" data-toggle="modal" data-target="#myModal">
                                                                <i class="fa fa-users font-purple"></i> Novo
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="javascript:;" data-toggle="modal" data-target="#addMemberModal">
                                                                <i class="fa fa-user font-purple"></i> Cadastro
                                                            </a>
                                                        </li>

                                                        <li class="divider"> </li>

                                                        <li>
                                                            <a href="javascript:;">
                                                                <i class="fa fa-print font-purple"></i> Imprimir/PDF </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <i class="fa fa-file-excel-o font-purple"></i> Exportar para Excel </a>
                                                        </li>
                                                    </ul>
                                                @endif
                                            @endif
                                        </div>



                                    </div>


                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light table-striped">
                                            <thead>
                                            <tr class="uppercase">
                                                <th>
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" name="events" class="checkboxes check-model" id="check-0"
                                                               value="0" />
                                                        <span></span>
                                                    </label>
                                                </th>
                                                <th> Nome </th>
                                                <th> Email </th>
                                                <th> Telefone </th>
                                                <th> Celular </th>
                                                @if(Auth::getUser()->person)
                                                    @if(Auth::getUser()->person->role_id == $leader || Auth::user()->person->role_id == $admin)
                                                        <th> Opções </th>
                                                    @endif
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @if($qtdeMembers > 0)
                                                    @foreach($pag as $person)
                                                        <tr class="odd gradeX">
                                                            <td>
                                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                    <input type="checkbox" name="events" class="checkboxes check-model" id="check-{{ $person->id }}"
                                                                           value="{{ $person->id }}" />
                                                                    <span></span>
                                                                </label>
                                                            <td>
                                                                @if(Auth::user()->person_id == $person->id || !Auth::getUser()->person)
                                                                    {{ $person->name }} {{ $person->lastName }}

                                                                @else
                                                                    <a href="{{ route('person.edit', ['person' => $person->id]) }}">
                                                                        {{ $person->name }} {{ $person->lastName }}
                                                                    </a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="javascript:;"> {{ $person->user->email or null }} </a>
                                                            </td>
                                                            <td> {{ $person->tel }} </td>
                                                            <td class="center"> {{ $person->cel }} </td>
                                                            <!--<span class="label label-sm label-success"> Aprovado </span>-->

                                                            @if(Auth::getUser()->person)
                                                                @if(Auth::getUser()->person->role_id == $leader
                                                                    || Auth::user()->person->role_id == $admin)
                                                                    <?php $deleteForm = "delete-" . $person->id; ?>
                                                                    <td id="{{ $deleteForm }}">
                                                                        {!! Form::open(['route' => ['group.deleteMember', 'group' => $model->id, 'member' => $person->id],
                                                                                'method' => 'DELETE', 'id' => 'form-'.$deleteForm]) !!}

                                                                        <a href="javascript:;" class="btn btn-danger btn-sm btn-circle pop-leave-group"
                                                                           title="Excluir membro do grupo" data-toggle="confirmation" data-placement="top"
                                                                           data-original-title="Deseja Excluir?" data-popout="true"
                                                                           onclick='event.preventDefault();' id="btn-delete-{{ $person->id }}">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>

                                                                        {!! Form::close() !!}
                                                                    </td>
                                                                @endif
                                                            @endif
                                                        </tr>
                                                    @endforeach

                                                @endif
                                            </tbody>

                                        </table>
                                            @if($qtdeMembers == 0)
                                                <p class="text-center" style="margin-top: 40px;">Não há dados a serem exibidos</p>
                                            @endif
                                        <br><br>
                                        <div class="pull-right">
                                            {{ $pag->links() }}
                                            <!--<nav aria-label="Page navigation">
                                                <ul class="pagination" id="pagination">
                                                    <li>
                                                        <a href="#" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    <li><a href="javascript:;">1</a></li>
                                                    <li><a href="javascript:;">2</a></li>
                                                    <li><a href="javascript:;">3</a></li>
                                                    <li><a href="javascript:;">4</a></li>
                                                    <li><a href="javascript:;">5</a></li>
                                                    <li>
                                                        <a href="#" aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>-->
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
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>
                    </div>


                    <div class="modal fade" id="myModal" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content form">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Atribuir membros
                                        a {{ $model->name }}</h4>
                                </div>

                                {!! Form::open(['route' => ['group.addMembers', 'group' => $model],
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
                                                        class="select2 form-control"
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

                                {!! Form::open(['route' => ['group.newMember', 'group' => $model],
                                        'class' => 'form-horizontal form-row-seperated', 'method' => 'POST']) !!}
                                <div class="modal-body" style="margin-left: 10px;">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <br>
                                                <input type="hidden" id="groupId" value="{{ $model->id }}">
                                                <label>Nome</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-user font-blue"></i>
                                                    </span>
                                                    <input type="text" name="name"
                                                           class="form-control" id="input-join-new-people"
                                                           placeholder="Digite o nome aqui" autocomplete="off"
                                                    >
                                                </div>

                                                <span class="help-block" id="foundResults" style="margin-top:10px; margin-bottom:10px; display: none;">
                                                    Os seguintes usuários foram encontrados:
                                                </span>

                                                <br>

                                                <span class="help-block" id="table-results" style="display: none;">
                                                    <table class="table table-striped table-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nome</th>
                                                                <th>Adicionar ao grupo</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody-create-modal">
                                                            <tr>

                                                            </tr>
                                                            <label style="display: none; color: red;" class="lblRegistered">
                                                                    Este Usuário já está inscrito nesse grupo
                                                            </label>
                                                        </tbody>
                                                    </table>
                                                </span>



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
                                                           placeholder="Digite o email aqui" required>
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
                                                           class="form-control tel"
                                                           placeholder="Digite o telefone aqui" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <br>
                                                <label>Data de Nasc. - Sem Barras</label>
                                                <div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar font-blue"></i>
                                                    </span>
                                                    <input type="text" class="form-control input-date" name="dateBirth"
                                                           placeholder="dd/mm/aaaa" maxlength="10" required>
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

                    <input type="hidden" id="streetMap" value="{{ $model->street }}, {{ $model->number }}">

                    @if(Auth::getUser()->person)
                        @if(Auth::user()->church_id == $church_id &&
                            (Auth::user()->person->role_id == $leader || Auth::user()->person->role_id == $admin))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light ">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption caption-md">
                                                <i class="icon-globe theme-font hide"></i>
                                                <span class="caption-subject font-blue-madison bold uppercase">Dados do Grupo</span>
                                            </div>

                                        </div>
                                        <?php $i = 0; ?>
                                        <div class="portlet-body">
                                            {!! Form::open(['route' => ['group.update', 'group' => $model->id], 'method' => 'put',
                                            'class' => 'repeater', 'enctype' => 'multipart/form-data']) !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nome</label>
                                                            <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-user font-blue"></i>
                                                                    </span>
                                                                <input type="text" name="name" class="form-control" value="{{ $model->name }}"
                                                                       placeholder="Grupo de Jovens"
                                                                        @if($fields[$i]->required == 1)
                                                                            required
                                                                        @endif
                                                                        <?php $i++; ?>
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Data de Criação</label>
                                                            <div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
                                                                    <span class="input-group-btn">
                                                                    <button class="btn default" type="button">
                                                                        <i class="fa fa-calendar font-blue"></i>
                                                                    </button>
                                                                </span>
                                                                <input type="text" class="form-control input-date" name="sinceOf"
                                                                       value="{{ $model->sinceOf }}" placeholder="dd/mm/aaaa"
                                                                        @if($fields[$i]->required == 1)
                                                                            required
                                                                        @endif
                                                                        <?php $i++; ?>
                                                                >
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <br><br>

                                                @include('includes.address-edit')

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail"
                                                                     style="width: 200px; height: 150px;">
                                                                    <img src=@if($model->imgProfile == "uploads/profile/noimage.png")
                                                                            "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                                    @else
                                                                        "../../{{ $model->imgProfile }}"
                                                                    @endif

                                                                    alt="" /></div>
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
                                                {!! Form::submit('Salvar', ['class' => 'btn green', 'id' => 'btn-submit']) !!}

                                                <div class="progress" style="display: none;">
                                                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                                                         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                        Enviando...
                                                        <span class="sr-only">Enviando...</span>
                                                    </div>
                                                </div>
                                            </div>

                                            {!! Form::close() !!}


                                        </div>
                                    </div>
                                </div>
                        </div>
                        @endif
                    @endif
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
@include('includes.footer')


@include('includes.core-scripts-edit')



<!-- BEGIN THEME../ LAYOUT SCRIPTS
<script src="../../assets/layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
<script src="../../assets/layouts/layout3/scripts/demo.min.js" type="text/javascript"></script>
<script src="../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="../../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>-->
<!-- END THEME LAYOUT SCRIPTS -->

<script src="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script src="../../assets/global/plugins/gmaps/gmaps.min.js" type="text/javascript"></script>

<script src="../../assets/pages/scripts/profile.min.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/timeline.min.js" type="text/javascript"></script>

<script src="../../js/chart.js"></script>

<script src="../../assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>


<script>

    function checkInEvent(id)
    {
        var request = $.ajax({
            url: '/events/checkInEvent/' + id,
            method: 'POST',
            data: id,
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                $("#alert-success").css('display', 'block');
                $("#btn-sub-"+id).addClass('red')
                                 .removeClass('green')
                                 .html("<i class='fa fa-sign-in'></i>" + 'Deixar de Participar');
            }
            else{
                $("#alert-info").css('display', 'block');
                $("#btn-sub-"+id).addClass('green')
                        .removeClass('red')
                        .html("<i class='fa fa-sign-in'></i>" + 'Participar');
            }
        });

        request.fail(function (e) {
            $("#alert-danger").css('display', 'block');
        });

        return false;
    }

</script>



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
            map: map,
            icon: 'http://maps.google.com/mapfiles/kml/pal2/icon10.png'
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

            $.getJSON(script, function (json) {
                var lat = json.results[0].geometry.location.lat;
                var lng = json.results[0].geometry.location.lng;

                localStorage.setItem('lat', lat);
                localStorage.setItem('lng', lng);

            });

            locations.push((localStorage.getItem('lat')));
            locations.push((localStorage.getItem('lng')));
        }

        setMarkers(locations);

    }

    function setMarkers(locations) {
        var lat = parseFloat($("#lat").text());
        var lng = parseFloat($("#lng").text());
        var infowindow = new google.maps.InfoWindow();
        var k = 0;

        var uluru = {lat: lat, lng: lng};

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: uluru
        });

        for (var i = 0; i < locations.length; i++) {
            var position = {lat: parseFloat(locations[i]), lng: parseFloat(locations[i + 1])};

            var marker = new google.maps.Marker({
                position: position,
                map: map,
                icon: icons(k)
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

    function icons(num)
    {
        if(num == 0)
        {
            return new google.maps.MarkerImage("http://maps.google.com/mapfiles/kml/pal2/icon10.png");
        }
        else{
            if($("#role-" + num).val() == 1)
            {
                return new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/icons/yellow-dot.png");
            }
        }

        return '';
    }

</script>


<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjTs0nbQbEecUygnKpThLfzRKES8nKS0A&callback=initMap"></script>
</body>

</html>