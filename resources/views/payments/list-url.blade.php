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
@include('includes.head')
<!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet"
          type="text/css"/>
    <link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-boxed">
<div class="page-wrapper">
    <div class="page-wrapper-row">
        <div class="page-wrapper-top">
            <!-- BEGIN HEADER -->
        @include('includes.header')

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
                                <h1>Pagamentos
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
                                                    <span class="caption-subject font-green-haze bold ">Pagamentos (links)</span>
                                                </div>
                                                <div class="actions">
                                                    <div class="btn-group btn-group-sm">
                                                        @if(Auth::user()->person->role_id == $leader
                                                        || Auth::user()->person->role_id == $admin)
                                                            <div class="col-lg-8 col-xs-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                           id="btn-search"
                                                                           placeholder="Digite 3 letras ou mais...">
                                                                    <span class="input-group-btn">
																					<button class="btn btn-default"
                                                                                            type="button">
                                                                                        <i class="fa fa-search font-green"></i>
                                                                                    </button>
																				</span>
                                                                </div><!-- /input-group -->
                                                            </div><!-- /.col-lg-8 -->


                                                            <div class="col-lg-2 col-xs-2">
                                                                <a class="btn green btn-outline btn-circle btn-sm"
                                                                   href="javascript:;" data-toggle="dropdown" style="margin-top: 2px; float: left;">
                                                                    <i class="fa fa-share"></i>
                                                                    <span class="hidden-xs"> Opções </span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right"
                                                                    id="sample_3_tools">

                                                                    <!--<li>
                                                                            <a class="tool-action"
                                                                               href=""
                                                                               style="margin-top: 2px;">
                                                                                <i class="fa fa-plus font-blue"></i>
                                                                                Novo Participante
                                                                            </a>
                                                                        </li>

                                                                        <li>
                                                                            <a href="javascript:;" data-action="1" class="tool-action">
                                                                                <i class="icon-check"></i> Copiar</a>
                                                                        </li>-->
                                                                    <li>
                                                                        <a href="javascript:;" data-action="2"
                                                                           onclick="printDiv('printable-table', 'pdf')"
                                                                           class="tool-action">
                                                                            <i class="icon-doc"></i> PDF</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href=""
                                                                           data-action="3" target="_blank"
                                                                           class="tool-action">
                                                                            <i class="icon-paper-clip"></i> Excel</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href=""
                                                                           data-action="4" target="_blank"
                                                                           class="tool-action">
                                                                            <i class="icon-cloud-upload"></i> CSV</a>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                        @else

                                                            <div class="col-lg-12">
                                                                <div class="btn-group-devided">
                                                                    <a role="button"
                                                                       class="btn btn-info btn-circle btn-sm"
                                                                       href="{{ route('new.url.payment') }}"
                                                                       style="margin-top: 2px;">
                                                                        <i class="fa fa-plus"></i>
                                                                        <span class="hidden-xs hidden-sm">Novo Link</span>
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
                                                    <div class="table-scrollable table-scrollable-borderless table-striped">
                                                        <table class="table table-hover table-light table-striped">
                                                            <thead>
                                                            <tr class="uppercase">
                                                                <th> Nome </th>
                                                                <th> Link </th>
                                                                <th> Expira em </th>
                                                                <th> Método de Pagamento </th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="hide" id="tbody-search"></tbody>
                                                            <tbody>

                                                            @if($urls)
                                                                @foreach($urls as $url)
                                                                    <tr>
                                                                        <td>{{ $url->name }}</td>
                                                                        <td>https://beconnect.com.br/url/{{ $url->url }}</td>
                                                                        <td>
                                                                            {{ $url->expires_in }}
                                                                        </td>
                                                                        <td>{{ $url->payment_method }}</td>
                                                                        <td>
                                                                            <a href="javascript:" class="btn btn-circle btn-info btn-sm">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </a>
                                                                            <a href="javascript:" class="btn btn-danger btn-sm btn-circle">
                                                                                <i class="fa fa-trash"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                        <br>
                                                        <div class="pull-right" id="pagination">

                                                        </div>

                                                        <div class="progress" id="progress-danger"
                                                             style="display: none;">
                                                            <div class="progress-bar progress-bar-danger progress-bar-striped active"
                                                                 role="progressbar" aria-valuenow="100"
                                                                 aria-valuemin="0" aria-valuemax="100"
                                                                 style="width: 100%">
                                                                Excluindo...
                                                                <span class="sr-only">Excluindo...</span>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" id="notific8-title">
                                                        <input type="hidden" id="notific8-text">
                                                        <input type="hidden" id="notific8-type" value="danger">

                                                        <a href="javascript:;" class="btn btn-danger" id="notific8"
                                                           style="display: none;">

                                                        </a>


                                                    </div>
                                                    <!-- FIM DIV .table-scrollable table-scrollable-borderless -->
                                                </div> <!-- FIM DIV .portlet-body-config -->
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

<!-- END CONTAINER -->
@include('includes.footer')
@include('includes.core-scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
        type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>
