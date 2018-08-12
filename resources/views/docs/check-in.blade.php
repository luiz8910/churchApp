<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Docs</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/docs.css">


</head>
<body>


    <div class="jumbotron">
        <div class="container">
            <h1 class="text-center">Documentação (API)</h1>
            <p class="text-center">Check-in</p>

        </div>
    </div>


    <nav class="navbar navbar-default navbar-fixed-top bg-color">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('docs') }}">
                    <img alt="Brand" class="logo-bc" src="https://beconnect.com.br/teste/logo-menor-header.png">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
                <ul class="nav navbar-nav">
                    <li><a href="javascript:;"></a></li>

                    <li class=""><a href="{{ route('docs.churchs') }}">Igrejas</a></li>

                    <li>
                        <a href="{{ route('docs.login') }}">Login </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.events') }}">Eventos</a>
                    </li>

                    <li>
                        <a href={{ route('docs.groups') }}>Grupos</a>
                    </li>

                    <li>
                        <a href="{{ route('docs.activity') }}">Atividades Recentes</a>
                    </li>

                    <li>
                        <a href="{{ route('docs.people') }}">Pessoas e Visitantes</a>
                    </li>

                    <li class="active">
                        <a href="{{ route('docs.check-in') }}">Check-in</a>
                    </li>


                </ul>

            </div><!-- /.navbar-collapse -->

        </div>
    </nav>

<div class="content">
    <div class="container ">

        <br><br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Eventos do dia atual (dos quais o usuário está inscrito)</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/today-events/{id}/{visitor?}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>
                        visitor = true se a pessoa for visitante <span class="label label-info" style="font-size: 12px;">Inteiro ou Boolean</span>
                        <span class="label label-warning" style="font-size: 12px;">Opcional</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        Se quantidade de eventos > 0

                        {"status":true,

                            {"status":true,

                                "coords":[
                                    {"lat":"-23.5201","lng":"-47.4870","event_id":37,"startTime":"15:00","endTime":""}

                                ]}
                        }

                        Se quantidade = 0

                        {"status":false}
                    </pre>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Check-in Manual</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/check-in/{id}/{person_id}/{visitor?}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        visitor = true se a pessoa for visitante <span class="label label-info" style="font-size: 12px;">Inteiro ou Boolean</span>

                        <span class="label label-warning" style="font-size: 12px;">Opcional</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        Se check-in realizado com sucesso

                        {"status":true, 'check-in': true}

                        Senão

                        {"status":false, 'check-in': false, 'msg': 'Data do evento é diferente da data atual'}

                    </pre>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Verificar Check-in</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/is-check/{id}/{person_id}/{visitor?}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        visitor = true se a pessoa for visitante <span class="label label-info" style="font-size: 12px;">Inteiro ou Boolean</span>

                        <span class="label label-warning" style="font-size: 12px;">Opcional</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        Se houver o evento na data atual e o usuário realizar check-in:

                        {"status":true, "check-in": true}


                        Se houver o evento na data atual e o usuário não tiver realizado o check-in:

                        {"status":true, "check-in": false}


                        Se não houver evento na data atual

                        {"status":false, 'msg': 'O Evento informado não tem uma data para hoje'}

                    </pre>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Check-in Massivo</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/checkin-all/{people}/{id}
                        <span class="label label-success">POST</span>

                        <br><br>
                        id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        people = array com os ids das pessoas, se people = 0 então todos os inscritos farão check-in
                        <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        Se people = 0

                        {"status":true, "qtde": 5} //qtde = Quantidade de pessoas que fizeram check-in


                        Se people for array de ids

                        {"status":true}


                        Se acontecer algum erro

                        {"status":false, "msg": 'Mensagem de erro aqui'}

                    </pre>

                    </div>
                </div>
            </div>
        </div>




    </div>
</div>



<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        // When the user scrolls the page, execute myFunction
        window.onscroll = function() {myFunction()};

        // Get the header
        var header = document.getElementById("myHeader");

        // Get the offset position of the navbar
        var sticky = header.offsetTop;

        // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
        function myFunction() {
            if (window.pageYOffset >= sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }
    </script>
</body>
</html>