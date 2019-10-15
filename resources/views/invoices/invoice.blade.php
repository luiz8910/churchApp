<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.5.3
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    @include('includes.head')
    <link href="../assets/pages/css/invoice-2.min.css" rel="stylesheet" type="text/css" />
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-boxed">
<!-- BEGIN HEADER -->
@include('includes.header-admin')
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <div class="container">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">

                </div>
                <!-- END PAGE TITLE -->

            </div>
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE CONTENT BODY -->
        <div class="page-content">
            <div class="container">
                <!-- BEGIN PAGE BREADCRUMBS -->
                <ul class="page-breadcrumb breadcrumb">

                </ul>
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    <div class="invoice-content-2 ">
                        <div class="row invoice-head">
                            <div class="col-md-7 col-xs-6">
                                <div class="invoice-logo">
                                    <img src="../logo/Horizontal.png" class="img-responsive" alt="" style="width: 70%;"/>
                                    <h1 class="uppercase"></h1>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-6">
                                <div class="company-address">
                                    <span class="bold uppercase">Beconnect Eventos</span>
                                    <br/> R. Gravi, 211
                                    <br/> Saúde, São Paulo, SP
                                    <br/>
                                    <span class="bold"></span> (11) 99310-5830
                                    <br/>
                                    <span class="bold"></span> contato@beconnect.com.br
                                    <br/>
                                    <span class="bold"></span> beconnect.com.br
                                </div>
                            </div>
                        </div>
                        <div class="row invoice-cust-add">
                            <div class="col-xs-3">
                                <h2 class="invoice-title uppercase">Cliente</h2>
                                <p class="invoice-desc">{{ $org->name }}</p>
                            </div>
                            <div class="col-xs-3">
                                <h2 class="invoice-title uppercase">Data</h2>
                                <p class="invoice-desc">{{ $invoice->date }}</p>
                            </div>
                            <div class="col-xs-3">
                                <h2 class="invoice-title uppercase">Endereço</h2>
                                <p class="invoice-desc inv-address">{{ $org->street }}, {{ $org->number }} - {{ $org->city }}, {{ $org->state }}</p>
                            </div>
                            <div class="col-xs-3">
                                <h2 class="invoice-title uppercase">Contato</h2>
                                <?php $i = 0; ?>
                                @foreach($emails as $email)
                                    <p class="invoice-desc inv-address" @if($i > 0) style="margin-top: -15px;" @endif>{{ $email->email }}</p>
                                    <?php $i++; ?>
                                @endforeach
                            </div>
                        </div>
                        <div class="row invoice-body">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th class="invoice-title uppercase">Descrição</th>
                                        <th class="invoice-title uppercase text-center"></th>
                                        <th class="invoice-title uppercase text-center">Quantidade</th>
                                        <th class="invoice-title uppercase text-center">Custo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($itens as $item)
                                        <tr>
                                            <td>
                                                <h3>{{ $item->title }}</h3>
                                                @if(strpos($item->description, '/') == 0)
                                                    <p class="desc">{{ $item->description }}</p>
                                                @else
                                                    <?php echo $item->description; ?>
                                                @endif
                                            </td>
                                            <td class="text-center sbold"></td>
                                            <td class="text-center sbold">@if((int)$item->qtde == -1) {{ 'NA' }} @else {{ (int)$item->qtde }} @endif</td>
                                            <td class="text-center sbold">R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row invoice-subtotal">
                            <div class="col-xs-5">
                                <h2 class="invoice-title uppercase"></h2>
                                <p class="invoice-desc"></p>
                            </div>
                            <div class="col-xs-5">
                                <h2 class="invoice-title uppercase"></h2>
                                <p class="invoice-desc"></p>
                            </div>
                            <div class="col-xs-2">
                                <h2 class="invoice-title uppercase">Total</h2>
                                <p class="invoice-desc grand-total">R$ {{ number_format($total_price, 2, ',', '.') }}</p>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-xs-6"></div>
                            <div class="col-xs-6">
                                <a class="btn btn-lg green-haze hidden-print uppercase print-btn" onclick="javascript:window.print();">
                                    <i class="fa fa-print"></i>
                                    Imprimir
                                </a>


                                <a class="btn btn-lg blue hidden-print uppercase print-btn ">
                                    <i class="fa fa-envelope"></i>
                                    Enviar por email
                                </a>

                                <a href="{{ route('invoice.index') }}" class="btn btn-lg btn-primary hidden-print uppercase print-btn ">
                                    <i class="fa fa-arrow-left"></i>
                                    Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END PAGE CONTENT BODY -->
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->

</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<!-- BEGIN PRE-FOOTER -->
@include('includes.footer')
<!-- END INNER FOOTER -->
<!-- END FOOTER -->
@include('includes.core-scripts-edit')
<script src="../../js/invoice.js"></script>
<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>
