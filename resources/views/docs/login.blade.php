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
            <p class="text-center">Login</p>

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

        <br><br>

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
                            {
                                "status":true,
                                "person_id":1,
                                "role_id":1,
                                "role":"Lider",
                                "name": Admin admin,
                                "email": email@dominio.com,
                                "tel": 15988837883,
                                "cel": 15988837883,
                                "imgProfile": "uploads/profile/1-Admin.png
                        }

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
                        <h3 class="panel-title">Recuperação de Senha e envio de código</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/recover-password/{email}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        <p class="text-center">Exemplo de Lista de Parâmetros</p>

                        <pre>
                            email = admin@admin.com (Obrigatório) <span class="label label-info">Inteiro</span>
                        </pre>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                            Envia um email para o usuário com um código para digitar no app

                            <br>

                            {
                                "status":true,
                            }

                        Ou

                            {"status":false, msg: 'Usuário não encontrado'}
                    </pre>


                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Recuperação de código</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/get-code/{code}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        <p class="text-center">Exemplo de Lista de Parâmetros</p>

                        <pre>
                            code = 1095 (Obrigatório) <span class="label label-info">Inteiro</span>
                        </pre>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>
                            {
                                "status":true, "person_id": 1
                            }

                        Ou

                            {"status":false, msg: 'Código expirado ou inexistente'}
                    </pre>


                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Recuperar Token (Login Social)</h3>
                    </div>
                    <div class="panel-body">

                        https://beconnect.com.br/api/get-social-token/{token}
                        <span class="label label-primary">GET</span>

                        <br><br>


                        <pre>
                            Retorna {status: true} se existir


                            Senão



                            Retorna {status: false}

                        </pre>



                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login Social</h3>
                    </div>
                    <div class="panel-body">

                        <p class="text-center">Baixe o app de exemplo</p>

                        <pre>
                            https://github.com/luiz8910/live_ionic_login.git
                        </pre>

                        <p class="text-center">Lista de Comandos no Terminal</p>

                        <pre>
                            1 - npm install firebase
                            2 - ionic cordova plugin add cordova-plugin-buildinfo
                            3 - ionic cordova plugin add cordova-universal-links-plugin
                            4 - ionic cordova plugin add cordova-plugin-browsertab
                            5 - ionic cordova plugin add cordova-plugin-inappbrowser
                            6 - ionic cordova plugin add cordova-plugin-customerurlscheme --variable URL_SCHEME=com.firebase.cordova

                        </pre>

                        <p class="text-center">Alterações no config.xml</p>

                        <pre>
                            Adicione o código abaixo dentro de &lt;platform name="android"&gt;&lt;/platform&gt;

                            &lt;preference name="AndroidLaunchMode" value="singleTask" /&gt;
                        </pre>

                        <pre>

                            Adicione o código abaixo depois de &lt;platform&gt;&lt;/platform&gt;

                            &lt;universal-links&gt;
                                &lt;host name="DYNAMIC_LINK_DOMAIN" scheme="https" /&gt;
                                &lt;host name="AUTH_DOMAIN" scheme="https"&gt;
                                    &lt;path url="/__/auth/callback"/&gt;
                                &lt;/host&gt;
                            &lt;/universal-links&gt;

                            Onde:

                            "DYNAMIC_LINK_DOMAIN" = Consta no .pdf
                            "AUTH_DOMAIN" = Consta no .pdf



                        </pre>

                        <br>

                        <p style="margin-left: 100px;">Observações:</p>
                        <br>
                        <p>Conteúdo do arquivo firebase-config.ts consta no .pdf</p>
                        <p>No caso de dúvidas acesse : <a href="https://firebase.google.com/docs/auth/web/cordova?hl=pt-br" target="_blank">OAuth Sign-in para Cordova</a>  </p>

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