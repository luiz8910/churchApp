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
            <p class="text-center">Lista de endpoints para o app</p>

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

                    <li>
                        <a href="{{ route('docs.check-in') }}">Check-in</a>
                    </li>


                </ul>

            </div><!-- /.navbar-collapse -->

        </div>
    </nav>

<div class="content">
    <div class="container ">

        <div class="row">
            <div class="col-md-12">
                <div class="text-center"><h2>O que há de novo?</h2></div>

                <br>

                <ul class="list-group">
                    <li class="list-group-item text-center" style="background-color: #0a6aa1; color: white;">Recuperação de código (11/07/2018)</li>
                    <li class="list-group-item">"code": 4467,</li>
                    <li class="list-group-item">Retorna true ou mensagem de erro</li>
                </ul>

                <br>

                <ul class="list-group">
                    <li class="list-group-item text-center" style="background-color: #0a6aa1; color: white;">Recuperação de Senha e envio de código (11/07/2018)</li>
                    <li class="list-group-item">"person_id": 1,</li>
                    <li class="list-group-item">Envia um código para o email</li>
                </ul>

                <br>

                <ul class="list-group">
                    <li class="list-group-item text-center" style="background-color: lightskyblue; color: white;">
                        Mudança de Senha (06/07/2018)
                    </li>
                    <li class="list-group-item">Request POST </li>
                    <li class="list-group-item">person_id = 1</li>
                    <li class="list-group-item">password = "sua nova senha"</li>
                </ul>

                <br>

                <ul class="list-group">
                    <li class="list-group-item text-center" style="background-color: forestgreen; color: white;">
                        Check-in na lista de inscritos (05/07/2018) - event-list-sub
                    </li>
                    <li class="list-group-item">{"status":true, "people":[</li>
                    <li class="list-group-item">
                        {"id":6,"event_id":4,"person_id":1,"name":"Admin admin","check":true},
                    </li>
                    <li class="list-group-item">
                        {"id":7,"event_id":4,"person_id":4,"name":"Eloá Sandra Rita Alves","check":true},
                    </li>
                    <li class="list-group-item">
                        {"id":8,"event_id":4,"person_id":2,"name":"Juan Victor Caio Viana","check":false}]}
                    </li>
                </ul>


                <br><br><br>
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