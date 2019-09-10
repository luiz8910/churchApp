<!DOCTYPE html>

<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        body, html {
            margin: 0;
            padding: 0;
        }

        .certificate-container {
            background-image: url("/images/certificate_bg.jpg");
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            padding: 4% 5% 0 5%;

            /*margin: auto;*/
            /*width: 1400.8px;*/
            /*height: 988.8px;*/
        }

        .certificate-title {

            max-width: 80%;
            max-height: 80%;
        }

        .certificate-head {
            height: 20%;
            text-align: center;
        }

        .certificate-body {
            height: 45%;
        }

        .certificate-footer {
            position: absolute;
            bottom: 0;
            height: 30%;
            /*display: flex;*/
            /*justify-content: center;*/
            /*align-items: center;*/
            /*border: 1px solid black;*/
        }

        .certificate-footer p {
            /*margin: 0;*/
        }

        @font-face {
            font-family: 'OldLondon';
        url('/fonts/OldLondon.ttf')  format('truetype')
        }

        h1 {
            font-family: 'OldLondon';
            font-size: 70px;
            font-weight: 600;
            color: black;
            margin: 0;
        }

        p {
            font-weight: 600;
            font-size: 24px;
            color: black;
        }

        .certificate-body p {
            line-height: 34px;
        }

        .no-margin {
            margin: 0 !important;
        }

        .certificate-footer img {
            display: inline-block;
            width: auto;
            height: 80px;
            margin: 10px 10px 0 10px;
        }

        .text-center {
            text-align: center;
        }

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

        .row:before,
        .row:after {
            display: table;
            content: " ";
        }

        .row:after {
            clear: both;
        }

        .col-xs-6 {
            width: 50%;
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
            float: left;
        }

        .img-responsive,
        .thumbnail > img,
        .thumbnail a > img,
        .carousel-inner > .item > img,
        .carousel-inner > .item > a > img {
            display: block;
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<div class="certificate-container">
    <div class="certificate-head">
        <img src="./images/certificate_title.png" class="certificate-title" alt="Certificado de Participação"/>
    </div>
    <div class="certificate-body">
        <p class="text-center">A Prefeitura de Sorocaba por meio de seu Parque Tecnológico, certifica que: </p>
        <h1 class="text-center">{{$person->name}}</h1>
        <p>Participou do evento denominado <b>{{$event->name}}</b>, realizado em {{ $string_date }}
            às {{ $event->startTime  }}, no Auditório Central do Parque Tecnológico de
            Sorocaba,
            localizado na {{$event->street}}, {{$event->number}} – {{$event->neighborhood}}, Sorocaba/SP.
            <!--O evento contou com a participação do palestrante Marcelo Tas, que
            abordou o tema
            "Reinvenção da Carreira: Hackeando Marcelo Tas".--></p>
    </div>
    <div class="certificate-footer">
        <p class="text-center">Carga horária do evento: <b>{{ $event->certified_hours }} horas</b>.</p>
        <div class="row text-center">

            {{--@foreach($resp as $item)--}}

                {{--<div class="col-xs-{{ $col_size }}">--}}
                    {{--<p class="no-margin"><b>{{ $item->abbreviation }} {{ $item->name }}</b></p>--}}
                    {{--<p class="no-margin">{{ $item->special_role }}</p>--}}
                {{--</div>--}}

            {{--@endforeach--}}

                <div class="col-xs-12">
                    <p class="no-margin"><b> Me. Eng. Flávio Guerhardt</b></p>
                    <p class="no-margin">Diretor Executivo - PTS</p>
                </div>
        </div>

        <div class="text-center">
            <img src="./images/certificate_sponsor_1.png" alt="Sponsor" class="img-responsive"/>
            <img src="./images/certificate_sponsor_2.png" alt="Sponsor" class="img-responsive"/>
            <img src="./images/certificate_sponsor_3.png" alt="Sponsor" class="img-responsive"/>
        </div>
    </div>
</div>
</body>
</html>
