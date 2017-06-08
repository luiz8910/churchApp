<html>
    <head>
        <style>
            .center {text-align: center; margin-left: auto; margin-right: auto; margin-bottom: auto; margin-top: auto;}
        </style>
        <meta charset="utf-8" />
        <title>Beconnect</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="theme-color" content="#4F0C53" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="http://beconnect.com.br/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="http://beconnect.com.br/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="http://beconnect.com.br/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="http://beconnect.com.br/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!--link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css"-->
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="http://beconnect.com.br/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="http://beconnect.com.br/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="http://beconnect.com.br/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="http://beconnect.com.br/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
        <link href="http://beconnect.com.br/assets/global/plugins/jquery-notific8/jquery.notific8.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="http://beconnect.com.br/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="http://beconnect.com.br/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="http://beconnect.com.br/assets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="http://beconnect.com.br/assets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="http://beconnect.com.br/assets/layouts/layout3/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="http://beconnect.com.br/logo/Simbolo2.png" />

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="http://beconnect.com.br/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- CSS Próprio -->
        <link href="http://beconnect.com.br/css/style.css" rel="stylesheet" type="text/css" />
        <link href="http://beconnect.com.br/css/search.css" rel="stylesheet" type="text/css" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
</html>

<body>
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="jumbotron center">
                    <div class="center hidden-xs hidden-sm">
                        <img src="http://beconnect.com.br/logo/Vertical.png" style="width: 150px;" alt="">
                    </div>

                    <div class="center hidden-md hidden-lg">
                        <img src="http://beconnect.com.br/logo/Vertical.png" style="width: 100px;" alt="">
                    </div>
                    <h1>Página não encontrada <small><font face="Tahoma" color="red">Erro 404</font></small></h1>
                    <br />
                    <p>O página que você está tentando exibir não foi encontrada.
                        Use o botão de <b>Voltar</b> para retorna a página anterior</p>

                    <p>Ou...</p>
                    <p><b>Clique no botão abaixo para voltar para a Home:</b></p>
                    <a href="{{ route('index') }}" class="btn btn-large purple"><i class="fa fa-home font-white"></i> Home</a>
                </div>
                <br />
            </div>
        </div>
    </div>
</body>

