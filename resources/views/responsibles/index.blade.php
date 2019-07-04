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
                                <h1>
                                    <small></small>
                                </h1>
                            </div>
                        </div> <!-- FIM DIV .container -->
                    </div> <!-- FIM DIV .page-head -->

                    <div class="page-content">
                        <div class="container">
                            @if(Session::has('person.crud'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    {{ Session::get('person.crud') }}
                                </div>
                            @endif

                            @include('includes.messages')

                            <?php $route = "person";?>

                            <div class="page-content-inner">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption font-green-haze">
                                                    <i class="fa fa-user font-green-haze"></i>
                                                    <span class="caption-subject font-green-haze bold ">Responsáveis</span>
                                                </div>
                                                <div class="actions">
                                                    <div class="btn-group btn-group-sm">
                                                        @if(Auth::user()->person->role_id == $leader
                                                        || Auth::user()->person->role_id == $admin)



                                                            <div class="col-lg-2">
                                                                <a class="btn green btn-outline btn-circle btn-sm"
                                                                   href="javascript:;" data-toggle="dropdown" style="margin-top: 2px; float: left;">
                                                                    <i class="fa fa-share"></i>
                                                                    <span class="hidden-xs"> Opções </span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right"
                                                                    id="sample_3_tools">

                                                                    <li>
                                                                        <a class="tool-action"
                                                                           href="{{ route('person.index') }}"
                                                                           style="margin-top: 2px;">
                                                                            <i class="fa fa-users font-blue"></i>
                                                                            <span class="">Participantes</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" class="tool-action"
                                                                           data-target="#create-modal" data-toggle="modal">
                                                                            <i class="fa fa-plus font-blue"></i>
                                                                            Novo Responsável
                                                                        </a>
                                                                    </li>

                                                                    <!--<li>
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
                                                                        <a href="{{ route($route.'.excel', ['format' => 'xls']) }}"
                                                                           data-action="3" target="_blank"
                                                                           class="tool-action">
                                                                            <i class="icon-paper-clip"></i> Excel</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="{{ route($route.'.excel', ['format' => 'csv']) }}"
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
                                                                       href="{{ route('person.create') }}"
                                                                       style="margin-top: 2px;">
                                                                        <i class="fa fa-plus"></i>
                                                                        <span class="hidden-xs hidden-sm">Novo Participante</span>
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
                                                                <th> Abreviatura </th>
                                                                <th> Nome </th>
                                                                <th> Cargo </th>
                                                                <th> Cargo Sistema</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="hide" id="tbody-search"></tbody>
                                                            <tbody>

                                                            <?php $i = 0; ?>
                                                            @foreach($resp as $item)
                                                                <tr id="tr-{{ $item->id }}">
                                                                    <td>{{ $item->abbreviation }}</td>
                                                                    <td>

                                                                        {{ $item->name }}

                                                                    </td>

                                                                    <td> {{ $item->special_role }} </td>
                                                                    <td> {{ $item->role }} </td>

                                                                    <td>

                                                                        <?php $i++; ?>
                                                                        <div class="actions hidden-lg hidden-md">
                                                                            <div class="btn-group btn-group-sm" @if(count($resp) == $i || $paginate == $i) style="margin-bottom: 70px;" @endif>
                                                                                <a class="btn green btn-outline btn-circle btn-sm"
                                                                                   href="javascript:;" data-toggle="dropdown" style="margin-top: 2px; float: left;">
                                                                                    <i class="fa fa-share"></i>
                                                                                    <i class="fa fa-angle-down"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu pull-right" id="">
                                                                                    <li>
                                                                                        <a href="javascript:;" class="tool-action"
                                                                                           id="btn-edit-resp-{{ $item->id }}" data-toggle="modal" data-target="#edit-modal">
                                                                                            <i class="fa fa-pencil font-blue"></i>
                                                                                            Editar
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a href="javascript:" class="tool-action btn-delete-resp" id="btn-delete-resp-{{ $item->id }}">
                                                                                            <i class="fa fa-trash font-red"></i>
                                                                                            Inativar
                                                                                        </a>
                                                                                    </li>

                                                                                </ul>
                                                                            </div>


                                                                        </div>


                                                                        <button class="btn btn-info btn-sm btn-circle btn-edit-resp hidden-xs hidden-sm"
                                                                                title="Editar o Responsável"
                                                                                id="btn-edit-resp-{{ $item->id }}" data-toggle="modal" data-target="#edit-modal">
                                                                            <i class="fa fa-pencil"></i>
                                                                            <span class="hidden-sm hidden-xs">Editar</span>
                                                                        </button>

                                                                        <button class="btn btn-danger btn-sm btn-circle btn-delete-resp hidden-xs hidden-sm"
                                                                                title="Excluir o Responsável"
                                                                                id="btn-delete-resp-{{ $item->id }}">
                                                                            <i class="fa fa-trash"></i>
                                                                            <span class="hidden-sm hidden-xs">Inativar</span>
                                                                        </button>

                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>

                                                        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title text-center" id="myModalLabel">Editar Responsável</h4>
                                                                    </div>

                                                                    <form action="" method="POST" id="form-edit">
                                                                        {{ method_field('PUT') }}
                                                                        {{ csrf_field() }}



                                                                        <div class="modal-body">

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="">Abreviatura</label>
                                                                                        <input type="text" class="form-control" name="abbreviation" id="abbreviation"
                                                                                               placeholder="Dr., Eng. Me">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="">Nome</label>
                                                                                        <input type="text" class="form-control" name="name" id="name"
                                                                                               placeholder="Nome">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="">Cargo no Certificado</label>
                                                                                        <input type="text" class="form-control" name="special_role" id="special_role"
                                                                                               placeholder="Diretor, Presidente">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="">Cargo</label>
                                                                                        <select name="role_id" id="role_id" class="form-control">
                                                                                            @foreach($roles as $item)
                                                                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <div class="modal-footer">

                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                                                <i class="fa fa-close"></i>
                                                                                Cancelar
                                                                            </button>
                                                                            <button type="submit" class="btn btn-primary">
                                                                                <i class="fa fa-check"></i>
                                                                                Salvar
                                                                            </button>
                                                                        </div>

                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title text-center" id="myModalLabel">Criar Responsável</h4>
                                                                    </div>

                                                                    <form action="{{ route('responsibles.store.modal') }}" method="POST" id="form-create">

                                                                        {{ csrf_field() }}


                                                                        <div class="modal-body">

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="">Abreviatura</label>
                                                                                        <input type="text" class="form-control" name="abbreviation" id="abbreviation"
                                                                                               placeholder="Dr., Eng. Me">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="">Nome</label>
                                                                                        <input type="text" class="form-control" name="name" id="name"
                                                                                               placeholder="Nome">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="">Cargo no Certificado</label>
                                                                                        <input type="text" class="form-control" name="special_role" id="special_role"
                                                                                               placeholder="Diretor, Presidente">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="">Cargo</label>
                                                                                        <select name="role_id" id="role_id" class="form-control">
                                                                                            @foreach($roles as $item)
                                                                                                <option value="{{ $item->id }}"
                                                                                                    @if($item->id == 2) selected @endif>
                                                                                                    {{ $item->name }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <div class="modal-footer">

                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                                                <i class="fa fa-close"></i>
                                                                                Cancelar
                                                                            </button>
                                                                            <button type="submit" class="btn btn-primary">
                                                                                <i class="fa fa-check"></i>
                                                                                Salvar
                                                                            </button>
                                                                        </div>

                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br>
                                                        <div class="pull-right" id="pagination">
                                                            {{ $resp->links() }}
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

<!-- Modal -->
<div class="modal fade" id="transfer_users" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Transferir Usuários entre Organizações</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-users font-blue"></i>
                        </span>

                        <input type="text" class="form-control" placeholder="Digite aqui o nome de usuário" id="user">

                    </div>



                    <br><br>

                    <div class="table-scrollable table-scrollable-borderless ">
                        <table class="table table-hover table-light ">
                            <thead>
                            <tr class="uppercase">
                                <th> Foto</th>
                                <th> Nome</th>
                                <th> Adicionar </th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>
                                    <img src="uploads/profile/noimage.png" alt="" style="width: 50px; height: 50px;">
                                </td>
                                <td>
                                    Teste
                                </td>
                                <td>
                                    <input type="checkbox" id="switch" />
                                    <label for="switch">Toggle</label>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Fechar
                </button>
                <button type="button" class="btn btn-success btn-sm">
                    <i class="fa fa-check"></i>
                    Transferir
                </button>
            </div>
        </div>
    </div>
</div>

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
<script src="js/responsible.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>
