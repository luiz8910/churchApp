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
@include('includes.head-edit')
<!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet"
          type="text/css"/>
    <link href="../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet"
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
                                                    <span class="caption-subject font-green-haze bold ">Sessões - {{ $session->name }} - Quiz</span>
                                                </div>

                                                <div class="actions">
                                                    <div class="btn-group btn-group-sm">
                                                        @if(Auth::user()->person->role_id == $leader
                                                        || Auth::user()->person->role_id == $admin)
                                                            <div class="col-lg-3">
                                                                <div class="btn-group-devided">
                                                                    <a role="button"
                                                                       class="btn btn-info btn-circle btn-sm"
                                                                       href="{{ route('event.session.poll.create', ['session_id' => $session->id]) }}"
                                                                       style="margin-top: 2px;">
                                                                        <i class="fa fa-plus"></i>
                                                                        <span class="hidden-xs hidden-sm">Novo Quiz</span>
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
                                                        <div class="col-md-12">
                                                            <input type="hidden" id="person_id" value="{{ $person_id }}">

                                                            <div class="table-scrollable table-scrollable-borderless table-striped">
                                                                <table class="table table-hover table-light table-striped">
                                                                    <thead>
                                                                    <tr class="uppercase">
                                                                        <th>#</th>
                                                                        <th>Questão</th>
                                                                        <th>Opções</th>
                                                                        <th></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="hide" id="tbody-search"></tbody>
                                                                    <tbody>
                                                                    @foreach($polls as $poll)
                                                                        <tr>

                                                                            <td>{{$poll->content}}</td>
                                                                            <td class="d-flex-center">
                                                                                <a href="javascript:"
                                                                                   class="btn btn-warning btn-sm btn-circle btn-itens"
                                                                                   title="Visualizar Questão"
                                                                                   id="btn-itens-{{ $poll->id }}">
                                                                                    <i class="fa fa-eye"></i>
                                                                                </a>
                                                                                <a href="javascript:"
                                                                                   class="btn btn-danger btn-sm btn-circle btn-del"
                                                                                   title="Excluir Questão" id="btn-del-{{$poll->id}}">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
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

                            <div class="page-content-inner">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption font-green-haze">
                                                    <i class="fa fa-users font-green-haze"></i>
                                                    <span class="caption-subject font-green-haze bold ">Votos</span>
                                                </div>

                                                <div class="actions">

                                                </div> <!-- FIM DIV .actions -->
                                            </div> <!-- FIM DIV .portlet-title -->

                                            <div class="portlet-body form">


                                                <div class="check-in">
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="table-scrollable table-scrollable-borderless table-striped">
                                                                <table class="table table-hover table-light table-striped">
                                                                    <thead>
                                                                    <tr class="uppercase">
                                                                        <th>#</th>
                                                                        <th>Alternativas</th>
                                                                        <th>Quantidade</th>
                                                                        <th>%</th>
                                                                        <th></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="hide" id="tbody-search"></tbody>
                                                                    <tbody id="tbody-details">

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
@include('includes.core-scripts-edit')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
        type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
<script src="../../js/polls.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>
