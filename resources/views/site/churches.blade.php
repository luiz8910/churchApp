<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    @include('includes.head')
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-boxed">
    <div class="page-wrapper">
        <div class="page-wrapper-row">
            <div class="page-wrapper-top">
                <!-- BEGIN HEADER -->
                @include('includes.header-admin')
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
                                    <h1>Igrejas</h1>
                                </div>
                            </div> <!-- FIM DIV .container -->
                        </div> <!-- FIM DIV .page-head -->

                        <div class="page-content">
                            <div class="container">
                                @if(Session::has('success.msg'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        {{ Session::get('success.msg') }}
                                    </div>
                                @endif

                                    @if(Session::has('error.msg'))
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            {{ Session::get('error.msg') }}
                                        </div>
                                    @endif

                                <?php $route = "person";?>

                                <div class="page-content-inner">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light">
                                                <div class="portlet-title">
                                                    <div class="caption font-green-haze">
                                                        <i class="fa fa-user font-green-haze"></i>
                                                        <span class="caption-subject font-green-haze bold ">Igrejas</span>
                                                    </div>
                                                    <div class="actions">
                                                        <div class="btn-group btn-group-sm">

                                                                <div class="col-lg-9">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" id="btn-search" placeholder="Digite 3 letras ou mais...">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn btn-default" type="button">
                                                                                    <i class="fa fa-search font-green"></i>
                                                                                </button>
                                                                            </span>
                                                                    </div><!-- /input-group -->
                                                                </div><!-- /.col-lg-8 -->


                                                                <div class="col-lg-3">
                                                                    <a class="btn red btn-outline btn-circle btn-sm" href="javascript:;"
                                                                       data-toggle="dropdown" style="margin-top: 3px; margin-left: -10px;">
                                                                        <i class="fa fa-share"></i>
                                                                        <span class="hidden-xs"> Opções </span>
                                                                        <i class="fa fa-angle-down"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu pull-right" id="sample_3_tools">
                                                                        <li>
                                                                            <a href="javascript:;" id="print" onclick="printDiv('printable-table')"
                                                                               data-action="0" class="tool-action">
                                                                                <i class="icon-printer"></i> Imprimir
                                                                            </a>
                                                                        </li>
                                                                        <!--<li>
                                                                            <a href="javascript:;" data-action="1" class="tool-action">
                                                                                <i class="icon-check"></i> Copiar</a>
                                                                        </li>-->
                                                                        <li>
                                                                            <a href="javascript:;" data-action="2"
                                                                               onclick="printDiv('printable-table', 'pdf')" class="tool-action">
                                                                                <i class="icon-doc"></i> PDF</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route($route.'.excel', ['format' => 'xls']) }}"
                                                                               data-action="3" target="_blank"
                                                                               class="tool-action">
                                                                                <i class="icon-paper-clip"></i> Excel</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route($route.'.excel', ['format' => 'csv']) }}"
                                                                               data-action="4" target="_blank" class="tool-action">
                                                                                <i class="icon-cloud-upload"></i> CSV</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>



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
                                                                    {{--<th> Foto </th>--}}
                                                                    <th> Nome </th>
                                                                    <th> Email </th>
                                                                    <th> Telefone </th>
                                                                    <th> Sigla </th>
                                                                    <th> Cliente desde </th>
                                                                    <th>  </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="hide" id="tbody-search"></tbody>
                                                                <tbody>
                                                                    @foreach($churches as $item)
                                                                        <tr id="tr-{{ $item->id }}">
                                                                            {{--<td> <img src="{{ $item->imgProfile }}" style="width: 50px; height: 50px;"> </td>--}}
                                                                            <td>{{ $item->name }}</td>

                                                                            <td>{{ $item->email }}</td>

                                                                            <td> {{ $item->tel }} </td>

                                                                            <td> {{ $item->alias }} </td>

                                                                            <td> {{ $item->sinceOf }} </td>

                                                                            <td>

                                                                                <button class="btn btn-success btn-sm btn-circle">
                                                                                    <i class="fa fa-pencil"></i>
                                                                                    Editar
                                                                                </button>

                                                                                <button class="btn btn-danger btn-sm btn-circle btn-delete" title="Deseja Excluir a Igreja"
                                                                                        id="btn-delete-{{ $item->id }}">
                                                                                    <i class="fa fa-ban"></i>
                                                                                    Bloquear
                                                                                </button>

                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            <br>
                                                            <div class="pull-right" id="pagination">
                                                                {{ $churches->links() }}
                                                            </div>
                                                        </div> <!-- FIM DIV .table-scrollable table-scrollable-borderless -->
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

    </div>

    @include('includes.footer')
    @include('includes.core-scripts')
</body>

</html>