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
                                <h1>
                                    <a href="{{ route('event.edit', ['event' => $event->id]) }}">
                                        {{ $event->name }}
                                    </a>
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
                                                    <span class="caption-subject font-green-haze bold ">Sessões</span>
                                                </div>
                                                <div class="actions">
                                                    <div class="btn-group btn-group-sm">
                                                        @if(Auth::user()->person->role_id == $leader
                                                        || Auth::user()->person->role_id == $admin)



                                                            <div class="col-lg-3">
                                                                <div class="btn-group-devided">
                                                                    <a role="button" id="btn-new-session"
                                                                       class="btn btn-info btn-circle btn-sm"
                                                                       href="javascript:;"
                                                                       style="margin-top: 2px;">
                                                                        <i class="fa fa-plus"></i>
                                                                        <span class="hidden-xs hidden-sm">Nova Sessão</span>
                                                                    </a>

                                                                </div>
                                                            </div>

                                                            <!--<div class="col-lg-3">
                                                                <a class="btn red btn-outline btn-circle btn-sm"
                                                                   href="javascript:;" data-toggle="dropdown">
                                                                    <i class="fa fa-share"></i>
                                                                    <span class="hidden-xs"> Opções </span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right"
                                                                    id="sample_3_tools">
                                                                    <li>
                                                                        <a href="javascript:;" id="print"
                                                                           onclick="printDiv('printable-table')"
                                                                           data-action="0" class="tool-action">
                                                                            <i class="icon-printer"></i> Imprimir
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" data-action="1" class="tool-action">
                                                                            <i class="icon-check"></i> Copiar</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" data-action="2"
                                                                           onclick="printDiv('printable-table', 'pdf')"
                                                                           class="tool-action">
                                                                            <i class="icon-doc"></i> PDF</a>
                                                                    </li>
                                                                </ul>
                                                            </div>-->

                                                        @else

                                                            <div class="col-lg-12">
                                                                <div class="btn-group-devided">
                                                                    <a role="button"
                                                                       class="btn btn-info btn-circle btn-sm"
                                                                       href="javascript:;"
                                                                       style="margin-top: 2px;">
                                                                        <i class="fa fa-plus"></i>
                                                                        <span class="hidden-xs hidden-sm">Nova Sessão</span>
                                                                    </a>

                                                                </div>
                                                            </div>

                                                        @endif


                                                    </div> <!-- FIM DIV .btn-group -->
                                                </div> <!-- FIM DIV .actions -->
                                            </div> <!-- FIM DIV .portlet-title -->

                                            <div class="portlet-body form">


                                                <div class="check-in">


                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="control-label">Participantes</label>
                                                                <select name="check-in" id="check-in" class="form-control">
                                                                    <option value="">Selecione</option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="control-label"></label>
                                                                <button class="btn btn-sm btn-success" style="margin-top: 28px;">
                                                                    <i class="fa fa-check"></i>
                                                                    Incluir
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="table-scrollable table-scrollable-borderless table-striped">
                                                                <table class="table table-hover table-light table-striped">
                                                                    <thead>
                                                                    <tr class="uppercase">
                                                                        <th> Foto</th>
                                                                        <th> Nome</th>
                                                                        <th> Opções</th>
                                                                        <th></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="hide" id="tbody-search"></tbody>
                                                                    <tbody>

                                                                    <tr>
                                                                        <td>
                                                                            <a href="javascript:">
                                                                                <img src="/uploads/profile/noimage.png" alt=""
                                                                                     style="width: 50px; height: 50px;">
                                                                            </a>
                                                                        </td>
                                                                        <td>Joãozinho</td>
                                                                        <td>
                                                                            <button class="btn btn-danger btn-sm btn-circle">
                                                                                <i class="fa fa-ban"></i>
                                                                                Cancelar
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="javascript:">
                                                                                <img src="/uploads/profile/noimage.png" alt=""
                                                                                     style="width: 50px; height: 50px;">
                                                                            </a>
                                                                        </td>
                                                                        <td>Joãozinho</td>
                                                                        <td>
                                                                            <button class="btn btn-danger btn-sm btn-circle">
                                                                                <i class="fa fa-ban"></i>
                                                                                Cancelar
                                                                            </button>
                                                                        </td>
                                                                    </tr>

                                                                    </tbody>
                                                                </table>
                                                                <br>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>




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
