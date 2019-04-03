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
            <p class="text-center">Lista de Sessões de Eventos</p>

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
                            Lista de Sessões
                            <span class="span-btn-minimize" id="btn-minimize-sessions">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="sessions">

                        https://beconnect.com.br/api/sessions/{event_id}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        event_id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {"status":true,
                                "sessions":[
                                    {
                                        "id":1,
                                        "event_id":7,
                                        "name":"Café",
                                        "max_capacity":-1, (Se capacidade máxima = -1, então não há limitações)
                                        "location":"Refeitório",
                                        "start_time":"2019-04-06 08:00:00",
                                        "end_time":"2019-04-06 08:30:00",
                                        "description":"Eu preciso de Café",
                                        "tag":null,"created_at":"2019-04-03 14:07:59",
                                        "updated_at":"2019-04-03 14:07:59",
                                        "deleted_at":null
                                    }
                                ]
                            }

                            senão houver sessões

                            {"status":false,"msg": "Não há sessões para o evento selecionado"}
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
