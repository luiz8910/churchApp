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
                                <h1>{{ $title }}</h1>
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
                                                    <span class="caption-subject font-green-haze bold ">{{ $title }}</span>
                                                </div>
                                                <div class="actions">
                                                    <div class="btn-group btn-group-sm">

                                                        @if(!isset($search_not_ready))
                                                            <div class="col-lg-8">
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
                                                        @endif

                                                        <input type="hidden" value="{{ $table }}" id="table">
                                                        @if(isset($deleted))
                                                            <input type="hidden" value="1" id="deleted">
                                                        @endif
                                                        <input type="hidden" value="{{ $text_delete }}" id="text-delete">

                                                        @if(isset($person_id))
                                                            <input type="hidden" value="{{ $person_id }}" id="person_id">
                                                        @endif


                                                        <div class="col-lg-3">
                                                            <a class="btn red btn-outline btn-circle btn-sm"
                                                               href="javascript:;" data-toggle="dropdown">
                                                                <i class="fa fa-share"></i>
                                                                <span class="hidden-xs"> Opções </span>
                                                                <i class="fa fa-angle-down"></i>
                                                            </a>
                                                            <ul class="dropdown-menu pull-right"
                                                                id="sample_3_tools">

                                                                @if(isset($doc))
                                                                    <li>
                                                                        <a href="javascript:" class="tool-action" id="upload-doc">
                                                                            <i class="fa fa-plus font-blue"></i>
                                                                            <span>Documento</span>
                                                                        </a>
                                                                    </li>



                                                                @endif

                                                                @foreach($buttons as $btn)

                                                                    @if($btn["route"])
                                                                        <li>
                                                                            <a class="tool-action"
                                                                                    href="{{ route($btn["route"]) }}">
                                                                                <i class="fa {{ $btn['icon'] }} font-blue"></i>
                                                                                <span>{{ $btn["name"] }}</span>
                                                                            </a>
                                                                        </li>
                                                                    @else
                                                                        <li>
                                                                            <a class="tool-action"
                                                                                    href="javascript:;" id="{{ $btn['modal'] }}">
                                                                                <i class="fa {{ $btn['icon'] }} font-blue"></i>
                                                                                <span>{{ $btn["name"] }}</span>
                                                                            </a>

                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
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
                                                                    <li>
                                                                        <a href="route($route.'.excel', ['format' => 'xls']) }}"
                                                                           data-action="3" target="_blank"
                                                                           class="tool-action">
                                                                            <i class="icon-paper-clip"></i> Excel</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href=" route($route.'.excel', ['format' => 'csv']) }}"
                                                                           data-action="4" target="_blank"
                                                                           class="tool-action">
                                                                            <i class="icon-cloud-upload"></i> CSV</a>
                                                                    </li>
                                                                </ul>
                                                            </div>-->




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
                                                                @foreach($th as $t)
                                                                    <th>{{ $t }}</th>
                                                                @endforeach

                                                            </tr>
                                                            </thead>
                                                            <tbody class="hide" id="tbody-search"></tbody>
                                                            <tbody>
                                                            @foreach($model as $item)



                                                                <tr id="tr-{{ $item[$columns[0]] }}">
                                                                    @if(!isset($doc))
                                                                        <td><img src="{{ $item[$columns[1]] }}"
                                                                                 style="width: 50px; height: 50px;">
                                                                        </td>

                                                                        <td>

                                                                            <a href="{{ route($table . '.edit', ['id' => $item->id]) }}">
                                                                                {{ $item[$columns[2]] }}</a>

                                                                        </td>

                                                                        @if(count($columns) > 3)
                                                                            <td>{{ $item[$columns[3]] }}</td>
                                                                        @endif

                                                                        @if(count($columns) > 4)
                                                                            <td>{{ $item[$columns[4]] }}</td>
                                                                        @endif

                                                                        @if(count($columns) > 5)
                                                                            <td>{{ $item[$columns[5]] }}</td>
                                                                        @endif

                                                                        @else

                                                                            @if(count($columns) > 1)
                                                                                <td>{{ $item[$columns[1]] }}</td>
                                                                            @endif

                                                                            @if(count($columns) > 2)
                                                                                <td>{{ $item[$columns[2]] }}</td>
                                                                            @endif

                                                                            @if(count($columns) > 3)
                                                                                <td>{{ $item[$columns[3]] }}</td>
                                                                            @endif

                                                                            @if(count($columns) > 4)
                                                                                <td>{{ $item[$columns[4]] }}</td>
                                                                            @endif

                                                                            @if(count($columns) > 5)
                                                                                <td>{{ $item[$columns[5]] }}</td>
                                                                            @endif


                                                                    @endif

                                                                    @if(isset($deleted))
                                                                            <td>
                                                                                <a href="javascript:;" class="btn btn-success btn-sm btn-circle btn-active-custom"
                                                                                   id="btn-active-custom-{{ $item[$columns[0]] }}">
                                                                                    <i class="fa fa-check"></i>
                                                                                    Recuperar
                                                                                </a>

                                                                            </td>

                                                                    @else
                                                                        <td>
                                                                            @if(isset($doc))
                                                                                <a href="javascript:;" class="btn btn-success btn-circle btn-download-custom"
                                                                                   id="btn-download-custom-{{ $item[$columns[0]] }}">
                                                                                    <i class="fa fa-download"></i>
                                                                                </a>

                                                                                <a href="javascript:;" class="btn btn-danger btn-circle btn-del-custom"
                                                                                   id="btn-del-custom-{{ $item[$columns[0]] }}">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </a>
                                                                            @else
                                                                                <a href="javascript:;" class="btn btn-danger btn-circle btn-del-custom"
                                                                                   id="btn-del-custom-{{ $item[$columns[0]] }}">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </a>
                                                                            @endif
                                                                        </td>
                                                                    @endif

                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        <br>


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
<script src="js/exhibitors.js" type="text/javascript"></script>
<script src="js/custom.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

@if(isset($model_cat))
<!-- Modal -->
<div class="modal fade" id="new_cat" tabindex="-1" role="dialog" aria-labelledby="new_cat">
    <div class="modal-dialog" role="document">

        <form class="modal-content" action="{{ route($table . '.store.cat') }}" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Nova Categoria</h4>
            </div>


            <div class="modal-body">
                <input type="text" required class="form-control" name="name" placeholder="Nome da Categoria">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Fechar
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check"></i>
                    Salvar
                </button>
            </div>

        </form>
    </div>
</div>


<div class="modal fade" id="list_cat" tabindex="-1" role="dialog" aria-labelledby="new_cat">
    <div class="modal-dialog" role="document">

        <form class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Lista de Categorias</h4>
            </div>

            <div class="modal-body">
                <table class="table table-hover table-light table-striped">
                    <thead>
                    <tr class="uppercase">
                        <th> Nome</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>

                        @foreach($model_cat as $category)
                            <td>{{ $category->name }}</td>
                        @endforeach

                    </tr>

                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Fechar
                </button>
            </div>

        </form>
    </div>
</div>
@endif

@if(isset($model_list))
    <div class="modal fade" id="modal_list" tabindex="-1" role="dialog" aria-labelledby="list">
        <div class="modal-dialog" role="document">

            <form class="modal-content" action="{{ route($table.'.index') }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">@if(isset($title_modal)){{ $title_modal }}@else Lista @endif</h4>
                </div>

                <div class="modal-body">

                    <label for="list">{{ $title_modal }}</label>

                    <select name="list" class="form-control" id="model_list" required>

                        <option value="">Selecione</option>

                        <option value="0">Todos</option>

                        @foreach($model_list as $item)

                            <option value="{{ $item->id }}">{{ $item->name }}</option>

                        @endforeach

                    </select>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i>
                        Filtrar
                    </button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-close"></i>
                        Fechar
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="upload">
        <div class="modal-dialog" role="document">

            <form class="modal-content" id="form-file" action="{{ route($table.'.'.$create) }}" enctype="multipart/form-data" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Upload</h4>
                </div>

                <div class="modal-body">

                    <label for="event">Eventos</label>

                    <select name="event_id" class="form-control" id="model_list">

                        <option value="">Selecione</option>

                        @foreach($model_list as $item)

                            <option value="{{ $item->id }}">{{ $item->name }}</option>

                        @endforeach

                    </select>

                    <br>



                    <div style="margin: 0 auto">
                        <a href="javascript:" class="btn btn-success" id="btn-file">
                            <i class="fa fa-file"></i>
                            Escolher Arquivo
                        </a>

                        <span id="file-name"></span>
                    </div>

                    <input type="file" name="file" id="file" style="display: none;" required>

                </div>

                <div class="modal-footer">
                    <button type="submit" id="btn-sub-file" class="btn btn-success">
                        <i class="fa fa-check"></i>
                        Upload
                    </button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-close"></i>
                        Fechar
                    </button>
                </div>

            </form>
        </div>
    </div>
@endif



</body>

</html>
