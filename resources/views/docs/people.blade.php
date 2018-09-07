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
            <p class="text-center">Lista de Pessoas e Visitantes</p>

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

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
                <ul class="nav navbar-nav">
                    <li><a href="javascript:;"></a></li>

                    <li class=""><a href="{{ route('docs.churchs') }}">Igrejas</a></li>

                    <li>
                        <a href="{{ route('docs.login') }}">Login </a>
                    </li>
                    <li>
                        <a href="{{ route('docs.events') }}">Eventos</a>
                    </li>

                    <li>
                        <a href={{ route('docs.groups') }}>Grupos</a>
                    </li>

                    <li>
                        <a href="{{ route('docs.activity') }}">Atividades Recentes</a>
                    </li>

                    <li class="active">
                        <a href="{{ route('docs.people') }}">Pessoas e Visitantes</a>
                    </li>

                    <li>
                        <a href="{{ route('docs.check-in') }}">Check-in</a>
                    </li>


                </ul>

            </div><!-- /.navbar-collapse -->

        </div>
    </nav>

<div class="content">
    <div class="container ">

        <br><br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Mudança de Senha</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/change-password
                        <span class="label label-success">POST</span>

                        <br><br>

                        <p class="text-center">Lista de Parâmetros</p>

                        <pre>

                        person_id = 1

                        password = 'nova senha aqui'

                    </pre>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        Se requisição realizada com sucesso

                        {"status":true}

                        Senão

                        Exemplo de erro

                        {"status":false,"msg":"Mensagem de erro"}
                    </pre>

                    </div>
                </div>
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

                            dateBirth = Data de Nascimento no formato dd/mm/AAAA (Verifica a idade e cria dados de login se idade >= 18) *

                            church_id = 1 (Obrigatório para cadastro de membros, opcional para visitantes) <span class="label label-info">Inteiro</span>

                            name = Nome do cadastrado *

                            cel = Celular do Cadastrado *

                            email = Usado para login *

                            role = Se role <> Lider e Administrador o membro será colocado na área de pré aprovação *

                        ------------------------------------ Opcionais --------------------------------------------------------------

                            social_token = (seu token aqui)

                            lastName = Sobrenome do cadastrado

                            tel = telefone do cadastrado

                            gender = Sexo do cadastrado (M ou F)

                            cpf e rg

                            maritalStatus = estado civil

                            father_id = id do pai do cadastrado (uso permitido em qualquer caso, mas o padrão é só para menores de 18)

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