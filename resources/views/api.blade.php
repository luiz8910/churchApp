<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Docs</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        /* Style the header */
        .header {
            padding: 10px 16px;
            background: #555;
            color: #f1f1f1;
            z-index:1000 !important;
        }

        /* Page content */
        .content {
            padding: 16px;
        }

        /* The sticky class is added to the header with JS when it reaches its scroll position */
        .sticky {
            position: fixed;
            top: 0;
            width: 100%
        }

        /* Add some top padding to the page content to prevent sudden quick movement (as the header gets a new position at the top of the page (position:fixed and top:0) */
        .sticky + .content {
            padding-top: 102px;
        }
    </style>


</head>
<body>






    <div class="jumbotron">
        <div class="container">
            <h1 class="text-center">Documentação (API)</h1>
            <p class="text-center">Lista de endpoints para o app</p>

        </div>
    </div>

    {{--<div class="header" id="myHeader">
        <h2>My Header</h2>


    </div>--}}

<div class="content">
    <div class="container ">

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
                        church = 1 (Obrigatório) <span class="label label-info">Inteiro</span>
                    </pre>

                        <p class="text-center">Exemplo de Retorno</p>

                    <pre>
                        Login Válido
                            {"status":true,"person_id":1,"role_id":1,"role":"Lider"}

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
                <h3 class="text-center">Eventos</h3>
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

        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Grupos</h3>
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

        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Atividades Recentes</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Grupos Recentes</h3>
                    </div>

                    <div class="panel-body">

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
                        <h3 class="panel-title">Eventos Recentes</h3>
                    </div>

                    <div class="panel-body">

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
                        <h3 class="panel-title">Membros Recentes</h3>
                    </div>

                    <div class="panel-body">

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


        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Pessoas e Visitantes</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cadastro de Pessoas e Visitantes</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/store-person
                        <span class="label label-success">POST</span>

                        <br><br>

                        Caso seja cadastro de visitantes, apenas omita o parâmetro church_id

                        <br><br>

                        No final, informe o usuário que um email com instruções de acesso lhe foi enviado

                        <br><br>

                        <p class="text-center">Lista de Parâmetros</p>

                    <pre>

                        Lista de Parâmetros obrigatórios *

                            dateBirth = Data de Nascimento no formato dd/mm/AAAA (Verifica a idade e cria dados de login se idade = 18+) *

                            church_id = 1 (Obrigatório para cadastro de membros, opcional para visitantes) <span class="label label-info">Inteiro</span>

                            name = Nome do cadastrado *

                            cel = Celular do Cadastrado *

                            email = Usado para login *

                            role = Se role <> Lider e Administrador o membro será colocado na área de pré aprovação *

                        ------------------------------------ Opcionais --------------------------------------------------------------

                            lastName = Sobrenome do cadastrado

                            tel = telefone do cadastrado

                            gender = Sexo do cadastrado (M ou F)

                            cpf e rg

                            maritalStatus = estado civil

                            father_id = id do pai do cadastrado (uso permitido em qualquer caso, mas o padrão é só para menores de 18+)

                            mother_id = id da mãe (idem acima)

                            zipCode = CEP

                            street = Nome do Logradouro (rua)

                            number = número

                            neighborhood = Bairro

                            city = cidade

                            state = iniciais do Estado

                    </pre>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                    <pre>

                        Se cadastro com sucesso

                        {"status":true}

                        Senão

                        Exemplo de erro caso não passe o email

                        {"status":false,"msg":"Insira um email válido"}
                    </pre>

                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Check-in</h3>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Eventos do dia atual (dos quais o usuário está inscrito)</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/today-events/{id}/{visitor?}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>
                        visitor = true se a pessoa for visitante <span class="label label-info" style="font-size: 12px;">Inteiro ou Boolean</span>
                        <span class="label label-warning" style="font-size: 12px;">Opcional</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                    <pre>

                        Se quantidade de eventos > 0

                        {"status":true,

                            {"status":true,

                                "coords":[
                                    {"lat":"-23.5201","lng":"-47.4870","event_id":37,"startTime":"15:00","endTime":""}

                                ]}
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