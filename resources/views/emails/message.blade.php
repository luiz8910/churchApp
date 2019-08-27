<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BeConnect</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <style>
        body {
            background: #2F3243;
            font-family: Arial;
        }

        .bg-gray {
            background: #EEEEEE
        }

        .bg-white {
            background: #ffffff;
        }

        .logo {
            max-width: 14vw;
            margin: 5rem auto;
        }

        h1 {
            color: #2f3243;
            font-size: 25px;
            text-transform: none;
            text-align: left;
            margin-bottom: 2rem;
        }

        p {
            font-size: 16px;
            margin-bottom: 2rem;
        }

        .btn-outline {
            border: 1px solid;
            font-weight: normal;
            margin-bottom: 3rem;
        }

        a:not(.btn) {
            color: #47bde6;
            margin: 3rem 0;
            display: block;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <a href="https://www.beconnect.com.br/">
                    <img src="http://beconnect.com.br/logo/Simbolo.png" alt="BeConnect" class="img-responsive logo"/>
                </a>
            </div>

            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <div class="row" style="margin-bottom: 2rem">
                    <div class="col-xs-12 bg-white" style="padding: 5rem 5rem 0 5rem">
                        <h1>Caro Inscrito,</h1>

                        <br>

                        <p>De forma constrangedora, informamos que devido a um imprevisto na agenda do Sr. Miguel Falabella,
                            o evento que ocorreria no dia 28/08/2019 (quarta-feira) foi postergado para:</p>

                        <p><strong>Dia: 03/09/2019</strong> (terça-feira);</p>
                        <p><strong>Horario:</strong> 19h30;</p>
                        <p><strong>Local:</strong> Parque Tecnológico de Sorocaba;</p>
                        <p><strong>Endereço:</strong> Av. Itavuvu, 11.777 - Jardim Santa Cecília / Sorocaba - SP</p>


                    </div>

                    <div class="col-xs-12 bg-gray" style="padding: 5rem 5rem 2rem 5rem">
                        <p>Este e-mail foi enviado a <b>{{ $person->email  }}</b>. Para garantir o correto recebimento de nossos e-mails, adicione-nos a
                            sua lista de e-mails seguros.</p>
                    </div>

                    <div class="col-xs-12 bg-white" style="padding: 3rem 5rem 3rem 5rem">
                        <div class="row" style="display: flex; align-items: center">
                            <div class="col-xs-4">
                                <a href="https://www.beconnect.com.br/">
                                    <img src="http://beconnect.com.br/logo/logo-menor-header.png" alt="BeConnect" class="img-responsive" style="width: 110px"/>
                                </a>
                            </div>
                            <div class="col-xs-8">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <h4><b>Baixe o App:</b></h4>
                                    </div>
                                    <div class="col-xs-6">
                                        <a href="{{ $android_url }}">
                                            <img src="https://beconnect.com.br/images/play_store_red.png" alt="Google Play" class="img-responsive">
                                        </a>
                                    </div>
                                    <div class="col-xs-6">
                                        <a href="{{ $apple_url }}">
                                            <img src="https://beconnect.com.br/images/Download_on_the_App_Store_Badge_PTBR_RGB_wht_100317.png" alt="App Store"
                                                 class="img-responsive">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

