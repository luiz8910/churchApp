<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.5.3
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
@include('includes.head')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="../assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL STYLES -->

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="javascript:;">
        <img src="../teste/Simbolo-branco.png" alt="logo" class="logo-default" style="width: 150px; margin-top: -20px;"> </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">

    <!-- BEGIN FORGOT PASSWORD FORM -->
    {!! Form::open(['route' => 'login.visitor', 'method' => 'POST', 'class' => 'forget-form', 'style' => "display: block !important;"]) !!}

        <h3 class="font-green">Acesso de Visitantes</h3>
        <p class="text-center"> Selecione a Organização para ter acesso </p>

        <div class="alert alert-warning alert-dismissible" role="alert" id="selectChurch" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Erro!</strong> Selecione uma Organização abaixo
        </div>

        <div class="form-group">
            <select name="church" id="church" class="form-control" required>
                <option value="">Selecione a Organização</option>
                @foreach($churches as $church)
                    <option value="{{ $church->id }}">{{ $church->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group has-error">
            <input class="form-control placeholder-no-fix" id="" type="text" autocomplete="off" placeholder="Email" name="email" required/>
        </div>

        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-default" onclick="back()">Voltar</button>
            <button type="submit" id="btnSend" class="btn btn-success uppercase pull-right">Enviar</button>
        </div>

        <div class="alert alert-danger alert-dismissible" role="alert" id="emailNotFound" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Erro!</strong> Este Email não existe na base de dados
        </div>

        <div class="alert alert-danger alert-dismissible" role="alert" id="emailNotSent" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Erro!</strong> Verifique sua conexão com a internet
        </div>



        <div class="login-options">
            <h4>Entre com</h4>
            <ul class="social-icons">
                <li>
                    <a class="social-icon-color facebook" data-original-title="facebook" href="{{ url('pre/auth/facebook') }}"></a>
                </li>
                <li>
                    <a class="social-icon-color googleplus" data-original-title="Google Plus" href="{{ url('pre/auth/google') }}"></a>
                </li>
            </ul>
        </div>

    {!! Form::close() !!}
    <!-- END FORGOT PASSWORD FORM -->
</div>
<div class="copyright"> 2017 © Beconnect.</div>
@include('includes.core-scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../assets/pages/scripts/login.min.js" type="text/javascript"></script>

<script src="../js/ajax.js"></script>
<script src="../js/login.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->

<script>
    function back() {
        window.location.href = "/login";
    }
</script>

</body>

</html>

