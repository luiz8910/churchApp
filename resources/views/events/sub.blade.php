<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
@include('includes.head-auth')

<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL PLUGINS -->

<script type="text/javascript">
    function isMobile() {
        return (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4)));
    }

    // Smooth scroll
    $(function () {
        $('a[href*="#"]:not([href="#"])').click(function () {
            if ($(this).attr('smooth-scroll') == 'true' && location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 60
                    }, 1000);
                    return false;
                }
            }
        });
    });
</script>

<body>
<div class="container-fluid xs-remove-fixed fixed-top pt-3" id="navbar">
    <nav class="navbar container navbar-toggleable-md navbar-light bg-transparent flex-row flex-sm-block justify-content-center align-items-center">
        <a class="navbar-brand d-none d-sm-inline" href="{{ url('') }}"><img src="../images/logo-branco.png" srcset="../images/logo-branco@2x.png 2x, ../images/logo-branco@3x.png 3x" class="logo"></a>
        <a class="navbar-brand d-inline d-sm-none" href="{{ url('') }}"><img src="../images/logo.png" srcset="../images/logo@2x.png 2x, ../images/logo@3x.png 3x" class="logo"></a>

        <div class="navbar-content d-flex w-100 justify-content-end align-items-sm-center"></div>
    </nav>
</div>

<div class="container-fluid h-100-vh">
    <div class="row h-100">
        <div class="d-none d-sm-flex col-sm-5 pt-15 bg-internal">
            <div class="row w-100">
                <div class="col-6 ml-auto">

                </div>
            </div>
        </div>

        <div class="col-sm-7 pt-15 h-100-vh">
            <div class="row">
                <div class="col-sm-7 mr-sm-auto ml-sm-5">
                    <h6 class="color-grape">Cadastra-se no {{ $event->name }}</h6>
                    <p class="inner-text">Preencha os campos abaixo para se inscrever</p>

                    @include('includes.messages')

                    <form class="form-dark" role="form" method="POST" action="{{ route('event.url.sub') }}">
                        {{ csrf_field() }}

                        <div class="alert alert-warning alert-dismissible" role="alert" id="selectChurch" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                        </div>

                        <div class="form-group">
                            <input type="hidden" name="church_id" value="{{ $church->id }}">
                            <input class="form-control" type="text" value="{{ $church->name }}" readonly/>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <input class="form-control" type="text" value="{{ $event->name }}" readonly/>
                        </div>

                        <div class="form-group">
                            <input class="form-control" placeholder="Nome" type="text" name="name" value="{{ old('name') }}" required/>
                        </div>


                        @if(Session::has('email.error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button class="close" data-close="alert"></button>
                                <span> {{ Session::get('email.error') }} </span>
                            </div>
                        @endif

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="has-float-label" aria-label="E-mail">
                                <input class="form-control" type="email" placeholder="E-mail" name="email" value="{{ old('email') }}" />
                                <span>E-mail</span>

                                @if ($errors->has('email'))
                                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                @endif
                            </label>
                        </div>

                        <div class="form-group p-relative {{ $errors->has('cel') ? ' has-error' : '' }}">

                            <label class="has-float-label" aria-label="cel">
                                <input class="form-control tel" type="text" placeholder="Celular" name="cel" value="{{ old('cel') }}" required/>
                                <span>Celular</span>
                            </label>

                            @if ($errors->has('cel'))
                                <span class="help-block"><strong>{{ $errors->first('cel') }}</strong></span>
                            @endif
                        </div>

                        <div class="form-group pt-3 d-flex justify-content-between align-items-baseline">

                            <button type="submit" class="btn btn-secondary float-right">Inscrever</button>
                        </div>
                    </form>
                </div>
            </div>

            {{--<br><br>

            <div class="row">
                <div class="col-md-8 col-xs-12 text-center">
                    <a href="#">Cadastre-se</a>
                </div>
            </div>--}}
        </div>

        <div class="hidden-sm-up col-12 transparent-grape">
            <div class="row text-center">
                <div class="col">
                    <h6 class="color-white py-3 text-center">ACESSAR COM</h6>
                    <ul class="list-unstyled login-social-list d-flex">
                        <li>
                            <a href="{{ url('pre/auth/facebook') }}" class="facebook"><i class="fab fa-3x fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="{{ url('pre/auth/google') }}" class="googleplus"><i class="fab fa-3x fa-google-plus-square"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/select2/js/select2.full.js" type="text/javascript"></script>
<script src="../js/events.js" type="text/javascript"></script>
<script src="../js/script.js" type="text/javascript"></script>
<script src="../js/maskbrphone.js" type="text/javascript"></script>
<script type="text/javascript">
    $('.select2').select2();
</script>
</body>
</html>
