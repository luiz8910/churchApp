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
            <p class="text-center">Expositores</p>

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
                        <h3 class="panel-title">Lista de Expositores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/exhibitors
                        <span class="label label-primary">GET</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>


                        {"status":true, "count": 10, "exhibitors": [lista de expositores aqui]}
                    </pre>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Expositores por categoria</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/exhibitors-cat/{category}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        category = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true, 'count': 5, 'exhibitors': [lista de expositores aqui]}

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
                        <h3 class="panel-title">Cadastro de Expositores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/exhibitors/
                        <span class="label label-success">POST</span>

                        <br>

                        <p class="text-center">Lista de Parâmetros</p>

                        <pre>
                            Obrigatório
                            <br><br>
                            name = Nome do Expositor <span class="label label-success" style="font-size: 12px;">String</span> <br><br>
                            description = Descrição do Expositor <span class="label label-success" style="font-size: 12px;">String</span> <br><br>

                            ------------------------------------ Opcionais ------------------------------------------------------------
                            <br>
                            site = url do site do expositor <br>
                            tel = telefone do expositor<br>
                            email = email do expositor<br>
                            zipCode = CEP do expositor<br>
                            street = Logradouro (rua)<br>
                            number = Número do imóvel<br>
                            neighborhood = Bairro<br>
                            city = Cidade<br>
                            state = UF<br>
                            logo = logo<br>
                            category_id = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>
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
                        <h3 class="panel-title">Alteração de Expositores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/exhibitors/{id}
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        id = id do expositor <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <pre>
                            Obrigatório
                        <br><br>
                        name = Nome do Expositor <span class="label label-success" style="font-size: 12px;">String</span> <br><br>
                        description = Descrição do Expositor <span class="label label-success" style="font-size: 12px;">String</span> <br><br>

                        ------------------------------------ Opcionais ------------------------------------------------------------
                        <br>
                        site = url do site do expositor <br>
                        tel = telefone do expositor<br>
                        email = email do expositor<br>
                        zipCode = CEP do expositor<br>
                        street = Logradouro (rua)<br>
                        number = Número do imóvel<br>
                        neighborhood = Bairro<br>
                        city = Cidade<br>
                        state = UF<br>
                        category_id = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>
                        </pre>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true}

                        ou

                        {"status":false, "msg": "Este Expositor não existe"}

                    </pre>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Exclusão de Expositores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/exhibitors/{id}
                        <span class="label label-danger">DELETE</span>

                        <br><br>
                        id = id do expositor <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

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

                        https://beconnect.com.br/api/exhibitors-categories
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

                        https://beconnect.com.br/api/exhibitors-categories
                        <span class="label label-success">POST</span>

                        <br>

                        <p class="text-center">Lista de Parâmetros</p>

                        <pre>
                            Obrigatório
                        <br><br>
                            name = Nome do Expositor <span class="label label-success" style="font-size: 12px;">String</span> <br><br>

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

                        https://beconnect.com.br/api/exhibitors-categories/{category}
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        category = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <pre>
                            Obrigatório
                        <br><br>
                            name = Nome do Expositor <span class="label label-success" style="font-size: 12px;">String</span> <br><br>

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

                        https://beconnect.com.br/api/exhibitors-categories/{category}
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


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Feed de Expositores</h3>
                    </div>

                    <div class="panel-body">

                        https://beconnect.com.br/api/exhibitors-feed/
                        <span class="label label-success">POST</span>

                        <br>

                        <p class="text-center">Lista de Parâmetros</p>

                        <pre>
                            Obrigatório
                            <br><br>
                            text = Texto a ser descrito <span class="label label-success" style="font-size: 12px;">String</span> <br><br>
                            event = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

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




    </div>
</div>



@include('docs.scripts')

</body>
</html>
