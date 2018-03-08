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
                                    <small>Planos</small>
                                </h1>
                            </div>
                        </div> <!-- FIM DIV .container -->
                    </div> <!-- FIM DIV .page-head -->

                    @include('includes.plans-content')


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
@include('includes.core-scripts')

<script src="../js/site.js"></script>

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
