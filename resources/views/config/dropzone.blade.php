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

        <link href="../assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
        <!--<script src="../js/ajax.js"></script>-->

@else
    @include('includes.head-edit')
    <!--<link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />-->
        <link href="../../assets/pages/css/search.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/navbar.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/page-config.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/geral.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
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
                                    <h1>Configurações
                                        <small>Importações</small>
                                    </h1>
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
                                                        <span class="caption-subject font-red bold uppercase">Atividades Recentes</span>
															<span class="caption-helper"></span>
                                                    </div> <!-- FIM DIV .caption.font-green-haze -->
                                                    <div class="actions">
                                                        <div class="btn-group btn-group-devided">
                                                            <div class="btn-group">
                                                                <a class="btn green btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
                                                                    <i class="fa fa-share"></i>
                                                                    <span class="hidden-xs"> Exportar </span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right" id="sample_3_tools">
                                                                    <li>
                                                                        <a href="javascript:;">
                                                                            <i class="fa fa-table" aria-hidden="true"></i>
                                                                            Excel (.xls)
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">
                                                                            <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                                                            CSV
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div> <!-- FIM DIV .actions -->
                                                </div> <!-- FIM DIV .portlet-title -->

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
                                                        <button type="button" class="btn green" id="btn-dropzone" onclick="dropzone()">
                                                            <i class="fa fa-check"></i> Enviar
                                                        </button>

                                                        <div class="progress" style="display: none;">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated active" role="progressbar" aria-valuenow="100"
                                                                 aria-valuemin="0" aria-valuemax="100" style="width: 100%">Enviando...</div>
                                                        </div>

                                                        <button class="btn btn-danger mt-sweetalert"
                                                                data-type="error" data-allow-outside-click="true" data-confirm-button-class="btn-danger"
                                                                id="error-msg" style="display: none;">
                                                        </button>
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

        </div>
        @include('includes.footer')
    </div><!-- FIM DIV.page-wrapper -->

@include('includes.core-scripts-edit')
<!-- SCRIPTS PAGINAS DE DROPZONE -->
<script src="../../assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/form-dropzone.js" type="text/javascript"></script>
<!-- FIM SCRIPTS PAGINAS DE DROPZONE -->
<script src="../../assets/pages/scripts/search.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/ui-sweetalert.min.js" type="text/javascript"></script>

<script>
    function dropzone()
    {
        $("#my-dropzone").submit();
        $("#btn-dropzone").css('display', "none");
        $(".progress").css("display", "block");
    }
</script>
</body>

</html>
