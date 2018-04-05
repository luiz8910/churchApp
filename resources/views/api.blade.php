<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Docs</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>



    <div class="jumbotron">
        <div class="container">
            <h1 class="text-center">Documentação (API)</h1>
            <p class="text-center">Lista de endpoints para o app</p>

        </div>
    </div>


<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Lista de Todas as Igrejas</h3>
                </div>
                <div class="panel-body">

                    https://beconnect.com.br/api/church-list
                    <span class="label label-primary">GET</span>

                    <br><br>

                    <p class="text-center">Exemplo de Retorno</p>

                    <pre>
                        [{"id":1,"name":"Imel Sorocaba"},{"id":7,"name":"Igreja X"}]
                    </pre>
                </div>
            </div>
        </div>
    </div>

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
                        church = 1 (Obrigatório)
                    </pre>

                    <p class="text-center">Exemplo de Retorno</p>

                    <pre>
                        Login Válido
                            {"status":true,"person_id":1}

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
                    <h3 class="panel-title">Lista dos Próximos 5 eventos</h3>
                </div>
                <div class="panel-body">

                    https://beconnect.com.br/api/next-events/{church}
                    <span class="label label-primary">GET</span>

                    <br><br>

                    <p class="text-center">Exemplo de Retorno</p>

                    <pre>
                        0 => {
                              +"name": "Evento da API"
                              +"id": 31
                              +"createdBy_id": 1
                              +"event_date": "2018-04-04 10:00:00"
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
                    <h3 class="panel-title">Lista de todos os Grupos da Igreja</h3>
                </div>
                <div class="panel-body">

                    https://beconnect.com.br/api/groups/{church}
                    <span class="label label-primary">GET</span>

                    <br><br>

                    <p class="text-center">Exemplo de Retorno</p>

                    <pre>
                        [{"id":2,"name":"Grupo de Jovens","sinceOf":"04\/12\/2017"},
                        {"id":3,"name":"Grupo de Estudo","sinceOf":"21\/12\/2017"},
                        {"id":4,"name":"Grupo Teste Exclus\u00e3o","sinceOf":"25\/01\/2018"}]
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

                </div>
            </div>
        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>