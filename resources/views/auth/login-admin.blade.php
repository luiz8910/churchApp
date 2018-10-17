<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="/css/login-admin.css">

    <title>Login Admin</title>

</head>

<body class="back">

<div class="container">

    <div>

        <img src="logo\Simbolo2.png" alt="" class="img">

    </div>

    <form action="{{ route('login.admin.authenticate') }}" method="POST" role="form">

        <div class="row">

            <div class="col-md-12">

                <div class="square" id="square-login">

                    <div class="row">
                        <div class="col-md-9 text-center" style="margin-left: 50px; margin-top: 20px; margin-bottom: -10px;">

                            @include('includes.messages')

                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">

                            <div class="form-group">

                                <h2 class="label-class text-center">Login Admin</h2>

                                <input type="email" class="form-control input" placeholder="Email" id="email"
                                       name="email" required>

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">

                            <div class="form-group">

                                <input type="password" class="form-control input" placeholder="Senha" id="password"
                                       name="password" required>

                            </div>



                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-12">

                            <div class="btn-group checkbox-button" data-toggle="buttons">

                                <label class="btn btn-info active ">
                                    <input type="checkbox" autocomplete="off" name="remember-me" checked>
                                    <span class="glyphicon glyphicon-ok"></span>
                                </label>

                                <h4 class="label-check">Lembrar-me</h4>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">

                            <div class="form-group">

                                <button type="submit" class="btn btn-info btn-block btn-style">

                                    <i class="fa fa-sign-in"></i>

                                    Entrar

                                </button>


                            </div>
                        </div>
                    </div>


                </div>


                <div class="row">

                    <div class="col-md-12">

                        <div class="text-center forgot-pass">

                            <a href="javascript:;" id="btn-forgot-pass">Perdeu sua senha?</a>

                        </div>

                    </div>
                </div>


            </div>
        </div>
    </form>


    <div class="square" id="square-recover-pass" style="display: none;">

        <form action="{{ route('admin.recover-pass') }}" method="POST" role="form">

            <div class="row">

                <div class="col-md-12">

                    <div class="form-group" id="form-group-recover-pass">

                        <h2 class="label-class text-center">Recuperar Senha</h2>


                            <input type="email" class="form-control input" placeholder="Email" id="email-pass" name="email"
                                   required>

                            <span id="valid-email" style="display: none; margin-left: 30px; margin-top: 10px; color: red;">
                                    Digite um email válido
                            </span>

                            <span id="span-email-error" style="display: none; margin-left: 30px; margin-top: 10px; color: red;">
                                    Este email não existe na base de dados!
                            </span>

                    </div>

                </div>

            </div>


            <div class="row">

                <div class="col-md-12">

                    <div class="form-group text-center">

                        <button type="submit" id="btn-recover-pass" disabled class="btn btn-info btn-block btn-style">

                            <i class="fa fa-lock"></i>

                            Enviar Senha

                        </button>

                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="text-center forgot-pass">

                        <a href="javascript:;" id="btn-back" style="display: none;">Voltar</a>

                    </div>

                </div>
            </div>

        </form>


    </div>

</div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="/js/login-admin.js"></script>

    <script src="/js/ajax.js"></script>


</body>
</html>