<!DOCTYPE html>

<html lang="en">

<head>
    @include('includes.head-edit')

    <style>
        .certificate-container {
            background-image: url("/images/certificate_bg.jpg");
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            /*position: absolute;*/
            /*top: 0;*/
            /*bottom: 0;*/
            /*left: 0;*/
            /*right: 0;*/
            /*height: 100%;*/
            /*width: 100%;*/
            padding: 4% 5%;

            margin: auto;
            width: 1400.8px;
            height: 988.8px;
        }

        .certificate-title {
            max-width: 100%;
            max-height: 100%;
        }

        .certificate-head {
            height: 25%;
            text-align: center;
        }

        .certificate-body {
            height: 45%;
        }

        .certificate-footer {
            height: 30%;
            /*display: flex;*/
            /*justify-content: center;*/
            /*align-items: center;*/
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
            line-height: 45px;
        }

        .no-margin {
            margin: 0 !important;
        }

        .certificate-footer img {
            display: inline-block;
            width: auto;
            height: 100px;
            margin: 0 10px;
        }
    </style>
</head>
<body>
<div class="certificate-container">
    <div class="certificate-head">
        <img src="/images/certificate_title.png" class="certificate-title" alt="Certificado de Participação"/>
    </div>
    <div class="certificate-body">
        <p class="text-center">A Prefeitura de Sorocaba por meio de seu Parque Tecnológico, certifica que: </p>
        <h1 class="text-center">{{$person->name}}</h1>
        <p>Participou do evento denominado <b>{{$event->name}}</b>, realizado em {{ \Carbon\Carbon::parse($event->eventDate)->format('d \d\e F \d\e Y')}}
            às {{ $event->startTime  }}, no Auditório Central do Parque Tecnológico de
            Sorocaba,
            localizado na {{$event->street}}, {{$event->number}} – {{$event->neighborhood}}. O evento contou com a participação do palestrante Marcelo Tas, que
            abordou o tema
            "Reinvenção da Carreira: Hackeando Marcelo Tas".</p>
    </div>
    <div class="certificate-footer">
        <p class="text-center">Carga horária do evento: <b>2 horas</b>.</p>
        <div class="row text-center">
            <div class="col-xs-6">
                <p class="no-margin"><b>Dr. Roberto Freitas</b></p>
                <p class="no-margin">Presidente - PTS </p>
            </div>

            <div class="col-xs-6">
                <p class="no-margin"><b> Me. Eng. Flávio Guerhardt</b></p>
                <p class="no-margin">Diretor Executivo - PTS</p>
            </div>
        </div>
        <div class="text-center">
            <img src="/images/certificate_sponsor_1.png" alt="Sponsor" class="img-responsive"/>
            <img src="/images/certificate_sponsor_2.png" alt="Sponsor" class="img-responsive"/>
            <img src="/images/certificate_sponsor_3.png" alt="Sponsor" class="img-responsive"/>
        </div>
    </div>
</div>
</body>
</html>
