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
                            Notificação de Atividades de Eventos
                            <span class="span-btn-minimize" id="btn-minimize-notif-activity">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="notif-activity">

                        https://beconnect.com.br/api/notif-activity/{person_id)}/{event_id}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        event_id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {"status":true, value: 0}} //Valor de retorno 0 ou 1

                            se houver algum erro

                            {"status":false,"msg": mensagem aqui}
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
                            Notificação de Atualizações de Eventos
                            <span class="span-btn-minimize" id="btn-minimize-notif-updates">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="notif-updates">

                        https://beconnect.com.br/api/notif-updates/{person_id)}/{event_id}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        event_id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {"status":true, value: 0}} //Valor de retorno 0 ou 1

                            se houver algum erro

                            {"status":false,"msg": mensagem aqui}
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
                            Mudar Notificação de Atualizações de Eventos
                            <span class="span-btn-minimize" id="btn-minimize-change-notif-updates">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="change-notif-updates">

                        https://beconnect.com.br/api/change-notif-updates
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        event_id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        value = 1 ou 0 <span class="label label-info" style="font-size: 12px;">Inteiro</span>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {"status":true}}

                            se houver algum erro

                            {"status":false,"msg": mensagem aqui}
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
                            Mudar Notificação de Atividades de Eventos
                            <span class="span-btn-minimize" id="btn-minimize-change-notif-activity">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="change-notif-activity">

                        https://beconnect.com.br/api/change-notif-activity
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        event_id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        value = 1 ou 0 <span class="label label-info" style="font-size: 12px;">Inteiro</span>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {"status":true}}

                            se houver algum erro

                            {"status":false,"msg": mensagem aqui}
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
                            Recuperar Permissão do usuário
                            <span class="span-btn-minimize" id="btn-minimize-visibility-permissions">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="visibility-permissions">

                        https://beconnect.com.br/api/visibility-permissions/{person_id)}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {"status":true, value: 0}} //Valor de retorno 0 ou 1

                            se houver algum erro

                            {"status":false,"msg": mensagem aqui}
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
                            Mudar Permissões de Usuários
                            <span class="span-btn-minimize" id="btn-minimize-change-visibility-permissions">_</span>
                        </h3>

                    </div>
                    <div class="panel-body hide-panel" id="change-visibility-permissions">

                        https://beconnect.com.br/api/change-visibility-permissions/
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>
                        value = 1 ou 0 <span class="label label-info" style="font-size: 12px;">Inteiro</span>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {"status":true}}

                            se houver algum erro

                            {"status":false,"msg": mensagem aqui}
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
