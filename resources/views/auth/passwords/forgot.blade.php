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
        <img src="../assets/pages/img/logo-big.png" alt="" /> </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">

    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form id="recoverPassword" class="forget-form" style="display: block !important;" method="POST">
        <input type="hidden" value="{{ csrf_token() }}" />

        <h3 class="font-green">Esqueceu sua senha ?</h3>
        <p> Entre com seu email para recuperar sua senha </p>
        <div class="form-group has-error">
            <input class="form-control placeholder-no-fix" id="recoverEmail" type="text" autocomplete="off" placeholder="Email" name="email" />
        </div>

        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-default" onclick="back()">Voltar</button>
            <button type="button" id="btnSend" class="btn btn-success uppercase pull-right btnSend" disabled>Enviar</button>
        </div>

        <div class="alert alert-danger alert-dismissible" role="alert" id="emailNotFound" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Erro!</strong> Este Email não existe na base de dados
        </div>

        <div class="alert alert-danger alert-dismissible" role="alert" id="emailNotSent" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Erro!</strong> Verifique sua conexão com a internet
        </div>

        <div class="alert alert-success alert-dismissible" role="alert" id="emailSent" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Sucesso!</strong> As informações da sua conta foram enviadas para o seu email
        </div>
    </form>
<!-- END FORGOT PASSWORD FORM -->
</div>
<div class="copyright"> 2014 © Metronic. Admin Dashboard Template. </div>
@include('includes.core-scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../assets/pages/scripts/login.min.js" type="text/javascript"></script>

<script src="../js/ajax.js"></script>
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

