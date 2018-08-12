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
            <p class="text-center">Login</p>

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

                    <li class="active">
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

        <br><br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/login
                        <span class="label label-success">POST</span>

                        <br><br>

                        <p class="text-center">Exemplo de Lista de Parâmetros</p>

                        <pre>
                        email = admin@admin.com (Obrigatório)
                        password = senha123 (Obrigatório)
                        church = 1 (Obrigatório) <span class="label label-info">Inteiro</span>
                    </pre>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                        Login Válido
                            {
                                "status":true,
                                "person_id":1,
                                "role_id":1,
                                "role":"Lider",
                                "name": Admin admin,
                                "email": email@dominio.com,
                                "tel": 15988837883,
                                "cel": 15988837883,
                                "imgProfile": "uploads/profile/1-Admin.png
                        }

                        Ou

                        Login Inválido
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
                        <h3 class="panel-title">Recuperação de Senha e envio de código</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/recover-password/{email}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        <p class="text-center">Exemplo de Lista de Parâmetros</p>

                        <pre>
                            email = admin@admin.com (Obrigatório) <span class="label label-info">Inteiro</span>
                        </pre>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                            Envia um email para o usuário com um código para digitar no app

                            <br>

                            {
                                "status":true,
                            }

                        Ou

                            {"status":false, msg: 'Usuário não encontrado'}
                    </pre>


                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Recuperação de código</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/get-code/{code}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        <p class="text-center">Exemplo de Lista de Parâmetros</p>

                        <pre>
                            code = 1095 (Obrigatório) <span class="label label-info">Inteiro</span>
                        </pre>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {
                                "status":true, "person_id": 1
                            }

                        Ou

                            {"status":false, msg: 'Código expirado ou inexistente'}
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