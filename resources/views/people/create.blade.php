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
    @include('includes.head')
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
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
                    <h1>Bootstrap Form Controls
                        <small>bootstrap form controls and more</small>
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
                        <a href="#">Membros</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Novo</span>
                    </li>
                </ul>
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->

                @if(Session::has("email.exists"))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Erro!</strong> {{ Session::get("email.exists") }}
                    </div>
                @endif

                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12 ">
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="fa fa-user font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase"> Novo Membro</span>
                                    </div>
                                    <!--<div class="actions">
                                        <div class="btn-group">
                                            <a class="btn btn-sm green dropdown-toggle" href="javascript:;"
                                               data-toggle="dropdown"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-trash-o"></i> Delete </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-ban"></i> Ban </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="javascript:;"> Make admin </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>-->
                                </div>
                                <div class="portlet-body form">
                                    {!! Form::open(['route' => 'person.store', 'method' => 'POST', 'class' => 'repeater',
                                    'enctype' => 'multipart/form-data', 'role' => 'form', 'id' => 'form']) !!}
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
                                                               placeholder="José" value="{{ old('name') }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Sobrenome</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>
                                                        <input type="text" name="lastName" class="form-control"
                                                               placeholder="da Silva" value="{{ old('lastName') }}" required>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group" id="form-email">
                                                    <label>Email</label>
                                                    <div class="input-group input-icon right">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope font-blue" id="icon-email"></i>
                                                            </span>
                                                        <input type="text" name="email" id="email" class="form-control"
                                                               placeholder="email@dominio.com" value="{{ old('email') }}" required>
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
                                                        <input type="text" class="form-control tel" name="cel"
                                                               id="exampleInputPassword1" value="{{ old('cel') }}" placeholder="(15) 9231413423">
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
                                                               id="exampleInputPassword1" value="{{ old('tel') }}" placeholder="(15) 1231413423">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Gênero</label>
                                                    <div class="input-icon input-icon-lg">
                                                        <select class="form-control" name="gender" required>
                                                            <option value="">Selecione</option>
                                                            <option value="M" @if(old('gender') == "M") selected @endif>
                                                                Masculino
                                                            </option>
                                                            <option value="F" @if(old('gender') == "F") selected @endif>
                                                                Feminino
                                                            </option>
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
                                                               placeholder="dd/mm/aaaa" maxlength="10" value="{{ old('dateBirth') }}" required>
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
                                                               placeholder="XXXXXXXXXXX" value="{{ old('cpf') }}">
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
                                                               placeholder="XX.XXX.XXX-X" value="{{ old('rg') }}" maxlength="9" minlength="9">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Cargo</label>
                                                    <div class="input-icon input-icon-sm">
                                                        <i class="fa fa-briefcase"></i>
                                                        <select class="form-control" name="role_id" required>
                                                            <option value="">Selecione</option>
                                                            @foreach($roles as $role)
                                                                <option value="{{ $role->id }}"
                                                                        @if(old('role_id') == $role->id) selected @endif>
                                                                    {{ $role->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Estado Civil</label>
                                                    <select name="maritalStatus" id="maritalStatus" class="form-control" required>
                                                        <option value="">Selecione</option>
                                                        <option value="Casado" @if(old('maritalStatus') == "Casado") selected @endif>
                                                            Casado
                                                        </option>
                                                        <option value="Solteiro" @if(old('maritalStatus') == "Solteiro") selected @endif>
                                                            Solteiro
                                                        </option>
                                                        <option value="Divorciado" @if(old('maritalStatus') == "Divorciado") selected @endif>
                                                            Divorciado
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group" id="form-partner" hidden>
                                                    <label>Nome Cônjuge</label>
                                                    <select name="partner" id="partner" class="selectpicker
                                                          form-control"
                                                            data-live-search="true" data-size="8">
                                                        <option value="0">Parceiro(a) fora da igreja</option>
                                                        @foreach($adults as $adult)
                                                            <option value="{{ $adult->id }}">{{ $adult->name }} {{ $adult->lastName }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <br>
                                        <div class="caption caption-md">
                                            <i class="icon-globe theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase">Dados Familiares</span>
                                        </div>
                                        <hr><br>


                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome do Pai</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-male font-blue"></i>
                                                            </span>
                                                        <select name="father_id" class="selectpicker form-control"
                                                            data-live-search="true" data-size="8">

                                                            <option value="">Selecione</option>

                                                            @foreach($fathers as $parent)
                                                                <option value="{{ $parent->id }}">
                                                                    {{ $parent->name }} {{ $parent->lastName }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome da Mãe</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-female font-red"></i>
                                                            </span>
                                                        <select name="mother_id" class="selectpicker form-control"
                                                                data-live-search="true" data-size="8">

                                                            <option value="">Selecione</option>

                                                            @foreach($mothers as $parent)
                                                                <option value="{{ $parent->id }}">
                                                                    {{ $parent->name }} {{ $parent->lastName }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-12">
                                                <fieldset>
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" name="parents" class="checkboxes check-model"
                                                               id="check-parents" value="1" />
                                                        <span></span>Selecione se os pais não pertencem a igreja
                                                    </label>
                                                </fieldset>
                                            </div>

                                            <br>

                                            <div class="col-md-6">
                                                <div class="form-group parent" hidden>
                                                    <label>Nome do Pai</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-male font-blue"></i>
                                                            </span>
                                                        <input type="text" class="form-control" name="father_id_input"
                                                               placeholder="José da Silva" value="{{ old('father_id') }}">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group parent" hidden>
                                                    <label>Nome da Mãe</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-female font-red-pink"></i>
                                                            </span>
                                                        <input type="text" name="mother_id_input" class="form-control"
                                                               placeholder="Maria das Dores" value="{{ old('mother_id') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <div data-repeater-list="group-a">
                                                        <div data-repeater-item>
                                                            <div class="table-container">
                                                                <table class="table">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">

                                                                                <span class="input-group-addon">
                                                                                    <i class="fa fa-users"></i>
                                                                                </span>
                                                                                <input type="text" name="childName"
                                                                                       class="form-control"
                                                                                       placeholder="Nome"/>

                                                                            </div>
                                                                            <br>
                                                                            <div class="input-group">

                                                                                <span class="input-group-addon">
                                                                                    <i class="fa fa-users"></i>
                                                                                </span>

                                                                                <input type="text" name="childLastName"
                                                                                       class="form-control"
                                                                                       placeholder="Sobrenome"/>

                                                                            </div>

                                                                            <br>
                                                                            <div class="form-group">
                                                                                <div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
                                                                                <span class="input-group-addon">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </span>

                                                                                    <input type="text" name="childDateBirth"
                                                                                           class="form-control input-date"
                                                                                           placeholder="data de Nasc. (dd/mm/aaaa)"/>

                                                                                </div>
                                                                            </div>


                                                                        </td>
                                                                        <td>
                                                                            <a data-repeater-delete type="button"
                                                                                   class="btn btn-danger">
                                                                            <i class="fa fa-close"></i>
                                                                            Excluir
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <a data-repeater-create type="button" class="btn btn-info">
                                                    <i class="fa fa-plus"></i> Adicionar Filhos
                                                </a> <small>Somente filhos menores de idade</small>
                                            </div>

                                        </div>

                                        <br><br>
                                        <div class="caption caption-md">
                                            <i class="icon-globe theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase">Endereço</span>
                                        </div>
                                        <hr><br>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="div-loading">
                                                    <i class="fa fa-refresh fa-spin fa-5x fa-fw"
                                                       id="icon-loading-cep">
                                                    </i>
                                                    <p class="text-center" id="p-loading-cep" style="display: block;">
                                                        Buscando Cep ...
                                                    </p>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 input-address">
                                                <div class="form-group">
                                                    <label>CEP (sem traços)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-location-arrow font-purple"></i>
                                                        </span>
                                                        <input type="text" id="zipCode" class="form-control"
                                                               name="zipCode" placeholder="XXXXXXXX" maxlength="9" value="{{ old('zipCode') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 input-address">
                                                <div class="form-group">
                                                    <label>Logradouro</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-home font-purple"></i>
                                                    </span>
                                                        <input class="form-control" name="street" id="street" type="text"
                                                               value="{{ old('street') }}" placeholder="Av. Antonio Carlos Comitre, 650">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 input-address">
                                                <div class="form-group">
                                                    <label>Bairro</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-home font-purple"></i>
                                                    </span>
                                                        <input class="form-control" name="neighborhood"
                                                               value="{{ old('neighborhood') }}" id="neighborhood" type="text" placeholder="Parque do Dolly">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 input-address">
                                                <div class="form-group">
                                                    <label>Cidade</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-building font-purple"></i>
                                                    </span>
                                                        <input class="form-control" name="city" id="city"
                                                               value="{{ old('city') }}" type="text" placeholder="Sorocaba">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 input-address">
                                                <div class="form-group">
                                                    <label>Estado</label>
                                                    <select name="state" class="form-control" id="state">
                                                        <option value="">Selecione</option>
                                                        @foreach($state as $item)
                                                            <option value="{{ $item->initials }}" @if(old('state') == $item->initials) selected @endif>
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
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=foto+do+perfil" alt="" /> </div>
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
                                            </div>
                                        </div>

                                        <h3>Senha</h3>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Senha</label>
                                                    <div class="input-group input-icon right">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-lock font-blue" id="icon-password"></i>
                                                        </span>

                                                        <input type="password" name="password" id="password"
                                                               placeholder="Digite sua senha" class="form-control" minlength="6" required>

                                                        <i class="fa fa-check font-green" id="icon-success-password" style="display: none;"></i>
                                                        <i class="fa fa-exclamation font-red" id="icon-error-password" style="display: none;"></i>

                                                    </div>

                                                    <span class="help-block" id="passDontMatch" style="display: none; color: red;">
                                                            <i class="fa fa-ban font-red"></i>
                                                            As senhas não combinam
                                                        </span>

                                                    <span class="help-block" id="passMatch" style="display: none; color: #3598DC;">
                                                            <i class="fa fa-check font-blue"></i>
                                                            Senha válida
                                                        </span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Confirme sua Senha</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-lock font-blue"></i>
                                                        </span>

                                                        <input type="password" id="confirm-password" name="confirm-password"
                                                               placeholder="Confirme sua senha" class="form-control" required>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        {!! Form::submit('Enviar', ['class' => 'btn blue', 'id' => 'btn-submit']) !!}
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
                            <!-- END SAMPLE FORM PORTLET-->
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

@include('includes.core-scripts')
<script src="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
    $(document).ready(function () {
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
        })
    });
</script>
</body>

</html>