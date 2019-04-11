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

            @include('docs.topo')

        </div>
    </nav>

<div class="content">
    <div class="container ">

        @include('docs.label')
        <br><br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Mudança de Senha
                            <span class="span-btn-minimize" id="btn-minimize-change-password">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="change-password">

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
                        <h3 class="panel-title">
                            Cadastro de Pessoas
                            <span class="span-btn-minimize" id="btn-minimize-store-person">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="store-person">

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

                            email = Usado para login *

                            role = Se role <> Lider e Administrador o membro será colocado na área de pré aprovação *

                        ------------------------------------ Opcionais --------------------------------------------------------------
                            cel = Celular do Cadastrado

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

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Alteração de Pessoas
                            <span class="span-btn-minimize" id="btn-minimize-update-person">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="update-person">

                        https://beconnect.com.br/api/update-person/{person_id}
                        <span class="label label-success">POST</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>

                        <p class="text-center">Lista de Parâmetros</p>

                        <pre>

                            name, email, imgProfile, tel, cel

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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Alteração de QrCode
                            <span class="span-btn-minimize" id="btn-minimize-qrcode">_</span>
                        </h3>
                    </div>

                    <div class="panel-body hide-panel" id="qrcode">

                        https://beconnect.com.br/api/qrcode/{person_id}
                        <span class="label label-primary">GET</span>

                        <br><br>

                        person_id = id da pessoa <span class="label label-info" style="font-size: 12px;">Inteiro</span><br>

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

    </div>
</div>



@include('docs.scripts')

</body>
</html>
