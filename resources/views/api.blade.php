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

                    <p class="text-center">Exemplo de Lista de Parâmetros (Se correto retorna true)</p>

                    <pre>
                        email = admin@admin.com
                        password = senha123
                        church = 1
                    </pre>
                    

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