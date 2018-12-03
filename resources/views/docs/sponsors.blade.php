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
            <p class="text-center">Patrocinadores</p>

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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Patrocinadores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/sponsors
                        <span class="label label-primary">GET</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>


                        {"status":true, "count": 10, "sponsors": [lista de Patrocinadores aqui]}
                    </pre>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Patrocinadores por categoria</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/sponsors-cat/{category}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        category = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true, 'count': 5, 'sponsors': [lista de patrocinadores aqui]}

                        ou

                        {"status":false, "msg": "Categoria não existe"}

                    </pre>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cadastro de Patrocinadores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/sponsors/
                        <span class="label label-success">POST</span>

                        <br>

                        <p class="text-center">Lista de Parâmetros</p>

                        <pre>
                            Obrigatório
                            <br><br>
                            name = Nome do Patrocinador <span class="label label-success" style="font-size: 12px;">String</span> <br><br>

                            ------------------------------------ Opcionais ------------------------------------------------------------
                            <br>
                            description = Descrição do Patrocinador <span class="label label-success" style="font-size: 12px;">String</span> <br>
                            site = url do site do Patrocinador <br>
                            tel = telefone do Patrocinador<br>
                            email = email do Patrocinador<br>
                            zipCode = CEP do Patrocinador<br>
                            street = Logradouro (rua)<br>
                            number = Número do imóvel<br>
                            neighborhood = Bairro<br>
                            city = Cidade<br>
                            state = UF<br>
                            logo = Logotipo<br>
                            category = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>
                        </pre>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true}

                        ou

                        {"status":false}

                    </pre>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Alteração de Patrocinadores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/sponsors/{id}
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        id = id do Patrocinador <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <pre>
                            Obrigatório
                        <br><br>
                        name = Nome do Patrocinador <span class="label label-success" style="font-size: 12px;">String</span> <br><br>


                        ------------------------------------ Opcionais ------------------------------------------------------------
                        <br>
                        description = Descrição do Patrocinador <span class="label label-success" style="font-size: 12px;">String</span> <br>
                        site = url do site do Patrocinador <br>
                        tel = telefone do Patrocinador<br>
                        email = email do Patrocinador<br>
                        zipCode = CEP do Patrocinador<br>
                        street = Logradouro (rua)<br>
                        number = Número do imóvel<br>
                        neighborhood = Bairro<br>
                        city = Cidade<br>
                        state = UF<br>
                        logo = Logotipo<br>
                        category = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>
                        </pre>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true}

                        ou

                        {"status":false, "msg": "Este Patrocinador não existe"}

                    </pre>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Exclusão de Patrocinadores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/sponsors/{category}
                        <span class="label label-danger">DELETE</span>

                        <br><br>
                        id = id do Patrocinador <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true}

                        ou

                        {"status":false}

                    </pre>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="text-center">
                <h3>Categorias</h3>
            </div>
        </div>

        <br><br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Categorias</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/sponsors-categories
                        <span class="label label-primary">GET</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>


                        {"status":true, "count": 10, "categories": [lista de categorias aqui]}
                    </pre>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cadastro de Categorias</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/sponsors-categories
                        <span class="label label-success">POST</span>

                        <br>

                        <p class="text-center">Lista de Parâmetros</p>

                        <pre>
                            Obrigatório
                        <br><br>
                            name = Nome da Categoria <span class="label label-success" style="font-size: 12px;">String</span> <br><br>

                        </pre>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true}

                        ou

                        {"status":false, "msg": "Insira o nome da Categoria"}

                    </pre>

                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Alteração de Categoria</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/sponsors-categories/{category}
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        category = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <pre>
                            Obrigatório
                        <br><br>
                            name = Nome da Categoria <span class="label label-success" style="font-size: 12px;">String</span> <br><br>

                        </pre>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true}

                        ou

                        {"status":false, "msg": "Esta Categoria não existe"}

                        {"status":false, "msg": "Insira o novo nome da Categoria"}

                    </pre>

                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Exclusão de Categorias</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/sponsors-categories/{category}
                        <span class="label label-danger">DELETE</span>

                        <br><br>
                        category = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true}

                        ou

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