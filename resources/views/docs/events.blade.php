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
            <p class="text-center">Lista de Eventos</p>

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
                    <li class="active">
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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Informações de um evento específico</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/getEventInfo/{id}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {
                              +"name": "Evento da API"
                              +"id": 31
                              +"event_date": "2018-04-04 10:00:00"
                              +"group_id": "3"
                              +"description":"Descrição"
                              +"imgEvent":"uploads\/event\/33-Evento de Teste.jpg"
                              +"endTime": ""
                              +"street": "Rua Luzerne Proença Arruda"
                              +"number": "137"
                              +"city": "Sorocaba"
                              +"frequency": "Semanal"
                              +"deleted_at": null,
                              +"lat": "-23.479", <---- latitude
                              +"lng": "-47.455", <---- longitude
                            }


                    </pre>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Checkout</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/checkout/{id}/{person_id}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            Se estiver tudo ok

                                {"status":true}

                            Senão

                                {"status":false, "msg":"Mensagem de erro aqui"}


                        </pre>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Presença de um evento específico</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/getCheckinList/{id}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>


                            {"status":true,
                                "data":[
                                    {"id":1, "name:" Admin Admin},
                                    {"id":2, "name:" John Doe}
                                ]}

                            {"status":false,
                              "msg": "Aqui pode ser uma mensagem que não existem
                                    usuários cadastrados ou mensagem de erro do sistema"


                        </pre>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cadastro de Evento</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/store-event/{person_id}
                        <span class="label label-success">POST</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span> (Usado para ver quem criou o evento)

                        <br><br>

                        <p class="text-center">Nomes dos campos</p>

                        <pre>

                            'name', 'eventDate', 'group_id', 'description',
                            'endEventDate', 'startTime', 'endTime', 'frequency','day', 'church_id'
                            'allDay', 'day_2', 'street', 'neighborhood', 'city', 'zipCode', 'state', 'number'

                        </pre>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                            Se evento criado com sucesso

                            {
                                "status" true
                            }

                            Senão

                            {
                                "status":false,
                                "msg": 'Mensagem de erro aqui
                            }


                        </pre>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista dos Próximos X eventos</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/next-events/{qtde}/{church}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        qtde = Quantidade de Próximos eventos a serem exibidos <span class="label label-info" style="font-size: 12px;">Inteiro</span>
                        <br>
                        church = id da igreja <span class="label label-info" style="font-size: 12px;">Inteiro</span>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                        0 => {
                              +"name": "Evento da API"
                              +"id": 31
                              +"createdBy_id": 1
                              +"event_date": "2018-04-04 10:00:00"
                              +"group_id": "3"
                              +"description":"Descrição"
                              +"imgEvent":"uploads\/event\/33-Evento de Teste.jpg"
                              +"endTime": ""
                              +"street": "Rua Luzerne Proença Arruda"
                              +"number": "137"
                              +"city": "Sorocaba"
                              +"frequency": "Semanal"
                              +"deleted_at": null
                            }

                        1 => {
                              +"name": "Evento do Joãozinho"
                              +"id": 32
                              +"createdBy_id": 1
                              +"event_date": "2018-04-06 08:00:00"
                              +"group_id": ""
                              +"description":""
                              +"imgEvent":""
                              +"endTime": "18:00"
                              +"street": "Rua Luzerne Proença Arruda"
                              +"number": "137"
                              +"city": "Sorocaba"
                              +"frequency": "Semanal"
                              +"deleted_at": null
                            }
                    </pre>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Inscritos de um evento</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/event-list-sub/{id}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        Se quantidade de inscrito > 0

                        {"status":true,
                            "people":[
                                {"id":183,"event_id":40,"person_id":2, name: Dollynho da Silva, check:true},
                            ]

                        Se inscritos = 0

                        {"status":true, "people": 0}
                    </pre>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Remover inscrição de um evento</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/unsubscribe/{id}/{person_id}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        Se removido com sucesso

                        {"status":true}

                        Senão (caso o usuário não estivesse inscrito)

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
                        <h3 class="panel-title">Inscreve um usuário no evento</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/sub/{id}/{person_id}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        Se inscrito com sucesso

                        {"status":true}

                        Senão (caso o usuário já esteja inscrito)

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
                        <h3 class="panel-title">Lista de Eventos da Próxima Semana</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/events-next-week/{church}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        church = id da igreja <span class="label label-info" style="font-size: 12px;">Inteiro</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <br>

                        <span class="label label-info text-center" style="font-size: 12px;">Obs: atributo sub = quantidade de membros inscritos no evento</span>

                        <pre>

                        [
                            {"name":"Encontro das XYZ",
                                "id":35,"createdBy_id":"Luiz Admin","event_date":"2018-04-16 10:00:00","group_id":3,"description":"",
                                "imgEvent":null,"endTime":"","street":"Rua Pastor Maur\u00edcio Ara\u00fajo de Lima","number":"123",
                                "city":"Votorantim","frequency":"Di\u00e1rio","deleted_at":null,
                                "img_user":"https:\/\/graph.facebook.com\/v2.8\/1091593140969198\/picture?type=normal","eventDate":"16-04-2018","sub":2},

                            {"name":"Encontro das XYZ","id":35,"createdBy_id":"Luiz Admin","event_date":"2018-04-17 10:00:00","group_id":3,
                            "description":"","imgEvent":null,"endTime":"","street":"Rua Pastor Maur\u00edcio Ara\u00fajo de Lima","number":"123",
                            "city":"Votorantim","frequency":"Di\u00e1rio","deleted_at":null,
                            "img_user":"https:\/\/graph.facebook.com\/v2.8\/1091593140969198\/picture?type=normal",
                            "eventDate":"17-04-2018","sub":2},

                            {"name":"Encontro das XYZ","id":35,"createdBy_id":"Luiz Admin",
                            "event_date":"2018-04-18 10:00:00","group_id":3,"description":"","imgEvent":null,"endTime":"",
                            "street":"Rua Pastor Maur\u00edcio Ara\u00fajo de Lima","number":"123","city":"Votorantim",
                            "frequency":"Di\u00e1rio","deleted_at":null,"img_user":"https:\/\/graph.facebook.com\/v2.8\/1091593140969198\/picture?type=normal",
                            "eventDate":"18-04-2018","sub":2},

                            {"name":"Encontro das XYZ","id":35,"createdBy_id":"Luiz Admin",
                            "event_date":"2018-04-19 10:00:00","group_id":3,"description":"","imgEvent":null,"endTime":"",
                            "street":"Rua Pastor Maur\u00edcio Ara\u00fajo de Lima","number":"123","city":"Votorantim",
                            "frequency":"Di\u00e1rio","deleted_at":null,"img_user":"https:\/\/graph.facebook.com\/v2.8\/1091593140969198\/picture?type=normal",
                            "eventDate":"19-04-2018","sub":2},

                            {"name":"Encontro das XYZ","id":35,"createdBy_id":"Luiz Admin",
                            "event_date":"2018-04-20 10:00:00","group_id":3,"description":"","imgEvent":null,"endTime":"",
                            "street":"Rua Pastor Maur\u00edcio Ara\u00fajo de Lima","number":"123","city":"Votorantim",
                            "frequency":"Di\u00e1rio","deleted_at":null,"img_user":"https:\/\/graph.facebook.com\/v2.8\/1091593140969198\/picture?type=normal",
                            "eventDate":"20-04-2018","sub":2},

                            {"name":"Evento ABC","id":36,"createdBy_id":"Luiz Admin","event_date":"2018-04-18 10:00:00","group_id":null,
                            "description":"","imgEvent":null,"endTime":"","street":"Rua Augusto Antunes Vieira","number":"39",
                            "city":"Sorocaba","frequency":"Di\u00e1rio","deleted_at":null,
                            "img_user":"https:\/\/graph.facebook.com\/v2.8\/1091593140969198\/picture?type=normal",
                            "eventDate":"18-04-2018","sub":1},

                            {"name":"Evento ABC","id":36,"createdBy_id":"Luiz Admin","event_date":"2018-04-19 10:00:00","group_id":null,
                            "description":"","imgEvent":null,"endTime":"","street":"Rua Augusto Antunes Vieira","number":"39",
                            "city":"Sorocaba","frequency":"Di\u00e1rio","deleted_at":null,
                            "img_user":"https:\/\/graph.facebook.com\/v2.8\/1091593140969198\/picture?type=normal",
                            "eventDate":"19-04-2018","sub":1},

                            {"name":"Evento ABC","id":36,"createdBy_id":"Luiz Admin","event_date":"2018-04-20 10:00:00","group_id":null,
                            "description":"","imgEvent":null,"endTime":"","street":"Rua Augusto Antunes Vieira","number":"39","city":"Sorocaba",
                            "frequency":"Di\u00e1rio","deleted_at":null,
                            "img_user":"https:\/\/graph.facebook.com\/v2.8\/1091593140969198\/picture?type=normal","eventDate":"20-04-2018","sub":1},

                            {"name":"Evento ABC","id":36,"createdBy_id":"Luiz Admin","event_date":"2018-04-21 10:00:00","group_id":null,
                            "description":"","imgEvent":null,"endTime":"","street":"Rua Augusto Antunes Vieira","number":"39",
                            "city":"Sorocaba","frequency":"Di\u00e1rio","deleted_at":null,
                            "img_user":"https:\/\/graph.facebook.com\/v2.8\/1091593140969198\/picture?type=normal","eventDate":"21-04-2018","sub":1},

                            {"name":"Evento ABC","id":36,"createdBy_id":"Luiz Admin","event_date":"2018-04-22 10:00:00","group_id":null,
                            "description":"","imgEvent":null,"endTime":"","street":"Rua Augusto Antunes Vieira","number":"39",
                            "city":"Sorocaba","frequency":"Di\u00e1rio","deleted_at":null,
                            "img_user":"https:\/\/graph.facebook.com\/v2.8\/1091593140969198\/picture?type=normal","eventDate":"22-04-2018","sub":1}
                        ]
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