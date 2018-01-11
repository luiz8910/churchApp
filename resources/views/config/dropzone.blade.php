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
        <link href="../../uploadify/uploadify.css" rel="stylesheet" type="text/css">
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

                                        @if(Session::has('upload.success'))
                                            <div class="col-md-12">
                                                <div class="alert alert-success alert-dismissible" id="alert-danger" role="alert" style="display: block;">
                                                    <button type="button" class="close" id="button-danger" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <strong>Sucesso</strong> {{ Session::get('upload.success') }}
                                                </div>
                                            </div>

                                            <?php echo "<script> $('.progress').css('display', 'none'); $('#btn-dropzone').css('display', 'block');</script>" ;?>
                                        @endif

                                        @if(Session::has('rollback.message'))
                                            <div class="col-md-12">
                                                <div class="alert alert-success alert-dismissible" role="alert" style="display: block;">
                                                    <button type="button" class="close" id="button-danger" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <strong>Sucesso</strong> {{ Session::get('rollback.message') }}
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-md-12">
                                            <div class="portlet light ">
                                                <div class="portlet-title">
                                                    <div class="caption font-green-haze">
                                                        <i class="icon-settings font-green-haze"></i>
                                                        <span class="caption-subject bold uppercase"> Importar base de dados</span>
														<span class="caption-helper"></span>
                                                    </div> <!-- FIM DIV .caption.font-green-haze -->
                                                    <div class="actions">
														<div class="btn-group">
															<a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
																<i class="fa fa-cloud-download"></i>
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
                                                        <div class="btn-group">
															<a class="btn purple btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
																<i class="fa fa-share"></i>
																<span class="hidden-xs"> Reverter Importação </span>
                                                                <i class="fa fa-angle-down"></i>
															</a>
                                                            <ul class="dropdown-menu pull-right" id="sample_3_tools">
                                                                @foreach($imports as $import)
                                                                    <li>
                                                                        <a href="javascript:;" onclick="sweetRollback('{{ $import[0]->code }}', '{{ $import[0]->day }}')">
                                                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                                                            {{ $import[0]->day }} ({{ $import[0]->table }})
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
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

                                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#info" id="btn-info-upload">
                                                            <i class="fa fa-info-circle"></i> Instruções para upload
                                                        </button>

                                                        @if(Session::has('rollback.errors'))
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#error">
                                                                <i class="fa fa-exclamation-circle"></i> Erros da ult. Importação
                                                            </button>
                                                        @endif

                                                        <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title" id="myModalLabel">Instruções</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Upload em 3 passos</p>

                                                                        <p>1. Os dados referentes ao estado civil não devem conter parentêses ou outros símbolos</p>
                                                                        <p></p>

                                                                        <p> &nbsp; &nbsp; &nbsp; Errado: Casado(a), Casada</p>
                                                                        <p> &nbsp; &nbsp; &nbsp; Certo: Casado</p>

                                                                        <p>2. Ainda sobre o estado civil do membro, as opções podem ser</p>
                                                                            <p></p>
                                                                            <p> &nbsp; &nbsp; &nbsp; a. Casado</p>
                                                                            <p> &nbsp; &nbsp; &nbsp; b. Solteiro</p>
                                                                            <p> &nbsp; &nbsp; &nbsp; c. Viúvo</p>
                                                                            <p> &nbsp; &nbsp; &nbsp; d. Divorciado</p>

                                                                        <p>3. Coluna Classificação</p>
                                                                        <p></p>

                                                                            <p> &nbsp; &nbsp; &nbsp; Classificação do membro nada mais é que a situação cadastral do membro.
                                                                                Se classificação for <strong>"DESLIGADO"</strong> então o membro será cadastrado como inativo</p>
                                                                        <p></p>
                                                                        <p></p>

                                                                        <p>Faça o download da planilha modelo no botão download abaixo</p>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                                                                        <button type="button" class="btn btn-success" onclick="downloadPlan()">
                                                                            <i class="fa fa-download"></i> Download
                                                                        </button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title" id="myModalLabel">Erros</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Detalhes dos Erros</p>



                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        {!! Form::open(['route' => 'download.plan', 'method' => 'GET', 'id' => 'form-downloadPlan']) !!}
                                                        {!! Form::close() !!}

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
<script src="../../uploadify/jquery.uploadify.min.js" type="text/javascript" ></script>

<script>

    function downloadPlan()
    {
        $("#form-downloadPlan").submit();
    }

    function dropzone()
    {
        $("#my-dropzone").submit();
    }

</script>
</body>

</html>
