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
            <p class="text-center">Expositores</p>

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

                    <li class="">
                        <a href="{{ route('docs.check-in') }}">Check-in</a>
                    </li>

                    <li class="active">
                        <a href="{{ route('docs.exhibitors') }}">Expositores</a>
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
                        <h3 class="panel-title">Lista de Expositores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/exhibitors
                        <span class="label label-primary">GET</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>


                        {"status":true, "categories": [lista de categorias aqui]}
                    </pre>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Expositores por categoria</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/exhibitors/{category}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        category = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true, 'count': 5, 'categories': [lista de categorias aqui]}

                        ou

                        {"status":false}

                    </pre>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cadastro de Expositores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/exhibitors/
                        <span class="label label-primary">POST</span>

                        <br>

                        <p class="text-center">Lista de Parâmetros</p>

                        <pre>
                            Obrigatório
                        <br><br>
                        name = Nome do Expositor <span class="label label-success" style="font-size: 12px;">String</span> <br><br>
                        description = Descrição do Expositor <span class="label label-success" style="font-size: 12px;">String</span> <br><br>

                        ------------------------------------ Opcionais ------------------------------------------------------------
                        <br>
                        site = url do site do expositor <br>
                        tel = telefone do expositor<br>
                        email = email do expositor<br>
                        zipCode = CEP do expositor<br>
                        street = Logradouro (rua)<br>
                        number = Número do imóvel<br>
                        neighborhood = Bairro<br>
                        Cidade = Cidade<br>
                        Estado = UF<br>
                        category = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>
                        </pre>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true}

                        ou

                        {"status":false}

                    </pre>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Alteração de Expositores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/exhibitors/{id}
                        <span class="label label-warning">PUT</span>

                        <pre>
                            Obrigatório
                        <br><br>
                        name = Nome do Expositor <span class="label label-success" style="font-size: 12px;">String</span> <br><br>
                        description = Descrição do Expositor <span class="label label-success" style="font-size: 12px;">String</span> <br><br>

                        ------------------------------------ Opcionais ------------------------------------------------------------
                        <br>
                        site = url do site do expositor <br>
                        tel = telefone do expositor<br>
                        email = email do expositor<br>
                        zipCode = CEP do expositor<br>
                        street = Logradouro (rua)<br>
                        number = Número do imóvel<br>
                        neighborhood = Bairro<br>
                        Cidade = Cidade<br>
                        Estado = UF<br>
                        category = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>
                        </pre>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true}

                        ou

                        {"status":false}

                    </pre>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Exclusão de Expositores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/exhibitors/{category}
                        <span class="label label-danger">DELETE</span>

                        <br><br>
                        id = id do expositor <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true}

                        ou

                        {"status":false}

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