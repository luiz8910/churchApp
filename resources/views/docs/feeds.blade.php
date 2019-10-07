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
        <p class="text-center">Lista de Feeds</p>

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
                            Lista de Feeds por Sessões
                            <span class="span-btn-minimize" id="btn-minimize-feeds-session">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="feeds-session">

                        https://beconnect.com.br/api/feeds-session/{session_id}/{person_id?}/{page?}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        session_id = id da sessão <span class="label label-info" style="font-size: 12px;">Inteiro</span><br><br>
                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span><br><br>
                        page = número da página (Opcional) <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>


                        <br><br>

                        <p><strong>Número da página se informado deve ser maior que 1</strong></p>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {"status":true,
                                "feeds":[
                                    {
                                        "id":1,
                                        "model": "session",
                                        "session_id":7,
                                        "text":"Texto do Feed",
                                        "like_count": 0,
                                        "created_at": "2019-08-08 16:00"
                                    }
                                ]
                            }

                            senão houver feeds

                            {"status":false,"msg": "Não há feeds"}
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
                            Lista de Feeds por Eventos
                            <span class="span-btn-minimize" id="btn-minimize-feeds-event">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="feeds-event">

                        https://beconnect.com.br/api/feeds-event/{event_id}/{person_id?}/{page?}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        event_id = id da sessão <span class="label label-info" style="font-size: 12px;">Inteiro</span><br><br>
                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span><br><br>
                        page = número da página (Opcional) <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>


                        <br><br>

                        <p><strong>Número da página se informado deve ser maior que 1</strong></p>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {"status":true,
                                "feeds":[
                                    {
                                        "id":1,
                                        "model": "event",
                                        "session_id":7,
                                        "text":"Texto do Feed",
                                        "like_count": 0,
                                        "created_at": "2019-08-08 16:00"
                                    }
                                ]
                            }

                            senão houver feeds

                            {"status":false,"msg": "Não há feeds"}
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
                            Adicionar Novo Feed de Sessão
                            <span class="span-btn-minimize" id="btn-minimize-feeds-session-post">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="feeds-session-post">

                        https://beconnect.com.br/api/feeds-session/
                        <span class="label label-success">POST</span>

                        <br><br>

                        <p class="text-center">Nomes dos campos</p>

                        <pre>
                            'session_id', 'title', 'text'
                        </pre>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {"status":true}

                            Se algum erro retornado

                            {"status":false,"msg": "Mensagem de erro aqui"}

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
                            Adicionar Novo Feed de Evento
                            <span class="span-btn-minimize" id="btn-minimize-feeds-event-post">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="feeds-event-post">

                        https://beconnect.com.br/api/feeds-event/
                        <span class="label label-success">POST</span>

                        <br><br>

                        <p class="text-center">Nomes dos campos</p>

                        <pre>
                            'event_id', 'title', 'text'
                        </pre>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {"status":true}

                            Se algum erro retornado

                            {"status":false,"msg": "Mensagem de erro aqui"}

                        </pre>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Adicionar Like
                            <span class="span-btn-minimize" id="btn-minimize-add-like-feed">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="add-like-feed">

                        https://beconnect.com.br/api/add-like-feed/{feed_id}/{person_id}
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        feed_id = id da questão <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        person_id = id da pessoa que está curtindo o feed<span class="label label-info" style="font-size: 12px;">Inteiro</span><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            Se encontrado
                            {
                                {"status":true}
                            }

                            Senão

                            {"status":false,"msg": "Este feed não existe"}
                        </pre>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Remover Like
                            <span class="span-btn-minimize" id="btn-minimize-remove-like-feed">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="remove-like-feed">

                        https://beconnect.com.br/api/remove-like-feed/{feed_id}/{person_id}
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        feed_id = id do feed <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        person_id = id da pessoa que está curtindo o feed<span class="label label-info" style="font-size: 12px;">Inteiro</span><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            Se encontrado
                            {
                                {"status":true}
                            }

                            Senão

                            {"status":false,"msg": "Este feed não existe"}
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
