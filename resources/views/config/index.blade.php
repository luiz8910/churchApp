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
@if(!isset($church_id) || $church_id == null)
    @include('includes.head')

    <!--<link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />-->
        <link href="../assets/pages/css/search.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/navbar.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../css/calendar.css">
        <!--<script src="../js/ajax.js"></script>-->

@else
    @include('includes.head-edit')
    <!--<link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />-->
        <link href="../../assets/pages/css/search.min.css" rel="stylesheet" type="text/css" />
        <link href="../../css/navbar.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../../css/calendar.css">
        <!--<script src="../js/ajax.js"></script>-->
    @endif

</head>
<!-- END HEAD -->

<body class="page-container-bg-solid">
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
                                    <h1> Configurações </h1>
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
                                        <span>Configurações</span>
                                    </li>
                                </ul>-->

                                <div class="alert alert-danger alert-dismissible" id="delete-group-alert" role="alert" style="display: none;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Atenção </strong><span id="message"></span>
                                </div>

                                @if(Session::has('error.field'))
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Atenção </strong> {{ Session::get('error.field') }}
                                    </div>
                                @endif
                                <!-- END PAGE BREADCRUMBS -->

                                <!-- Modal -->
                                <div class="modal fade" id="newModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Nova Classe</h4>
                                            </div>

                                            {!! Form::open(['route' => 'config.newModel', 'method' => 'POST']) !!}
                                            <div class="modal-body">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label> Model:</label>
                                                        <input type="text" name="model" class="form-control" required>

                                                    </div>

                                                    <div class="col-md-4">
                                                        <label> Text: </label>
                                                        <input type="text" name="text" class="form-control" required>
                                                    </div>

                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                <button class="btn btn-primary" type="submit">Salvar</button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>

                                <?php $i = 0; ?>

                                @foreach($models as $model)
                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- BEGIN BORDERED TABLE PORTLET-->
                                                <div class="portlet light portlet-fit ">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="icon-settings font-red"></i>
                                                            <span class="caption-subject font-red sbold uppercase">{{ $model->text }}</span>

                                                        </div>



                                                        <div class="actions">
                                                            <div class="btn-group btn-group-devided">

                                                                <div class="btn-group">
                                                                    <a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
                                                                        <i class="fa fa-share"></i>
                                                                        <span class="hidden-xs"> Opções </span>
                                                                        <i class="fa fa-angle-down"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu pull-right" id="sample_3_tools">
                                                                        <li>
                                                                            <a href="javascript:;" data-toggle="modal" data-target="#newModel">
                                                                                <i class="fa fa-table" aria-hidden="true"></i>
                                                                                Classe
                                                                            </a>
                                                                        </li>

                                                                        <li>
                                                                            <a href="javascript:;" data-toggle="modal" data-target="{{ '#newRule-' . $model->model }}">
                                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                                                Nova Regra
                                                                            </a>
                                                                        </li>

                                                                        <li>
                                                                            <a href="javascript:;">
                                                                                <i class="fa fa-undo" aria-hidden="true"></i>
                                                                                Voltar ao Padrão
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>


                                                            </div>

                                                        </div>
                                                    </div>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="{{ 'newRule-' . $model->model }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title" id="myModalLabel">Nova Regra - {{ $model->text }}</h4>
                                                                </div>

                                                                {!! Form::open(['route' => ['config.newRule', 'model' => $model->model], 'method' => 'POST']) !!}
                                                                <div class="modal-body">

                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label> Valor:</label>
                                                                            <input type="text" name="value" class="form-control" required>

                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label> Nome do Campo: </label>
                                                                            <input type="text" name="field" class="form-control" required>
                                                                        </div>


                                                                        <div class="col-md-4" style="margin-top: 30px;">
                                                                            <fieldset>
                                                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                                    <input type="checkbox" name="required" class="checkboxes check-model" id=""
                                                                                           value="1" />
                                                                                    <span></span>
                                                                                </label>
                                                                                <label class="lbl-txt">Obrigatório</label>
                                                                            </fieldset>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                                    <button class="btn btn-primary" type="submit">Salvar</button>
                                                                </div>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="portlet-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="required-fields">
                                                                    <h4>Campos Obrigatórios</h4>

                                                                    <br>



                                                                    {!! Form::open(['route' =>
                                                                        ['config.required.fields', 'model' => $model->model], 'method' => 'POST']) !!}


                                                                        <fieldset>
                                                                            @if(count($class[$i]) > 0)
                                                                                @foreach($class[$i] as $item)
                                                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                                        <input type="checkbox" name="{{ $item->value }}" class="checkboxes check-model" id=""
                                                                                               value="1" @if($item->required != null) checked @endif />
                                                                                        <span></span>
                                                                                    </label>
                                                                                    <label class="lbl-txt">{{ $item->field }}</label>
                                                                                @endforeach
                                                                            @endif

                                                                        </fieldset>

                                                                        <?php $i++; ?>

                                                                        <button class="btn btn-circle btn-primary" type="submit">
                                                                            <i class="fa fa-check font-white"></i>
                                                                            Enviar
                                                                        </button>
                                                                    {!! Form::close() !!}
                                                                </div>

                                                            </div>
                                                        </div>



                                                    </div>


                                                </div>
                                                <!-- END BORDERED TABLE PORTLET-->
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.footer')
    </div>

    <!-- END QUICK NAV -->
    @if(!isset($church_id) || $church_id == null)
        @include('includes.core-scripts')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <!--<script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>-->
        <!--<script src="../assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>-->
        <!--<script src="../assets/global/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>-->
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/search.min.js" type="text/javascript"></script>
        <!--<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>-->
    @else
        @include('includes.core-scripts-edit')
        <script src="../../assets/pages/scripts/search.min.js" type="text/javascript"></script>
    @endif

</body>

</html>