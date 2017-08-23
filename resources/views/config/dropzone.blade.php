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
@if(!isset($church_id) || $church_id == null)
    @include('includes.head')

    <!--<link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />-->
        <link href="../assets/pages/css/search.min.css" rel="stylesheet" type="text/css"/>
        <link href="../css/navbar.css" rel="stylesheet" type="text/css"/>
        <link href="../css/page-config.css" rel="stylesheet" type="text/css"/>
        <link href="../css/dropzone.css" rel="stylesheet" type="text/css" />
        <!--<script src="../js/ajax.js"></script>-->

@else
    @include('includes.head-edit')
    <!--<link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />-->
        <link href="../../assets/pages/css/search.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/navbar.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/page-config.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/dropzone.css" rel="stylesheet" type="text/css" />
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
        </div> <!-- FIM DIV.page-wrapper-top -->
    </div> <!-- FIM DIV.page-wrapper-row -->

    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <div class="page-container">
                <div class="page-content-wrapper">
                    <div class="page-head">
                        <div class="container">
                            <div class="page-title">

                            </div>
                        </div> <!-- FIM DIV .container -->
                    </div> <!-- FIM DIV .page-head -->

                    <div class="page-content">
                        <div class="container">
                            <div class="page-content-inner">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="portlet-title">
                                                <div class="caption font-green-haze">
                                                    <i class="icon-settings font-green-haze"></i>
                                                    <span class="caption-subject bold uppercase"> Importar base de dados</span>
                                                </div> <!-- FIM DIV .caption.font-green-haze -->
                                                <div class="actions">
                                                    <div class="btn-group btn-group-devided">
                                                        <div class="btn-group">
                                                            {{--<a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
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
                                                                    <a href="javascript:;" data-toggle="modal" data-target="#newRule-person">
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
                                                            </ul>--}}
                                                        </div>
                                                    </div>
                                                </div> <!-- FIM DIV .actions -->
                                            </div> <!-- FIM DIV .portlet-title -->


                                            {{--<br><br>
                                            <button type="submit" class="btn green">
                                                <i class="fa fa-table"></i>
                                                Enviar Planilha
                                            </button>--}}



                                            <div class="portlet-body form">
                                                <div class="form-body">
                                                    {!! Form::open(['route' => 'config.person.contacts', 'method' => 'POST', 'enctype' => 'multipart/form-data',
                                                            'class' => 'dropzone dropzone-file-area', 'id' => 'my-dropzone', 'style' => 'margin-top: 30px; margin-bottom: 30px;']) !!}
                                                    {{--<form action="../assets/global/plugins/dropzone/upload.php" class="dropzone dropzone-file-area" id="my-dropzone" style=" margin-top: 30px; margin-bottom: 30px;">--}}
                                                        <h3 class="sbold">Solte as planilhas aqui ou clique para carregar</h3>
                                                        <p> <strong>Atenção!</strong> Somente arquivos do Excel(.xls ou .xlsx) </p>
                                                    {!! Form::close() !!}
                                                </div>  <!-- FIM DIV .form-body -->

                                                <div class="form-actions ">
                                                    <button type="button" class="btn green" onclick="dropzone()" disabled>
                                                        <i class="fa fa-check"></i> Enviar
                                                    </button>
                                                </div>
                                            </div> <!-- FIM DIV .portlet-body.form  -->
                                        </div> <!-- FIM DIV .portlet.light -->
                                    </div> <!-- FIM DIV .col-md-12 -->
                                </div> <!-- FIM DIV .row -->
                            </div> <!-- FIM DIV .page-content-inner -->
                        </div>  <!-- FIM DIV .container -->
                    </div>  <!-- FIM DIV .page-content -->
                </div> <!-- FIM DIV .page-content-wrapper -->
            </div> <!-- FIM DIV .page-container -->
        </div> <!-- FIM DIV .page-wrapper-middle -->
    </div> <!-- FIM DIV .page-wrapper-row.full-height -->
    @include('includes.footer')
</div> <!-- FIM DIV.page-wrapper -->

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

    <!-- SCRIPTS PAGINAS DE DROPZONE -->
    <script src="../assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
    <script src="../assets/pages/scripts/form-dropzone.js" type="text/javascript"></script>
    <!-- FIM SCRIPTS PAGINAS DE DROPZONE -->
@else
    @include('includes.core-scripts-edit')
    <!-- SCRIPTS PAGINAS DE DROPZONE -->
    <script src="../../assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
    <script src="../../assets/pages/scripts/form-dropzone.js" type="text/javascript"></script>
    <!-- FIM SCRIPTS PAGINAS DE DROPZONE -->
    <script src="../../assets/pages/scripts/search.min.js" type="text/javascript"></script>
@endif

<script>
    function dropzone()
    {
        $("#my-dropzone").submit();
    }
</script>
</body>

</html>