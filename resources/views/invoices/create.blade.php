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
    <style>
        .btn-item-list{
            margin-top: -5px;
            margin-left: 5px;
        }
    </style>

</head>
<!-- END HEAD -->


<body class="page-container-bg-solid page-boxed">

<!-- BEGIN HEADER -->
@include('includes.header-admin')
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head hidden-xs hidden-sm">
            <div class="container">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">

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
                        <a href="#">Membros</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Novo</span>
                    </li>
                </ul>-->
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->

                @if(Session::has("email.exists"))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Erro!</strong> {{ Session::get("email.exists") }}
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
                        <div class="col-md-12 ">
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="fa fa-user font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase"> Novo Invoice</span>
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

                                <?php $i = 0; ?>
                                <div class="portlet-body form">


                                    <form action="{{ route('invoice.store') }}" method="POST" id="form_create">
                                        {{ csrf_field() }}

                                        <div class="form-body">

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nome do Cliente (Org)</label>
                                                        <select name="customer_id" id="customer_id" class="form-control select2" required>
                                                            <option value="">Selecione</option>
                                                            @foreach($orgs as $org)
                                                                <option value="{{ $org->id }}">{{ $org->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group" id="form-email">
                                                        <label>Email</label>
                                                        <div class="input-group input-icon right">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-envelope font-blue" id="icon-email"></i>
                                                                </span>
                                                            <input type="text" name="email" id="email" class="form-control"
                                                                   placeholder="email@dominio.com" value="{{ old('email') }}" required>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Referência (Evento)</label>
                                                        <select name="event_id" id="event_id" class="form-control select2"></select>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Data</label>
                                                        <div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar font-blue"></i>
                                                                </span>
                                                            <input type="text" class="form-control input-date" name="date" autocomplete="new-password"
                                                                   placeholder="dd/mm/aaaa" maxlength="10" value="{{ old('date') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <br><br>

                                            <div class="caption caption-md">
                                                <i class="icon-globe theme-font hide"></i>
                                                <span class="caption-subject font-blue-madison bold uppercase">
                                                    <i class="fa fa-plus"></i> Itens no invoice
                                                </span>
                                            </div>
                                            <hr><br>

                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6" id="panel-itens" style="display: none;">
                                                    <div class="panel panel-default">
                                                        <!-- Default panel contents -->
                                                        <div class="panel-heading text-center">Itens Cadastrados</div>

                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Título</th>
                                                                    <th>Valor</th>
                                                                    <th>Opções</th>
                                                                </tr>

                                                            </thead>

                                                            <tbody id="tbody_itens">
                                                            </tbody>

                                                        </table>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="modal_edit_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title text-center" id="myModalLabel">Editar Item</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" id="div_title_modal">
                                                                        <input type="text" id="title_modal" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group" id="div_price_modal">
                                                                        <input type="text" id="price_modal" class="form-control">
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <input type="hidden" value="" id="item_id">

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <textarea id="description_modal" cols="30" rows="10" style="width: 100%;"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                            <button type="button" class="btn btn-primary" id="save_modal">Salvar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group" id="div_title">
                                                        <label for="">Título</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-pencil font-blue"></i>
                                                            </span>
                                                            <input type="text" class="form-control" id="title" placeholder="Título">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group" id="div_price">
                                                        <label for="">Preço</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                R$
                                                            </span>
                                                            <input type="text" class="form-control number" id="price" placeholder="10,00" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description">Descrição</label>

                                                            <textarea id="description" rows="10" style="width: 100%;"></textarea>

                                                    </div>
                                                </div>
                                            </div>

                                            <br>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <a href="javascript:" class="btn btn-primary" id="add_item">
                                                        <i class="fa fa-plus"></i>
                                                        Adicionar Item
                                                    </a>
                                                </div>
                                            </div>

                                            <br><br>

                                            <div id="print_div" style="display: none;"></div>
                                        </div>

                                        <div class="form-actions">
                                            <br><br>

                                            <button class="btn blue btn-block" id="btn-submit" type="submit" style="width: 49%;">
                                                <i class="fa fa-check"></i>
                                                Salvar
                                            </button>

                                            <button class="btn green btn-block" id="btn-print" type="button" style="width: 49%; margin-top: -34px; margin-left: 51%;">
                                                <i class="fa fa-eye"></i>
                                                Salvar e Visualizar
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

</div>
<!-- END CONTAINER -->
@include('includes.footer')

@include('includes.core-scripts')
<script src="../js/invoice.js"></script>

<script>
    const anElement = new AutoNumeric('#price', $("#price").val()).brazilian();
    const anElement2 = new AutoNumeric('#price_modal', $("#price_modal").val()).brazilian();
</script>

</body>

</html>
