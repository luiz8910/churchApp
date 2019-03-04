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
                            Informações de um grupo específico
                            <span class="span-btn-minimize" id="btn-minimize-getGroupInfo">_</span>
                        </h3>
                    </div>
                    <div class="panel-body hide-panel" id="getGroupInfo">

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
                        <h3 class="panel-title">
                            Lista de todos os Grupos da Igreja
                            <span class="span-btn-minimize" id="btn-minimize-groups">_</span>
                        </h3>
                    </div>
                    <div class="panel-body hide-panel" id="groups">

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
                        <h3 class="panel-title">
                            Grupos em que o usuário logado pertence
                            <span class="span-btn-minimize" id="btn-minimize-my-groups">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="my-groups">
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
                        <h3 class="panel-title">
                            Membros do grupo selecionado
                            <span class="span-btn-minimize" id="btn-minimize-group-people">_</span>
                        </h3>
                    </div>
                    <div class="panel-body hide-panel" id="group-people">

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



@include('docs.scripts')
</body>
</html>
