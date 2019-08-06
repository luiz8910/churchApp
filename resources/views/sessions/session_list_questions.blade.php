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
    <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet"
          type="text/css"/>
    <link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet"
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
                                                    <span class="caption-subject font-green-haze bold ">Sessões - {{ $session->name }} - Perguntas</span>
                                                </div>
                                            </div> <!-- FIM DIV .portlet-title -->

                                            <div class="portlet-body form">

                                                <!-- Nav tabs -->
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li role="presentation" class="active"><a href="#pending" aria-controls="pending" role="tab" data-toggle="tab">Pendentes</a></li>
                                                    <li role="presentation"><a href="#approved" aria-controls="approved" role="tab" data-toggle="tab">Aprovadas</a></li>
                                                    <li role="presentation"><a href="#denied" aria-controls="denied" role="tab" data-toggle="tab">Negadas</a></li>

                                                </ul>

                                                <!-- Tab panes -->

                                                <div class="tab-content">
                                                    <div role="tabpanel" class="tab-pane active" id="pending">
                                                        <div class="check-in">
                                                            <div class="row">
                                                                <div class="col-md-12">

                                                                    <div class="table-scrollable table-scrollable-borderless table-striped">
                                                                        <table class="table table-hover table-light table-striped">
                                                                            <thead>
                                                                            <tr class="uppercase">
                                                                                <th>Usuário</th>
                                                                                <th>Pergunta</th>
                                                                                <th>Status</th>
                                                                                <th>Curtidas</th>
                                                                                <th>Opções</th>
                                                                                <th></th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody class="hide" id="tbody-search"></tbody>
                                                                            <tbody>

                                                                            @foreach($pending as $question)


                                                                                <tr>
                                                                                    <td>
                                                                                        <a href="javascript:">
                                                                                            <img src="/uploads/profile/noimage.png" alt=""
                                                                                                 style="width: 50px; height: 50px;">
                                                                                            <p>{{$question->person_name}}</p>
                                                                                        </a>
                                                                                    </td>
                                                                                    <td>{{ $question->content }}</td>


                                                                                    <td>
                                                                                        @if($question->status == 'approved')

                                                                                            <span class="label label-success">Aprovada</span>

                                                                                        @elseif($question->status == 'denied')

                                                                                            <span class="label label-danger">Não Aprovada</span>

                                                                                        @else
                                                                                            <span class="label label-warning">Pendente</span>
                                                                                        @endif
                                                                                    </td>

                                                                                    <td><span class="badge">{{$question->like_count}}</span></td>

                                                                                    <td>
                                                                                        <a href="{{ route('event.session.view_question', ['id' => $question->id]) }}"
                                                                                           class="btn btn-warning btn-sm btn-circle" title="Visualizar Pergunta"
                                                                                           data-toggle="modal" data-target="#modal-padrao" data-remote="false"
                                                                                           modal-remote="true">
                                                                                            <i class="fa fa-eye"></i>
                                                                                            Visualizar
                                                                                        </a>
                                                                                        @if($question->status == 'approved')
                                                                                            <button class="btn btn-danger btn-sm btn-circle btn-deny"
                                                                                                    id="btn-deny-{{ $question->id }}">
                                                                                                <i class="fa fa-ban"></i>
                                                                                            </button>
                                                                                        @endif

                                                                                        @if($question->status == 'pending')
                                                                                            <button class="btn btn-success btn-sm btn-circle btn-approve"
                                                                                                    id="btn-approve-{{ $question->id }}">
                                                                                                <i class="fa fa-thumbs-up"></i>
                                                                                            </button>

                                                                                            <button class="btn btn-danger btn-sm btn-circle btn-deny"
                                                                                                    id="btn-deny-{{ $question->id }}">
                                                                                                <i class="fa fa-ban"></i>
                                                                                            </button>
                                                                                        @endif

                                                                                        @if($question->status == 'denied')
                                                                                            <button class="btn btn-success btn-sm btn-circle btn-approve"
                                                                                                    id="btn-approve-{{ $question->id }}">
                                                                                                <i class="fa fa-thumbs-up"></i>
                                                                                            </button>
                                                                                        @endif
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
                                                    </div>
                                                    <div role="tabpanel" class="tab-pane" id="approved">
                                                        <div class="check-in">
                                                            <div class="row">
                                                                <div class="col-md-12">

                                                                    <div class="table-scrollable table-scrollable-borderless table-striped">
                                                                        <table class="table table-hover table-light table-striped">
                                                                            <thead>
                                                                            <tr class="uppercase">
                                                                                <th>Usuário</th>
                                                                                <th>Pergunta</th>
                                                                                <th>Status</th>
                                                                                <th>Curtidas</th>
                                                                                <th>Opções</th>
                                                                                <th></th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody class="hide" id="tbody-search"></tbody>
                                                                            <tbody>
                                                                            @foreach($approved as $question)

                                                                                <tr>
                                                                                    <td>
                                                                                        <a href="javascript:">
                                                                                            <img src="/uploads/profile/noimage.png" alt=""
                                                                                                 style="width: 50px; height: 50px;">
                                                                                            <p>{{$question->person_name}}</p>
                                                                                        </a>
                                                                                    </td>
                                                                                    <td>{{ $question->content }}</td>


                                                                                    <td>
                                                                                        @if($question->status == 'approved')

                                                                                            <span class="label label-success">Aprovada</span>

                                                                                        @elseif($question->status == 'denied')

                                                                                            <span class="label label-danger">Não Aprovada</span>

                                                                                        @else
                                                                                            <span class="label label-warning">Pendente</span>
                                                                                        @endif
                                                                                    </td>

                                                                                    <td><span class="badge">{{$question->like_count}}</span></td>

                                                                                    <td>
                                                                                        <a href="{{ route('event.session.view_question', ['id' => $question->id]) }}"
                                                                                           class="btn btn-warning btn-sm btn-circle" title="Visualizar Pergunta"
                                                                                           data-toggle="modal" data-target="#modal-padrao" data-remote="false"
                                                                                           modal-remote="true">
                                                                                            <i class="fa fa-eye"></i>
                                                                                            Visualizar
                                                                                        </a>
                                                                                        @if($question->status == 'approved')
                                                                                            <button class="btn btn-danger btn-sm btn-circle btn-deny"
                                                                                                    id="btn-deny-{{ $question->id }}">
                                                                                                <i class="fa fa-ban"></i>
                                                                                            </button>
                                                                                        @endif

                                                                                        @if($question->status == 'pending')
                                                                                            <button class="btn btn-success btn-sm btn-circle btn-approve"
                                                                                                    id="btn-approve-{{ $question->id }}">
                                                                                                <i class="fa fa-thumbs-up"></i>
                                                                                            </button>

                                                                                            <button class="btn btn-danger btn-sm btn-circle btn-deny"
                                                                                                    id="btn-deny-{{ $question->id }}">
                                                                                                <i class="fa fa-ban"></i>
                                                                                            </button>
                                                                                        @endif

                                                                                        @if($question->status == 'denied')
                                                                                            <button class="btn btn-success btn-sm btn-circle btn-approve"
                                                                                                    id="btn-approve-{{ $question->id }}">
                                                                                                <i class="fa fa-thumbs-up"></i>
                                                                                            </button>
                                                                                        @endif
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
                                                    </div>
                                                    <div role="tabpanel" class="tab-pane" id="denied">
                                                        <div class="check-in">
                                                            <div class="row">
                                                                <div class="col-md-12">

                                                                    <div class="table-scrollable table-scrollable-borderless table-striped">
                                                                        <table class="table table-hover table-light table-striped">
                                                                            <thead>
                                                                            <tr class="uppercase">
                                                                                <th>Usuário</th>
                                                                                <th>Pergunta</th>
                                                                                <th>Status</th>
                                                                                <th>Curtidas</th>
                                                                                <th>Opções</th>
                                                                                <th></th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody class="hide" id="tbody-search"></tbody>
                                                                            <tbody>

                                                                            @foreach($denied as $question)


                                                                                <tr>
                                                                                    <td>
                                                                                        <a href="javascript:">
                                                                                            <img src="/uploads/profile/noimage.png" alt=""
                                                                                                 style="width: 50px; height: 50px;">
                                                                                            <p>{{$question->person_name}}</p>
                                                                                        </a>
                                                                                    </td>
                                                                                    <td>{{ $question->content }}</td>


                                                                                    <td>
                                                                                        @if($question->status == 'approved')

                                                                                            <span class="label label-success">Aprovada</span>

                                                                                        @elseif($question->status == 'denied')

                                                                                            <span class="label label-danger">Não Aprovada</span>

                                                                                        @else
                                                                                            <span class="label label-warning">Pendente</span>
                                                                                        @endif
                                                                                    </td>

                                                                                    <td><span class="badge">{{$question->like_count}}</span></td>

                                                                                    <td>
                                                                                        <a href="{{ route('event.session.view_question', ['id' => $question->id]) }}"
                                                                                           class="btn btn-warning btn-sm btn-circle" title="Visualizar Pergunta"
                                                                                           data-toggle="modal" data-target="#modal-padrao" data-remote="false"
                                                                                           modal-remote="true">
                                                                                            <i class="fa fa-eye"></i>
                                                                                            Visualizar
                                                                                        </a>
                                                                                        @if($question->status == 'approved')
                                                                                            <button class="btn btn-danger btn-sm btn-circle btn-deny"
                                                                                                    id="btn-deny-{{ $question->id }}">
                                                                                                <i class="fa fa-ban"></i>
                                                                                            </button>
                                                                                        @endif

                                                                                        @if($question->status == 'pending')
                                                                                            <button class="btn btn-success btn-sm btn-circle btn-approve"
                                                                                                    id="btn-approve-{{ $question->id }}">
                                                                                                <i class="fa fa-thumbs-up"></i>
                                                                                            </button>

                                                                                            <button class="btn btn-danger btn-sm btn-circle btn-deny"
                                                                                                    id="btn-deny-{{ $question->id }}">
                                                                                                <i class="fa fa-ban"></i>
                                                                                            </button>
                                                                                        @endif

                                                                                        @if($question->status == 'denied')
                                                                                            <button class="btn btn-success btn-sm btn-circle btn-approve"
                                                                                                    id="btn-approve-{{ $question->id }}">
                                                                                                <i class="fa fa-thumbs-up"></i>
                                                                                            </button>
                                                                                        @endif
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
<script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
        type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>
