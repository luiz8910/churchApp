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
    @include('includes.head-edit')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
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
                <!-- BEGIN PAGE BREADCRUMBS
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href=" route('index') ">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Minha Conta</span>
                    </li>
                </ul>-->
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->
                @if(Session::has('updateUser'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get('updateUser') }}
                    </div>
                @endif

                @if(Session::has('person.crud'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get('person.crud') }}
                    </div>
                @endif

                @if(Session::has('email.exists'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get('email.exists') }}
                    </div>
                @endif

                @if(Session::has("error.required-fields"))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Erro!</strong> {{ Session::get("error.required-fields") }}
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
                                        @if(isset($model->user))
                                            @if($model->user->facebook_id != null || $model->user->google_id != null)

                                                <img src="{{ $model->imgProfile }}" class="img-responsive" alt="">

                                            @else

                                                <img src="../../{{ $model->imgProfile }}" class="img-responsive" alt="">

                                            @endif

                                        @else
                                            <img src="../../{{ $model->imgProfile }}" class="img-responsive" alt="">
                                        @endif
                                    </div>
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name"> {{ $model->name }}</div>
                                        <div class="profile-usertitle-job"> {{ $model->role->name }} </div>

                                        @if($model->status == 'waiting')

                                            <span class="label label-warning">
                                                <i class="fa fa-clock-o"></i>
                                                Aguardando Aprovação
                                            </span>

                                        @elseif($model->status == 'denied')

                                            <span class="label label-danger">
                                                <i class="fa fa-ban"></i>
                                                Aprovação Negada
                                            </span>

                                        @else

                                            <span class="label label-success" style="padding-left: 20px; padding-right: 20px;">
                                                <i class="fa fa-check"></i>
                                                Ativo
                                            </span>
                                        @endif
                                    </div>
                                    <!-- END SIDEBAR USER TITLE -->

                                    <!-- SIDEBAR MENU -->
                                    <div class="profile-usermenu">
                                        <ul class="nav">

                                            <li class="active">
                                                <a href="javascript:;">
                                                    <i class="icon-home"></i> Visão Geral </a>

                                            </li>


                                            @if(Auth::user()->person->role_id == $leader || Auth::user()->person->role_id == $admin)

                                                @if($model->status == 'waiting')

                                                    <li>
                                                        <a href="javascript:;" class="approve" id="approve-{{ $model->id }}">
                                                            <i class="fa fa-check font-green"></i>

                                                            Aprovar
                                                        </a>


                                                    </li>

                                                    <li>
                                                        <input type="hidden" id="deny-name" value="{{ $model->name }}">

                                                        <input type="hidden" id="deny-email" value="{{ $model->email }}">

                                                        <a href="javascript:;" id="deny">
                                                            <i class="fa fa-ban font-red"></i>
                                                            Negar
                                                        </a>
                                                    </li>

                                                    @include('includes.modal-denied')



                                                @elseif($model->status == 'denied')

                                                    @include('includes.modal-denied-details')

                                                    <li>
                                                        <a href="javascript:;" class="approve" id="approve-{{ $model->id }}">
                                                            <i class="fa fa-check font-green"></i>

                                                            Aprovar
                                                        </a>

                                                    </li>

                                                    <li>
                                                        <a href="javascript:;" class="btn-details" id="btn-details-{{ $model->id }}">
                                                            <i class="fa fa-info-circle font-blue"></i>
                                                            Detalhes da Recusa
                                                        </a>
                                                    </li>

                                                @else
                                                    <li>
                                                        <a href="javascript:;" onclick="sendPasswordUser()">
                                                            <i class="fa fa-unlock-alt"></i>

                                                            Reenviar Senha
                                                        </a>

                                                        <div class="text-center" id="msg-spin">
                                                            <i class="fa fa-refresh fa-spin fa-4x fa-fw" id="loading-spin"></i>
                                                            <span class="sr-only">Loading...</span>
                                                            <p>Enviando Senha...</p>
                                                        </div>

                                                    </li>

                                                    <li>
                                                        <a href="javascript:;" id="btn-delete-{{ $model->id }}" class="deleteUser">
                                                            <i class="fa fa-ban font-red"></i>
                                                            Excluir Usuário
                                                        </a>
                                                    </li>

                                                @endif
                                            @endif

                                            <li>
                                                <a href="javascript:;" class="new-password" id="new-password-{{ $model->id }}">
                                                    <i class="fa fa-unlock-alt"></i>

                                                    Gerar nova Senha
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- END MENU -->
                                </div>
                                <!-- END PORTLET MAIN -->


                                <input type="hidden" id="notific8-title">
                                <input type="hidden" id="notific8-text">
                                <input type="hidden" id="notific8-type" value="danger">

                                <a href="javascript:;" class="btn btn-danger" id="notific8" style="display: none;"></a>

                            </div>
                            <!-- END BEGIN PROFILE SIDEBAR -->
                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- BEGIN BASIC PORTLET-->
                                        <div class="portlet light portlet-fit ">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-map-marker font-red"></i>
                                                    <span class="caption-subject font-red bold uppercase">Endereço</span>
                                                </div>
                                                {{--<div class="actions">
                                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                        <i class="icon-cloud-upload"></i>
                                                    </a>
                                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                        <i class="icon-wrench"></i>
                                                    </a>
                                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                        <i class="icon-trash"></i>
                                                    </a>
                                                </div>--}}
                                            </div>
                                            <div class="portlet-body">
                                                <div id="map" style="height: 320px; width: 100%;"></div>
                                                <input type="hidden" value="{{ $location }}" id="location">
                                            </div>
                                        </div>
                                        <!-- END BASIC PORTLET-->
                                    </div>
                                </div>

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
                                        <i class="fa fa-calendar font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Eventos (inscrições)</span>
                                    </div>
                                    <div class="actions">
                                        @if(Auth::getUser()->person->role_id == $leader
                                            || Auth::user()->person->role_id == $admin)
                                            <div class="btn-group btn-group-devided">
                                                <a role="button" class="btn btn-info btn-circle" href="{{ route('event.create') }}" style="margin-top: 2px;">
                                                    <i class="fa fa-plus"></i>
                                                    <span class="hidden-xs hidden-sm">Novo Evento</span>
                                                </a>

                                            </div>
                                        @endif
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
                                                <th> Nome </th>
                                                <th> Frequência </th>
                                                <th> Criado Por </th>
                                                <th> Grupo </th>
                                                <th> Ações </th>

                                            </tr>
                                            </thead>

                                            <input type="hidden" id="person_id" value="{{ Auth::user()->person_id }}">

                                            <tbody>
                                            @if(count($events) > 0)
                                                <?php $i = 0; ?>
                                                @foreach($events as $item)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('event.edit', ['event' => $item->id]) }}">
                                                                {{ $item->name }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{ $item->frequency }}
                                                        </td>
                                                        <td>
                                                            @if(Auth::user()->person_id == $item->createdBy_id)
                                                                {{ $item->createdBy_name }}

                                                            @else
                                                                <a href="{{ route('person.edit', ['person' => $item->createdBy_id]) }}">
                                                                    {{ $item->createdBy_name }}
                                                                </a>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            {{ $item->group_id }}
                                                        </td>

                                                        @if(Auth::getUser()->person)

                                                            <?php $deleteForm = $item->id; ?>
                                                            <td>

                                                                <a href="javascript:" class="btn btn-sm blue btn-circle event-certificate"
                                                                            id="event-certificate-{{ $item->id }}">
                                                                    <i class="fa fa-envelope"></i>
                                                                    Certificado por Email
                                                                </a>

                                                                <a href="javascript:" class="btn btn-danger btn-sm btn-circle pop-sub"
                                                                   title="Cancelar Inscrição"
                                                                   data-toggle="confirmation" data-placement="top" data-original-title="Cancelar Inscrição?"
                                                                   data-popout="true" onclick="event.preventDefault()"
                                                                   id="btn-person-{{ $deleteForm }}">
                                                                    <i class="fa fa-trash"></i>
                                                                    <span class="hidden-sm hidden-xs">Excluir</span>
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
                                            @if($events) {{ $events->links() }} @endif
                                        </div>
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
                                        <span class="caption-subject font-blue-madison bold uppercase">Seus Dados</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab">
                                                <span class="hidden-xs hidden-sm">
                                                    Informações Pessoais
                                                </span>
                                                <span class="visible-xs visible-sm">Pessoal</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_2" data-toggle="tab">Alterar Foto</a>
                                        </li>

                                    </ul>
                                </div>

                                <?php $i = 0; ?>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <!-- PERSONAL INFO TAB -->

                                        <input type="hidden" value="{{ $model->id }}" id="personId">
                                        <input type="hidden" id="streetMap" value="{{ $model->street }}, {{ $model->number }}">

                                        <div class="tab-pane active" id="tab_1_1">
                                            <form action="{{ route('person.update', ['person' => $model->id]) }}"
                                                  class="repeater" method="POST" role="form" id="form">

                                                {{ csrf_field() }}
                                                {{ method_field('PUT') }}


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Nome</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>
                                                            <input type="text" placeholder="João" name="name" id="name" value="{{ $model->name }}" class="form-control"
                                                                    @if($fields[$i]->required == 1)
                                                                        required
                                                                    @endif
                                                                    <?php $i++; ?>
                                                            />
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Email</label>
                                                        <div class="input-group input-icon right">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope font-blue" id="icon-email"></i>
                                                            </span>
                                                            <input type="email" placeholder="email@dominio.com" value="{{ $model->user->email or null }}"
                                                                   id="email-edit" name="email" class="form-control"

                                                                    @if($fields[$i]->required == 1)
                                                                        required
                                                                    @endif
                                                                    <?php $i++; ?>
                                                            />
                                                            <i class="fa fa-check font-green" id="icon-success-email" style="display: none;"></i>
                                                            <i class="fa fa-exclamation font-red" id="icon-error-email" style="display: none;"></i>
                                                        </div>

                                                        <span class="help-block" id="emailExists" style="display: none; color: red;">
                                                            <i class="fa fa-block"></i>
                                                            Já existe uma conta associada a este email
                                                        </span>
                                                        <span class="help-block" id="invalidEmail" style="display: none; color: red;">
                                                            <i class="fa fa-block"></i>
                                                            Email em formato incorreto
                                                        </span>
                                                        <span class="help-block" id="validEmail" style="display: none; color: green;">
                                                            <i class="fa fa-check"></i>
                                                            Email Válido
                                                        </span>
                                                    </div>

                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Celular</label>
                                                        <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-mobile font-blue"></i>
                                                    </span>
                                                            <input type="text" class="form-control" name="cel"
                                                                   id="exampleInputPassword1" value="{{ $model->cel }}" placeholder="(15) 9231413423"
                                                                    @if($fields[$i]->required == 1)
                                                                        required
                                                                    @endif
                                                                    <?php $i++; ?>
                                                            >
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Telefone</label>
                                                        <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-phone font-green"></i>
                                                    </span>
                                                            <input type="text" class="form-control tel" name="tel"
                                                                   id="exampleInputPassword1" value="{{ $model->tel }}"
                                                                   placeholder="(15) 1231413423"
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
                                                        <label>Gênero</label>
                                                        <div class="input-icon input-icon-lg">
                                                            <select class="form-control" name="gender"
                                                                    @if($fields[$i]->required == 1)
                                                                        required
                                                                    @endif
                                                                    <?php $i++; ?>
                                                            >
                                                                <option value="">Selecione</option>
                                                                <option value="M" @if($model->gender == 'M') selected @endif >Masculino</option>
                                                                <option value="F" @if($model->gender == 'F') selected @endif >Feminino</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Data de Nasc.</label>
                                                        <div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar font-blue"></i>
                                                            </span>
                                                            <input type="text" class="form-control input-date" name="dateBirth"
                                                                   placeholder="dd/mm/aaaa" maxlength="10" value="{{ $model->dateBirth }}"
                                                                    @if($fields[$i]->required == 1)
                                                                        required
                                                                    @endif
                                                                    <?php $i++; ?>
                                                            >
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group" id="form-cpf">
                                                        <label>CPF (Sem pontos ou traços)</label>
                                                        <div class="input-group input-icon right">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>
                                                            <input type="text" name="cpf" id="cpf" maxlength="11" class="form-control"
                                                                   placeholder="XXXXXXXXXXX" value="{{ $model->cpf }}"

                                                                    @if($fields[$i]->required == 1)
                                                                        required
                                                                    @endif
                                                                    <?php $i++; ?>
                                                            >
                                                            <i class="fa fa-check font-green" id="icon-success-cpf" style="display: none;"></i>
                                                            <i class="fa fa-exclamation font-red" id="icon-error-cpf" style="display: none;"></i>

                                                        </div>
                                                        <div class="help-block small-error">CPF Inválido</div>
                                                        <div class="help-block small-error" id="textResponse" style="color: red;"></div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>RG (Sem pontos ou traços)</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-green"></i>
                                                            </span>
                                                            <input type="text" id="rg" name="rg" class="form-control"
                                                                   placeholder="XX.XXX.XXX-X" value="{{ $model->rg }}" maxlength="9" minlength="9"

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
                                                        <label>Cargo</label>
                                                        <div class="input-icon input-icon-sm">
                                                            @if(Auth::user()->person->role_id == $leader || Auth::user()->person->role_id == $admin)
                                                                <i class="fa fa-briefcase"></i>
                                                                <select class="form-control" name="role_id"
                                                                        @if($fields[$i]->required == 1)
                                                                        required
                                                                        @endif
                                                                <?php $i++; ?>
                                                                >
                                                                    @foreach($roles as $role)
                                                                        <option value="{{ $role->id }}" @if($role->id == $model->role_id) selected @endif >{{ $role->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <i class="fa fa-briefcase"></i>
                                                                <input type="text" class="form-control" value="{{ $model->role->name }}" readonly>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Estado Civil</label>
                                                        <select name="maritalStatus" id="maritalStatus" class="form-control"
                                                                @if($fields[$i]->required == 1)
                                                                    required
                                                                @endif
                                                                <?php $i++; ?>
                                                        >
                                                            <option value="">Selecione</option>
                                                            <option value="Casado" @if($model->maritalStatus == 'Casado') selected @endif >Casado</option>
                                                            <option value="Solteiro" @if($model->maritalStatus == 'Solteiro') selected @endif >Solteiro</option>
                                                            <option value="Divorciado" @if($model->maritalStatus == 'Divorciado') selected @endif >Divorciado</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group" id="form-partner"
                                                         @if($model->maritalStatus != 'Casado')
                                                         hidden @endif >
                                                        <label>Nome Cônjuge</label>
                                                        <select name="partner" id="partner" class="selectpicker
                                                          form-control"
                                                                data-live-search="true" data-size="8">
                                                            <option value="0">Parceiro(a) fora da Organização</option>
                                                            @foreach($adults as $adult)
                                                                <option value="{{ $adult->id }}"
                                                                        @if($adult->id == $model->partner) selected @endif
                                                                >{{ $adult->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Descrição</label>
                                                    <div class="form-group">
                                                        <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $model->description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>




                                            <br><br>

                                            @include('includes.address-edit')


                                            <br><br>
                                                <div class="margiv-top-10">
                                                    <button class="btn blue btn-block" id="btn-submit" type="submit">
                                                        <i class="fa fa-check"></i>
                                                        Enviar
                                                    </button>

                                                    <div class="progress" style="display: none;">
                                                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                                                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                            Enviando...
                                                            <span class="sr-only">Enviando...</span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                        <!-- END PERSONAL INFO TAB -->
                                        <!-- CHANGE AVATAR TAB -->
                                        <div class="tab-pane" id="tab_1_2">
                                            <p> Altere aqui sua foto do perfil </p>
                                            {!! Form::open(['route' => ['person.imgEditProfile', $model->id], 'method' => 'post', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                            <img src=@if($model->imgProfile == "uploads/profile/noimage.png")
                                                                        "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                                        @else
                                                                            "../../{{ $model->imgProfile }}"
                                                                    @endif

                                                                 alt="" /> </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                        <div>
                                                                                <span class="btn default btn-file">
                                                                                    <span class="fileinput-new"> Escolher Imagem </span>
                                                                                    <span class="fileinput-exists"> Alterar </span>
                                                                                    <input type="file" name="img"> </span>
                                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remover </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="margin-top-10">
                                                    {!! Form::submit('Enviar', ['class' => 'btn green']) !!}
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END CHANGE AVATAR TAB -->
                                        <!-- CHANGE PASSWORD TAB -->
                                        <div class="tab-pane" id="tab_1_3">
                                            {!! Form::open(['route' => 'users.changePass', 'method' => 'post']) !!}
                                            <div class="form-group">
                                                <label class="control-label">Senha Atual</label>
                                                <input type="password" class="form-control" name="old" /> </div>
                                            <div class="form-group">
                                                <label class="control-label">Nova Senha</label>
                                                <input type="password" class="form-control" name="new" /> </div>
                                            <div class="form-group">
                                                <label class="control-label">Confirme sua nova Senha</label>
                                                <input type="password" class="form-control" name="confirmPassword" /> </div>
                                            <div class="margin-top-10">
                                                {!! Form::submit('Alterar Senha', ['class' => 'btn green']) !!}
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <!-- END CHANGE PASSWORD TAB -->
                                        <!-- PRIVACY SETTINGS TAB -->
                                        <div class="tab-pane" id="tab_1_4">
                                            <form action="#">
                                                <table class="table table-light table-hover">
                                                    <tr>
                                                        <td> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus.. </td>
                                                        <td>
                                                            <label class="uniform-inline">
                                                                <input type="radio" name="optionsRadios1" value="option1" /> Yes </label>
                                                            <label class="uniform-inline">
                                                                <input type="radio" name="optionsRadios1" value="option2" checked/> No </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                        <td>
                                                            <label class="uniform-inline">
                                                                <input type="checkbox" value="" /> Yes </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                        <td>
                                                            <label class="uniform-inline">
                                                                <input type="checkbox" value="" /> Yes </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                        <td>
                                                            <label class="uniform-inline">
                                                                <input type="checkbox" value="" /> Yes </label>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--end profile-settings-->
                                                <div class="margin-top-10">
                                                    <a href="javascript:;" class="btn red"> Save Changes </a>
                                                    <a href="javascript:;" class="btn default"> Cancel </a>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END PRIVACY SETTINGS TAB -->
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
@include('includes.footer')
@include('includes.core-scripts-edit')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script src="../../assets/global/plugins/gmaps/gmaps.min.js" type="text/javascript"></script>

<script src="../../assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>

<script src="../../assets/pages/scripts/profile.min.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/timeline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script src="../../js/waiting-approval.js"></script>
<script src="../../js/edit-person.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>


        $('.repeater').repeater({
            // (Optional)
            // start with an empty list of repeaters. Set your first (and only)
            // "data-repeater-item" with style="display:none;" and pass the
            // following configuration flag
            initEmpty: true,
            // (Optional)
            // "defaultValues" sets the values of added items.  The keys of
            // defaultValues refer to the value of the input's name attribute.
            // If a default value is not specified for an input, then it will
            // have its value cleared.
            defaultValues: {
                'text-input': ''
            },
            // (Optional)
            // "show" is called just after an item is added.  The item is hidden
            // at this point.  If a show callback is not given the item will
            // have $(this).show() called on it.
            show: function () {
                $(this).slideDown();
            },
            // (Optional)
            // "hide" is called when a user clicks on a data-repeater-delete
            // element.  The item is still visible.  "hide" is passed a function
            // as its first argument which will properly remove the item.
            // "hide" allows for a confirmation step, to send a delete request
            // to the server, etc.  If a hide callback is not given the item
            // will be deleted.
            hide: function (deleteElement) {
                if (confirm('Tem certeza que deseja excluir?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            // (Optional)
            // You can use this if you need to manually re-index the list
            // for example if you are using a drag and drop library to reorder
            // list items.
            //ready: function (setIndexes) {
            //  $dragAndDrop.on('drop', setIndexes);
            //},
            // (Optional)
            // Removes the delete button from the first list item,
            // defaults to false.
            isFirstItemUndeletable: true
        });
</script>

<!-- Google maps function -->
<script src="../../js/maps.js"></script>


<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjTs0nbQbEecUygnKpThLfzRKES8nKS0A&callback=initMap"></script>


</body>

</html>
