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

            @include('docs.topo')

        </div>
    </nav>

<div class="content">
    <div class="container ">

        @include('docs.label')


        <br><br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Eventos que o Usuário está inscrito
                            <span class="span-btn-minimize" id="btn-minimize-person-subs">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="person-subs">

                        https://beconnect.com.br/api/person-subs/{person_id)}/{church_id?}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        church_id = id da organização (Opcional) <span class="label label-info" style="font-size: 12px;">Inteiro</span>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {"status":true,"events":[{"id":1,"group_id":null,"name":"Encontro de Jovens","createdBy_id":1,"eventDate":"2019-02-17",
                            "endEventDate":"2019-02-20","startTime":"10:00","endTime":"12:00","frequency":"Di\u00e1rio","day":null,"allDay":0,
                            "description":"","street":"Avenida Londres","neighborhood":"Jardim Europa","city":"Sorocaba","zipCode":"18045330",
                            "state":"SP","deleted_at":null,"created_at":"2019-02-16 16:28:02","updated_at":"2019-02-16 16:28:03",
                            "church_id":1,"imgEvent":null,"day_2":null,"number":"375","check_auto":0},{"id":2,"group_id":null,
                            "name":"Evento Teste API","createdBy_id":1,"eventDate":"2019-02-20","endEventDate":"2019-03-27",
                            "startTime":"19:00","endTime":"20:00","frequency":"Semanal","day":"Quarta-Feira","allDay":0,
                            "description":"","street":"Avenida Londres","neighborhood":"Jardim Europa","city":"Sorocaba",
                            "zipCode":"18045330","state":"SP","deleted_at":null,"created_at":"2019-02-18 01:50:41",
                            "updated_at":"2019-02-18 01:50:41","church_id":1,"imgEvent":null,"day_2":null,"number":"375","check_auto":0}]}

                            senão houver eventos que o usuário participe

                            {"status":false,"events": 0}
                        </pre>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Eventos Antigos
                            <span class="span-btn-minimize" id="btn-minimize-old-events">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="old-events">

                        https://beconnect.com.br/api/old-events/{church_id?}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        church_id = id da Organização (Opcional) <span class="label label-info" style="font-size: 12px;">Inteiro</span>


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
                        <h3 class="panel-title">
                            Informações de um evento específico
                            <span class="span-btn-minimize" id="btn-minimize-info-event">_</span>
                        </h3>

                    </div>
                <div class="panel-body hide-panel" id="info-event">

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
                              +"imgEvent_bg": "uploads\/event\/33-Evento de Teste.jpg",
                              +"public_url": '[link aqui],
                              +'certified_hours': 2,
                              +'value_money': 100,
                              +'installments': 3,
                              +'primary_color': #428df5,
                              +'secondary_color': #63f542
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
                        <h3 class="panel-title">
                            Checkout
                            <span class="span-btn-minimize" id="btn-minimize-checkout">_</span>
                        </h3>
                    </div>
                    <div class="panel-body hide-panel" id="checkout">

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
                        <h3 class="panel-title">
                            Lista de Presença de um evento específico
                            <span class="span-btn-minimize" id="btn-minimize-check-in-list">_</span>
                        </h3>
                    </div>
                    <div class="panel-body hide-panel" id="check-in-list">

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
                        <h3 class="panel-title">
                            Cadastro de Evento
                            <span class="span-btn-minimize" id="btn-minimize-store-event">_</span>
                        </h3>
                    </div>
                    <div class="panel-body hide-panel" id="store-event">

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
                        <h3 class="panel-title">
                            Lista dos Próximos X eventos
                            <span class="span-btn-minimize" id="btn-minimize-next-events">_</span>
                        </h3>
                    </div>
                    <div class="panel-body hide-panel" id="next-events">

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
                        <h3 class="panel-title">
                            Lista de Inscritos de um evento
                            <span class="span-btn-minimize" id="btn-minimize-event-list-sub">_</span>
                        </h3>
                    </div>
                    <div class="panel-body hide-panel" id="event-list-sub">

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
                        <h3 class="panel-title">
                            Remover inscrição de um evento
                            <span class="span-btn-minimize" id="btn-minimize-unsubscribe">_</span>
                        </h3>
                    </div>
                    <div class="panel-body hide-panel" id="unsubscribe">

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
                        <h3 class="panel-title">
                            Inscreve um usuário no evento
                            <span class="span-btn-minimize" id="btn-minimize-sub">_</span>
                        </h3>
                    </div>
                    <div class="panel-body hide-panel" id="sub">

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
                        <h3 class="panel-title">
                            Lista de Eventos da Próxima Semana
                            <span class="span-btn-minimize" id="btn-minimize-events-next-week">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="events-next-week">

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

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Instant Search de Eventos
                            <span class="span-btn-minimize" id="btn-minimize-search-events">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="search-events">

                        https://beconnect.com.br/api/search-events/{input}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        input = texto digitado pelo usuário <span class="label label-success" style="font-size: 12px;">String</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <br>

                        <span class="label label-info text-center" style="font-size: 12px;">Exemplo de retorno se o usuário digitar a string "doc"</span>

                        <pre>

                        [
                            {"id":2,"group_id":null,"name":"Evento Doc","createdBy_id":2,"eventDate":"15\/01\/2019","endEventDate":"15\/01\/2019",
                            "startTime":"10:00","endTime":"15:00","frequency":"Quinzenal","day":"15","allDay":0,"description":"",
                            "street":"Rua Jo\u00e3o Yukio Sugui","neighborhood":"Jardim Santa Madre Paulina","city":"Sorocaba",
                            "zipCode":"18079-681","state":"SP","deleted_at":null,"created_at":"2018-12-17 10:05:16",
                            "updated_at":"2018-12-17 10:05:18","church_id":3,"imgEvent":null,"day_2":"30","number":"123","check_auto":0}
                        ]
                    </pre>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>



@include('docs.scripts')

</body>
</html>
