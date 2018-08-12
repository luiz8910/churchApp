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
            <p class="text-center">Lista de Grupos</p>

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

                    <li class="active">
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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Informações de um grupo específico</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/getGroupInfo/{id}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        id = id da grupo <span class="label label-info" style="font-size: 12px;">Inteiro</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                        [
                            {
                                "id":2,
                                "name":"Grupo de Jovens",
                                "sinceOf":"04/12/2017",
                                "members":10,
                                "notes": "Notas do grupo",
                                "street":"Rua Luzerne Proença Arruda",
                                "neighborhood":"Vila Progresso",
                                "city":"Sorocaba",
                                "zipCode":"18075730",
                                "state":"SP"
                            }

                        ]
                    </pre>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de todos os Grupos da Igreja</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/groups/{church}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        church = id da igreja <span class="label label-info" style="font-size: 12px;">Inteiro</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                        [
                            {"id":2,"name":"Grupo de Jovens","sinceOf":"04\/12\/2017","members":10},
                            {"id":3,"name":"Grupo de Estudo","sinceOf":"21\/12\/2017","members":1},
                            {"id":4,"name":"Grupo Teste Exclus\u00e3o","sinceOf":"25\/01\/2018","members":1}
                        ]
                    </pre>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Grupos em que o usuário logado pertence</h3>
                    </div>

                    <div class="panel-body">
                        https://beconnect.com.br/api/my-groups/{person_id}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        person_id = id do membro logado <span class="label label-info" style="font-size: 12px;">Inteiro</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                        Caso o membro esteja inscrito em 1 ou mais grupos

                        {"status":true,

                        "groups":[
                            {"id":2,"name":"Grupo de Jovens","sinceOf":"2017-12-04","imgProfile":"uploads\/group\/2-Grupo de Jovens.jpeg",
                                "owner_id":1,"street":"Rua Luzerne Proen\u00e7a Arruda","neighborhood":"Vila Progresso","city":"Sorocaba",
                                "zipCode":"18075730","state":"SP","created_at":"2017-12-04 20:30:27","updated_at":"2017-12-04 20:30:27",
                                "deleted_at":null,"notes":null,"number":"137","church_id":1,"pivot":{"person_id":1,"group_id":2}},

                            {"id":3,"name":"Grupo de Estudo","sinceOf":"2017-12-21","imgProfile":"uploads\/group\/grupo.jpg","owner_id":1,
                                "street":"Rua Luzerne Proen\u00e7a Arruda","neighborhood":"Vila Progresso","city":"Sorocaba",
                                "zipCode":"18075730","state":"SP","created_at":"2017-12-21 12:29:55","updated_at":"2017-12-21 12:29:55",
                                "deleted_at":null,"notes":null,"number":"137","church_id":1}]}

                        Caso o membro não esteja inscrito em nenhum grupo

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
                        <h3 class="panel-title">Membros do grupo selecionado</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/group-people/{group_id}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        group_id = id do grupo escolhido <span class="label label-info" style="font-size: 12px;">Inteiro</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                        Se o grupo selecionado conter 1 ou mais participantes

                        {"status":true,

                        "people":[

                            {"id":1,"name":"Admin","lastName":"Admin","imgProfile":"uploads\/profile\/1-Admin.jpg"},
                            {"id":2,"name":"Bruce ","lastName":"Wayne","imgProfile":"uploads\/profile\/2-Bruce .jpg"},
                            {"id":3,"name":"Dollynho","lastName":"da Silva","imgProfile":"uploads\/profile\/3-Dollynho.jpg"}
                        ]}

                        Se o grupo não conter nenhum participante

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