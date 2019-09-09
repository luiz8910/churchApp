@include('includes.header-site')
<div class="container-fluid xs-remove-fixed fixed-top pt-3" id="navbar">
    <nav class="navbar container navbar-toggleable-md navbar-light bg-transparent flex-row flex-sm-block justify-content-center align-items-center">
        <a class="navbar-brand d-none d-sm-inline" href="#"><img src="/store/images/logo-branco.png"
                                                                 srcset="/store/images/logo-branco@2x.png 2x, /store/images/logo-branco@3x.png 3x"
                                                                 class="logo"></a>
        <a class="navbar-brand d-inline d-sm-none" href="#"><img src="/store/images/logo.png"
                                                                 srcset="/store/images/logo@2x.png 2x, /store/images/logo@3x.png 3x"
                                                                 class="logo"></a>

        <div class="navbar-content d-flex w-100 justify-content-end align-items-sm-center">
            <form class="form-inline my-2 my-lg-0">
                <a class="btn btn-primary my-2 my-sm-0" href="{{ route('site.home') }}">Voltar</a>
            </form>
        </div>
    </nav>
</div>

<div class="container-fluid h-100-vh">
    <div class="row h-100">
        <div class="d-none d-sm-flex col-sm-5 pt-15 bg-internal">
            <div class="row w-100">
                <div class="col-auto ml-auto">
                    <h6 class="color-white pb-3"></h6>
                    <div class="card-price text-xs-center h-normal mx-auto">
                        <div class="card-block">

                            <h4 class="card-title">{{ $url->name }}</h4>

                            <p class="card-subtitle">{{ $church->name }}</p>
                        </div>
                        <div class="col-12 px-0">
                            <hr/>
                        </div>
                        <div class="card-block">
                            <ul class="list-group">

                            </ul>
                        </div>
                        <div class="card-header">
                            <h3 class="display-2"><span class="currency">R$</span>{{ number_format($url->value, 2, ',', '') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-7 pt-15 h-100-vh">
            <div class="row">
                <div class="col-sm-7 mr-sm-auto ml-sm-5">
                    <h6 class="color-grape">CONFIRME SUA INSCRIÇÃO</h6>
                    @include('includes.messages')
                    <p class="inner-text" style="font-size: 15px !important;">
                        <strong>
                            @if($url->pay_method === 1)
                                Pagamento: Boleto ou Cartão de Crédito
                            @elseif($url->pay_method == 2)
                                Pagamento: Apenas com Cartão de Crédito
                            @endif
                        </strong>
                    </p>

                    <div class="row hidden-sm-up mb-3">
                        <div class="col">
                            <div class="card-price card-mini text-xs-center h-normal">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card-block">

                                            <h4 class="card-title">{{ $url->name }}</h4>


                                            <p class="card-subtitle">{{ $church->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-auto ml-auto">
                                        <div class="card-header">
                                            <h3 class="display-2"><span class="currency">R$</span>{{ number_format($url->value, 2, ',', '') }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($url->pay_method === 2)

                        @include('payments.form-credit_card')

                    @else



                    @endif
                </div>
            </div>
        </div>

        <div class="hidden-sm-up col-12 transparent-grape pb-5">
            <div class="row text-center">
                <div class="col">
                    <h6 class="color-white mt-5 pb-3 text-center">JÁ TEM UMA CONTA?</h6>
                    <a href="{{ url('/login') }}" class="btn btn-primary">FAZER LOGIN</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.core-scripts')
<script src="../js/site.js"></script>
<script src="../js/errors.js"></script>
@include('includes.footer-site')
<script>

    //Verifica se o navegador é internet explorer
    isIE();

</script>
