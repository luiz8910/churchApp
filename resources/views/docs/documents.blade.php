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
            <p class="text-center">Documentos</p>

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
                            Lista de Documentos
                            <span class="span-btn-minimize" id="btn-minimize-doc">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="doc">

                        https://beconnect.com.br/api/doc
                        <span class="label label-primary">GET</span>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>


                        {"status":true, "count": 10, "documents": [lista de Documentos aqui]}
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
                            Lista de Documentos por evento
                            <span class="span-btn-minimize" id="btn-minimize-doc-event_id">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="doc-event_id">

                        https://beconnect.com.br/api/doc/{event_id}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        event_id = id do evento <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true, 'count': 5, 'documents': [lista de Documentos aqui]}

                        ou

                        {"status":false, "msg": "Não há arquivos deste evento"}

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
                            Upload de Documentos
                            <span class="span-btn-minimize" id="btn-minimize-doc-upload">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="doc-upload">

                        https://beconnect.com.br/api/doc-upload/
                        <span class="label label-success">POST</span>

                        <br>

                        <p class="text-center">Lista de Parâmetros</p>

                        <pre>
                            Obrigatório
                            <br><br>
                            file = Documento a ser armazenado <span class="label label-default" style="font-size: 12px;">Arquivo</span> <br><br>
                            created_by = id da pessoa logado que está fazendo o upload <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                            ------------------------------------ Opcionais ------------------------------------------------------------
                            <br>

                            event_id = id da evento que o documento pertence <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>
                        </pre>


                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true}

                        ou

                        {"status":false, 'msg': "Nenhum arquivo enviado"}

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
                            Exclusão de Documentos
                            <span class="span-btn-minimize" id="btn-minimize-doc-file_id-person_id">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="doc-file_id-person_id">

                        https://beconnect.com.br/api/doc/{file_id}/{person_id}
                        <span class="label label-danger">DELETE</span>

                        <br><br>
                        file_id = id do arquivo <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>
                        person_id = id do usuário <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>

                        <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>

                        {"status":true, 'msg': "Arquivo Excluido"}

                        ou

                        {"status":false, 'msg': "Arquivo não encontrado"}

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
                            Procurar arquivo pelo nome completo
                            <span class="span-btn-minimize" id="btn-minimize-doc-find">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="doc-find">

                        https://beconnect.com.br/api/doc-find/{name}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        name = nome do arquivo <span class="label label-success" style="font-size: 12px;">String</span> <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>


                        {"status":true, "count": 2, "doc": [lista de documentos aqui]}

                            ou

                        {"status":false, "count": 0}
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
                            Procurar arquivo pelo nome enquanto usuário digita
                            <span class="span-btn-minimize" id="btn-minimize-doc-search">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="doc-search">

                        https://beconnect.com.br/api/doc-search/{input}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        input = caracteres que estão no nome do arquivo <span class="label label-success" style="font-size: 12px;">String</span> <br><br>

                        <p class="text-center">Exemplo de Retorno</p>

                        <pre>


                        {"status":true, "count": 10, "doc": [lista de documentos aqui]}

                            ou

                        {"status":false, "count": 0}
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
