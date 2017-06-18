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
<link href="../assets/pages/css/login.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL STYLES -->

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="javascript:;">
        <img src="../teste/Simbolo-branco.png" alt="logo" class="logo-default" style="width: 150px; margin-top: -20px;">
        {{--<img src="../logo/Vertical.png" alt="logo" class="logo-default" style="width: 300px; margin-top: -20px;">--}}
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" role="form" method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }}
        <h3 class="form-title font-green">Entrar</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Digite seu email e senha </span>
        </div>

        @if(Session::has('email.error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button class="close" data-close="alert"></button>
                <span> {{ Session::get('email.error') }} </span>
            </div>
        @endif
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="email" placeholder="Email" name="email"
                   value="{{ old('email') }}" id="email" autofocus/>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9">Senha</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
                   placeholder="Senha" name="password" id="password"/>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

        </div>

        <!-- visivel em pc -->
        <div class="hidden-xs hidden-sm">

            <div class="form-actions-2">
                <button type="submit" class="btn btn-info btn-lg mt-ladda-btn ladda-button" data-style="zoom-in" data-size="l">
                    <span class="ladda-label">Login</span>
                    <span class="ladda-spinner"></span>
                </button>
                <!--<button type="submit" class="btn btn-lg green uppercase">Login</button>-->
                <label class="rememberme check mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" name="remember" value="1">Mantenha-me Conectado
                    <span></span>
                </label>

            </div>

            <div class="form-actions">
                <p class="text-right">
                    <a href="{{ route("forgot.password") }}" id="forget-password" class="forget-password">Esqueceu sua senha?</a>
                </p>

            </div>

        </div>

        <!-- visivel em celulares -->
        <div class="visible-xs">
            <div class="form-actions-xl-2">
                <label class="rememberme check mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" name="remember" value="1">Mantenha-me Conectado
                    <span></span>
                </label>
            </div>

            <div class="form-actions-xl-2">
                <button type="submit" class="btn btn-info btn-block mt-ladda-btn ladda-button" data-style="zoom-in" data-size="l">
                    <span class="ladda-label">Login</span>
                    <span class="ladda-spinner"></span>
                </button>
                <!--<button type="submit" class="btn btn-lg green uppercase">Login</button>-->
            </div>

            <div class="form-actions-xl">
                <p class="text-right">
                    <a href="http://192.168.0.10:8000/forgotPassword" id="forget-password" class="forget-password">Esqueceu sua senha?</a>
                </p>
            </div>
        </div>


        <div class="login-options">
            <h4>Entre com</h4>
            <ul class="social-icons">
                <li>
                    <a class="social-icon-color facebook" data-original-title="facebook" href="{{ url('auth/facebook') }}"></a>
                </li>
                <li>
                    <a class="social-icon-color googleplus" data-original-title="Google Plus" href="{{ url('auth/google') }}"></a>
                </li>
            </ul>
        </div>
        <div class="create-account">
            <p>
                <a href="javascript:;" class="uppercase" onclick="visitante()">Visitante? Clique aqui</a>
            </p>
        </div>
    </form>
    <!-- END LOGIN FORM -->

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

<script>
    function visitante() {
        window.location.href = 'login-visitante';
    }
</script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->

</body>

</html>

