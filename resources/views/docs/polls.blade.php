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
            <p class="text-center">Enquetes</p>

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
                            Responder Enquete
                            <span class="span-btn-minimize" id="btn-minimize-choose">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="choose">

                        https://beconnect.com.br/api/choose/{id}/{person_id}
                        <span class="label label-primary">GET</span>

                        <br><br>
                        id = id do item escolhido <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>
                        person_id = pessoa que respondeu a enquete <span class="label label-info" style="font-size: 12px;">Inteiro</span> <br><br>


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
