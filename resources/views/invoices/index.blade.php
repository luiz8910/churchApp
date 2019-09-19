<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    @include('includes.head')
    {{--<link rel="stylesheet" href="//frontend.reklamor.com/fancybox/jquery.fancybox.css" media="screen">
    <script src="//frontend.reklamor.com/fancybox/jquery.fancybox.js"></script>--}}
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
                                <h1>Admin
                                    <small>Invoices</small>
                                </h1>
                            </div>
                        </div> <!-- FIM DIV .container -->
                    </div> <!-- FIM DIV .page-head -->

                    <div class="container">
                        @include('includes.messages')
                        <div class="page-content-inner">
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light ">
                                        <div class="portlet-title">
                                            <div class="caption font-green-haze">
                                                <i class="icon-bar-chart font-green-haze"></i>
                                                <span class="caption-subject font-green-haze bold"> Invoices</span>
                                            </div> <!-- FIM DIV .caption.font-green-haze -->

                                            <div class="actions">
                                                <div class="btn-group btn-group-sm">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-circle dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Filtrar por Org <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu">

                                                            <li role="separator" class="divider"></li>
                                                            @if($org_id)
                                                                <li>
                                                                    <a href="{{ route('invoice.index') }}">Todos</a>
                                                                </li>
                                                            @endif
                                                            @foreach($orgs as $item)
                                                                <li>
                                                                    <a href="{{ route('invoice.index', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="btn-group-devided">
                                                            <a role="button" class="btn btn-info btn-circle btn-sm" id="" href="{{ route('invoice.create') }}" style="margin-top: 2px;">
                                                                <i class="fa fa-plus"></i>
                                                                <span class="hidden-xs hidden-sm">Novo Invoice</span>
                                                                <span class="hidden-md hidden-lg">Invoice</span>
                                                            </a>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
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
                                                                <th> Cliente </th>
                                                                <th> Valor </th>
                                                                <th> Referência </th>
                                                                <th> Data </th>
                                                                <th> Opções </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach($invoices as $invoice)
                                                                <tr id="tr_{{ $invoice->id }}">

                                                                    <td>{{ $invoice->org_name }}</td>

                                                                    <td>R${{ $invoice->total_price }}</td>

                                                                    <td>@if(isset($invoice->event_name)) {{ $invoice->event_name }} @else - @endif</td>

                                                                    <td>{{ $invoice->date }}</td>

                                                                    <td>
                                                                        <a href="{{ route('invoice.print', ['id' => $invoice->id]) }}" class="btn btn-success btn-sm btn-circle" title="Ver detalhes">
                                                                            <i class="fa fa-print"></i>
                                                                        </a>

                                                                        <a href="javascript:" class="btn btn-primary btn-sm btn-circle btn-resend-invoice" id="btn-resend-invoice-{{ $invoice->id }}"
                                                                           title="Reenviar por email">
                                                                            <i class="fa fa-paper-plane"></i>
                                                                        </a>

                                                                        <a href="javascript:" class="btn btn-danger btn-sm btn-circle btn-delete-invoice" id="btn-delete-invoice-{{ $invoice->id }}"
                                                                           title="Excluir Invoice" data-loading-text="Excluindo...">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <br>


                                                </div> <!-- FIM DIV .table-scrollable.table-scrollable-borderless.table-striped -->
                                            </div> <!-- FIM DIV .portlet-body-config -->

                                            <!-- <div class="form-actions ">
                                                <button type="button" class="btn blue">Enviar</button>
                                                <button type="button" class="btn default">Cancel</button>
                                            </div> -->
                                        </div> <!-- FIM DIV .portlet-body.form  -->
                                    </div> <!-- FIM DIV .portlet.light -->
                                </div> <!-- FIM DIV .col-md-12 -->
                            </div> <!-- FIM DIV .row -->
                        </div> <!-- FIM DIV .page-content-inner -->
                    </div>


                </div>
                <!-- END CONTENT -->
            </div>

        </div> <!-- FIM DIV .page-content-wrapper -->
    </div> <!-- FIM DIV .page-container -->
</div> <!-- FIM DIV .page-wrapper-middle -->

{{--<button type="button" data-toggle="modal" id="trigger-modal" data-target="#modal-icon" hidden>Launch modal</button>
<!-- Modal -->
<div class="modal fade" id="modal-icon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Escolha um ícone</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class='list-group gallery'>
                        @foreach($icons as $icon)
                            <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                <a class="fancybox " rel="ligthbox" href="javascript:;">
                                    <img class="icon-img" id="icon_id-{{ $icon->id }}"
                                         alt="" src="{{ $icon->path }}" style="height: 20px; width: 20px; margin-top: 10px;"/>
                                </a>
                            </div> <!-- col-6 / end -->
                        @endforeach
                    </div> <!-- list-group / end -->
                </div> <!-- row / end -->

            </div>

            <div class="modal-footer">
                <label>Sua Escolha foi: <span id="none-selected">Nenhum</span></label>

                <a class="fancybox" rel="ligthbox" href="javascript:;" id="img-selected-a" style="display: none;">
                    <img id="img-selected" src="" style="height: 30px; width: 30px; margin-right: 10px;"/>
                </a>

                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" id="btn-submit-icon" class="btn btn-success">
                    <i class="fa fa-check"></i>
                    Salvar
                </button>
            </div>

        </div>
    </div>
</div>--}}


<!-- END CONTAINER -->
@include('includes.footer')
@include('includes.core-scripts-edit')

<script src="../js/site.js"></script>
<script src="../js/invoice.js"></script>

{{--<script>
    $(document).ready(function(){
        //FANCYBOX
        //https://github.com/fancyapps/fancyBox
        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none",
            padding:0, margin:0,

            beforeShow: function () {
                $("body *:not(.fancybox-overlay, .fancybox-overlay *)").addClass("blur");
            },
            afterClose: function () {
                $("body *:not(.fancybox-overlay, .fancybox-overlay *)").removeClass("blur");
            }

        });
    });
</script>--}}

<!-- BEGIN PAGE LEVEL PLUGINS -->


</body>

</html>
