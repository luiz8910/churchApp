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
                                        "deleted_at":null,
                                        "check_in": 25
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

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Verificar Código da Sessão
                            <span class="span-btn-minimize" id="btn-minimize-session-code">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="session-code">

                        https://beconnect.com.br/api/session-code/{code}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        code = código da sessão <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            Se encontrado
                            {
                                "status":true,
                                "session":{
                                    "id":3,"event_id":22,"name":"Apresentação","max_capacity":1000,"location":"",
                                    "start_time":"2019-02-08 11:00:00","end_time":"2019-02-08 13:00:00",
                                    "description":"Apresentação do Evento","tag":null,"created_at":"2019-08-01 19:11:50",
                                    "updated_at":"2019-08-01 22:31:22","deleted_at":null,
                                    "session_date":"2019-02-08 00:00:00","code":"7986543210"
                                }
                            }

                            Senão

                            {"status":false,"msg": "O código está incorreto ou não existe"}
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
                            Lista de Perguntas Aprovadas
                            <span class="span-btn-minimize" id="btn-minimize-list-questions">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="list-questions">

                        https://beconnect.com.br/api/list-questions/{session_id}/{person_id?}/{page?}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        session_id = código da sessão <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        person_id = id da pessoa que está consultando as perguntas (Opcional) <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        page = número da página (Opcional) <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>


                        <br><br>

                        <p>Se informado número da página deve ser maior que 1,</p>
                        <p>Se omitido então retornará todas as questões daquela sessão</p>

                        <p><strong>Se liked == 1 então a pessoa curtiu a pergunta</strong></p>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            Se encontrado e número de questões for maior que 0
                            {
                                {
                                    "status":true,
                                    "count":1,
                                    "questions":[{
                                        "id":1,"person_id":5,"session_id":3,"content":"Lorem Ipsum ?",
                                        "status":"approved","like_count":0,"created_at":"2019-08-05 19:10:03",
                                        "updated_at":"2019-08-06 02:30:21","deleted_at":null, liked: 1
                                    }]}
                            }

                            Senão

                            {"status":false,"msg": "Esta sessão não existe"}
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
                            Adicionar Nova Questão
                            <span class="span-btn-minimize" id="btn-minimize-store-question">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="store-question">

                        https://beconnect.com.br/api/store-question/
                        <span class="label panel-success">POST</span>

                        <br><br>

                        <p class="text-center">Nomes dos campos</p>

                        <pre>
                            'content', 'person_id', session_id
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
                            <span class="span-btn-minimize" id="btn-minimize-add-like">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="add-like">

                        https://beconnect.com.br/api/add-like/{question_id}/{person_id}
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        question_id = id da questão <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        person_id = id da pessoa que está curtindo a questão<span class="label label-info" style="font-size: 12px;">Inteiro</span><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            Se encontrado
                            {
                                {"status":true}
                            }

                            Senão

                            {"status":false,"msg": "Esta questão não existe"}
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
                            <span class="span-btn-minimize" id="btn-minimize-remove-like">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="remove-like">

                        https://beconnect.com.br/api/remove-like/{question_id}/{person_id}
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        question_id = id da questão <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        person_id = id da pessoa que está curtindo a questão<span class="label label-info" style="font-size: 12px;">Inteiro</span><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            Se encontrado
                            {
                                {"status":true}
                            }

                            Senão

                            {"status":false,"msg": "Esta questão não existe"}
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
                            Adicionar Feedback da sessão
                            <span class="span-btn-minimize" id="btn-minimize-store-fb-session">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="store-fb-session">

                        https://beconnect.com.br/api/store-fb-session/
                        <span class="label label-success">POST</span>

                        <br><br>

                        <p class="text-center">Nomes dos campos</p>

                        <pre>
                            'type_feedback', 'rating', 'comment', 'person_id', session_id
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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Lista de Tipos de Avaliação
                            <span class="span-btn-minimize" id="btn-minimize-types-fb-session">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="types-fb-session">

                        https://beconnect.com.br/api/types-fb-session/{session_id}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        session_id = id da sessão <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            Se encontrado
                            {
                                "status":true,
                                "count": 5
                                "types": [{
                                    id: 1, type: O que vc achou desta sessão?, session_id: 1
                            }

                            Se não houver tipos de avaliação para a sessão
                            {
                                "status": true,
                                "count": 0
                            }

                            Senão

                            {"status":false,"msg": "Mensagem de erro aqui"}
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
                            Verifica se a pessoa já avaliou a sessão
                            <span class="span-btn-minimize" id="btn-minimize-rating_person">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="rating_person">

                        https://beconnect.com.br/api/rating-person/{person_id}/{session_id}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        session_id = id da sessão <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            Se a pessoa já realizou
                            {
                                "status":true,
                                "rating": 1
                            }

                            Senão
                            {
                                "status": true,
                                "rating": 0
                            }

                            Erros

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
                            Responder Quiz
                            <span class="span-btn-minimize" id="btn-minimize-choose">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="choose">

                        https://beconnect.com.br/api/choose/{id}
                        <span class="label label-success">POST</span>

                        <br><br>
                        id = id do item escolhido <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>


                        <br><br>

                        <p class="text-center">Campos</p>

                        <pre>
                            'person_id'
                        </pre>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>


                        {"status":true}

                        ou

                        {"status":false, 'msg': Erro}
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
                            Lista de Itens
                            <span class="span-btn-minimize" id="btn-minimize-list-itens">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="list-itens">

                        https://beconnect.com.br/api/list-itens/{id}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        id = id do quiz <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>


                        <br><br>


                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>


                        {"status":true, itens: itens aqui}

                        ou

                        {"status":false, 'msg': Erro}
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
                            Lista de Quiz por sessão
                            <span class="span-btn-minimize" id="btn-minimize-quizz">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="quizz">

                        https://beconnect.com.br/api/quizz/{id}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        id = id da sessão <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>


                        <br><br>


                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>


                        {"status":true, quizz: quizz aqui}

                        ou

                        {"status":false, 'msg': Erro}
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
