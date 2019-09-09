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
            <p class="text-center">Palestrantes</p>

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
                            Lista de Palestrantes
                            <span class="span-btn-minimize" id="btn-minimize-speakers">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="speakers">

                        https://beconnect.com.br/api/speakers/{event_id?}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>


                        {"status":true, "count": 10, "speakers": [{"id":2,"name":"Teste","description":"Teste palestrante ",
                            "site":null,"tel":null,"email":null,"zipCode":null,"street":null,"number":null,
                            "neighborhood":null,"city":null,"state":null,"photo":"uploads\/speakers\/Teste.jpg",
                            "category_id":null,"event_id":101,"created_at":"2019-08-16 20:37:29",
                            "updated_at":"2019-08-16 20:37:29","deleted_at":null,"company":"Teste LTDA", country: Brasil},}

                            Opcionalmente é possível pegar a bandeira do país, localizada em /public/images/countries/[nome_do_pais].png
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
                            Lista de Palestrantes por categoria
                            <span class="span-btn-minimize" id="btn-minimize-speakers-by-cat">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="speakers-by-cat">

                        https://beconnect.com.br/api/speakers-by-cat/{category}
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
                        <h3 class="panel-title">
                            Cadastro de Palestrante
                            <span class="span-btn-minimize" id="btn-minimize-speakers-post">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="speakers-post">

                        https://beconnect.com.br/api/speakers/
                        <span class="label label-success">POST</span>

                        <br>

                        <p class="text-center">Lista de Parâmetros</p>

                        <pre>
                            Obrigatório
                            <br><br>
                            name = Nome do Palestrante <span class="label label-success" style="font-size: 12px;">String</span>
                            description = Descrição do Palestrante <span class="label label-success" style="font-size: 12px;">String</span> <br>
                            <br><br>

                            ------------------------------------ Opcionais ------------------------------------------------------------
                            <br>

                            site = url do site do Palestrante <br>
                            tel = telefone do Palestrante<br>
                            email = email do Palestrante<br>
                            zipCode = CEP do Palestrante<br>
                            street = Logradouro (rua)<br>
                            number = Número do imóvel<br>
                            neighborhood = Bairro<br>
                            city = Cidade<br>
                            state = UF<br>
                            photo = Foto da pessoa<br>
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
                        <h3 class="panel-title">
                            Alteração de Palestrante
                            <span class="span-btn-minimize" id="btn-minimize-speakers-put">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="speakers-put">

                        https://beconnect.com.br/api/speakers/{id}
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        id = id do Palestrante <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <pre>
                            Obrigatório
                        <br><br>
                        name = Nome do Palestrante <span class="label label-success" style="font-size: 12px;">String</span>
                        description = Descrição do Palestrante <span class="label label-success" style="font-size: 12px;">String</span> <br>
                        <br><br>


                        ------------------------------------ Opcionais ------------------------------------------------------------
                        <br>

                        site = url do site do Palestrante <br>
                        tel = telefone do Palestrante<br>
                        email = email do Palestrante<br>
                        zipCode = CEP do Palestrante<br>
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

                        {"status":false, "msg": "Este Palestrante não existe"}

                    </pre>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Exclusão de Palestrante
                            <span class="span-btn-minimize" id="btn-minimize-speakers-delete">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="speakers-delete">

                        https://beconnect.com.br/api/speakers/{id}
                        <span class="label label-danger">DELETE</span>

                        <br><br>
                        id = id do Palestrante <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

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
                        <h3 class="panel-title">
                            Lista de Categorias
                            <span class="span-btn-minimize" id="btn-minimize-speakers-categories">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="speakers-categories">

                        https://beconnect.com.br/api/speakers-categories/{event_id?}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        event_id = id do Evento(Opcional) <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

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
                        <h3 class="panel-title">
                            Cadastro de Categorias
                            <span class="span-btn-minimize" id="btn-minimize-speakers-categories-post">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="speakers-categories-post">

                        https://beconnect.com.br/api/speakers-categories/{event_id}
                        <span class="label label-success">POST</span>

                        <br><br>
                        event_id = id do Evento(Opcional) <span class="label label-info" style="font-size: 12px;">Inteiro</span>

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
                        <h3 class="panel-title">
                            Alteração de Categoria
                            <span class="span-btn-minimize" id="btn-minimize-speakers-categories-put">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="speakers-categories-put">

                        https://beconnect.com.br/api/speakers-categories/{category}
                        <span class="label label-warning">PUT</span>

                        <br><br>

                        category = id da categoria <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <pre>

                            name = Nome da Categoria <span class="label label-success" style="font-size: 12px;">String</span> <br><br>

                            Opcional
                            <br><br>

                            event_id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span>
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
                        <h3 class="panel-title">
                            Exclusão de Categorias
                            <span class="span-btn-minimize" id="btn-minimize-speakers-categories-delete">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="speakers-categories-delete">

                        https://beconnect.com.br/api/speakers-categories/{category}
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



@include('docs.scripts')

</body>
</html>
