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
            <p class="text-center">Atividades Recentes</p>

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
                            Grupos Recentes
                            <span class="span-btn-minimize" id="btn-minimize-recent-groups">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="recent-groups">

                        https://beconnect.com.br/api/recent-groups/{church}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        church = id da igreja <span class="label label-info" style="font-size: 12px;">Inteiro</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        Se quantidade de grupos recentes > 0

                        {"status":true,

                            "groups":[
                                {"group_id":2,"name":"Grupo de Jovens","imgProfile":"uploads\/group\/2-Grupo de Jovens.jpeg"},
                                {"group_id":3,"name":"Grupo de Estudo","imgProfile":"uploads\/group\/grupo.jpg"},
                                {"group_id":4,"name":"Grupo Teste Exclus\u00e3o","imgProfile":"uploads\/group\/grupo.jpg"}
                            ]
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
                        <h3 class="panel-title">
                            Eventos Recentes
                            <span class="span-btn-minimize" id="btn-minimize-recent-events">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="recent-events">

                        https://beconnect.com.br/api/recent-events/{church}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        church = id da igreja <span class="label label-info" style="font-size: 12px;">Inteiro</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        Se quantidade de eventos recentes > 0

                        {"status":true,

                            "events":[
                                {"event_id":3,"name":"Encontro de Jovens","imgEvent":null},
                                {"event_id":4,"name":"Teste Evento P\u00fablico","imgEvent":null},
                                {"event_id":5,"name":"Evento Grupo de Estudo","imgEvent":null},
                                {"event_id":6,"name":"Evento de Estudo","imgEvent":null},
                                {"event_id":9,"name":"Check-in","imgEvent":null},
                                {"event_id":26,"name":"Teste check-in visitantes","imgEvent":null},
                                {"event_id":28,"name":"Evento de Teste Inscri\u00e7\u00e3o","imgEvent":null},
                                {"event_id":29,"name":"Visitantes","imgEvent":null},
                                {"event_id":30,"name":"Evento do Batman","imgEvent":null},
                                {"event_id":31,"name":"Evento do super man","imgEvent":null},
                                {"event_id":32,"name":"Evento do Deadpool","imgEvent":null},
                                {"event_id":33,"name":"Evento do X","imgEvent":"uploads\/event\/33-Evento X.jpg"},
                                {"event_id":34,"name":"Teste Inscri\u00e7\u00e3o Grupo de Jovens","imgEvent":null},
                                {"event_id":35,"name":"Encontro dos XYZ","imgEvent":null},
                                {"event_id":36,"name":"Evento BLA BLA","imgEvent":null}
                            ]
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
                        <h3 class="panel-title">
                            Membros Recentes
                            <span class="span-btn-minimize" id="btn-minimize-recent-people">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="recent-people">

                        https://beconnect.com.br/api/recent-people/{church}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        church = id da igreja <span class="label label-info" style="font-size: 12px;">Inteiro</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        Se quantidade de membros recentes > 0

                        {"status":true,

                            "people":[
                                {"person_id":3,"name":"Dollynho","imgProfile":"uploads\/profile\/3-Dollynho.jpg"},
                                {"person_id":5,"name":"Pedro Lucas ","imgProfile":"uploads\/profile\/5-Pedro Lucas .jpg"},
                                {"person_id":1718,"name":"Eduardo","imgProfile":"uploads\/profile\/1718-Eduardo.jpg"},
                                {"person_id":1719,"name":"Maria","imgProfile":"uploads\/profile\/1719-Maria.jpg"},
                                {"person_id":1900,"name":"Luiz","imgProfile":"https:\/\/graph.facebook.com\/v2.8\/1091593140969198\/picture?type=normal"}
                            ]
                        }

                        Se quantidade = 0

                        {"status":false}
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
