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
                            <h4 class="card-title">{{ $event->name }}</h4>
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
                            <h3 class="display-2"><span class="currency">R$</span>{{ number_format($event->value_money, 2, ',', '') }}</h3>
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
                    <p class="inner-text">Escolha o método de pagamento</p>

                    <div class="row hidden-sm-up mb-3">
                        <div class="col">
                            <div class="card-price card-mini text-xs-center h-normal">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card-block">
                                            <h4 class="card-title">Teste</h4>
                                            <a href="#" class="btn btn-primary">ALTERAR PLANO</a>
                                        </div>
                                    </div>
                                    <div class="col-auto ml-auto">
                                        <div class="card-header">
                                            <h3 class="display-2"><span class="currency">R$</span>Teste
                                                <span class="period">Teste</span></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form class="form-dark" action="{{ route('event.payment', ['event_id' => $event->id]) }}" method="POST">

                        <div class="form-group d-flex justify-content-between align-items-center border-bottom">

                            <select class="form-control border-0" name="installments" required>
                                <option value="">Selecione um parcelamento</option>
                                <option value="1" selected>1x á vista</option>
                                @if($event->installments > 1)
                                    @for($i = 2; $i <= $event->installments; $i++)
                                        <option value="{{ $i }}" @if(old('installments') == $i) selected @endif >
                                            {{ $i }}x de R$ {{ number_format( $event->value_money / $i , 2, ',', ' ')}}
                                        </option>
                                    @endfor
                                @endif
                            </select>

                        </div>

                        <div class="form-group">
                            <label class="has-float-label" aria-label="Nome">
                                <input class="form-control" type="text" placeholder="Nome"
                                       name="name" value="Luiz Yahoo"{{--"{{ old('name') }}"--}}/>
                                <span>Nome</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="has-float-label" aria-label="Email">
                                <input class="form-control" type="email" placeholder="Email"
                                       name="email" value="luiz.sanches89@yahoo.com"{{--"{{ old('email') }}"--}} required/>
                                <span>Email</span>
                            </label>
                        </div>

                        <div class="form-group p-relative {{ $errors->has('cel') ? ' has-error' : '' }}">

                            <label class="has-float-label" aria-label="cel">
                                <input class="form-control tel" type="text" placeholder="Celular" name="cel"
                                       value="15997454531"{{--"{{ old('cel') }}"--}} required/>
                                <span>Celular</span>
                            </label>

                            @if ($errors->has('cel'))
                                <span class="help-block"><strong>{{ $errors->first('cel') }}</strong></span>
                            @endif
                        </div>

                        <div class="form-group p-relative {{ $errors->has('cpf') ? ' has-error' : '' }}">

                            <label class="has-float-label" aria-label="cpf">
                                <input class="form-control cpf" type="text" placeholder="CPF" name="cpf"
                                       value="38418189860"{{--"{{ old('cpf') }}"--}} required maxlength="11"/>
                                <span>CPF</span>
                            </label>

                            @if ($errors->has('cpf'))
                                <span class="help-block"><strong>{{ $errors->first('cpf') }}</strong></span>
                            @endif
                        </div>

                        <div class="form-group p-relative {{ $errors->has('dateBirth') ? ' has-error' : '' }}">

                            <label class="has-float-label" aria-label="dateBirth">
                                <input class="form-control dateBirth" type="date" placeholder="Data de Nascimento" name="dateBirth"
                                       value="15/09/1944"{{--"{{ old('dateBirth') }}"--}} required/>
                                <span>Data de Nascimento</span>
                            </label>

                            @if ($errors->has('dateBirth'))
                                <span class="help-block"><strong>{{ $errors->first('dateBirth') }}</strong></span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="has-float-label" aria-label="Nome no cartão">
                                <input class="form-control" type="text"
                                       placeholder="Nome no cartão" name="holder_name" value="Luiz F Sanches"{{--"{{ old('holder_name') }}"--}} required/>
                                <span>Nome no cartão</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="has-float-label" aria-label="Número do cartão de crédito">
                                <input class="form-control number" id="credit_card_number" type="text"
                                       placeholder="Número do cartão de crédito"
                                       name="credit_card_number" maxlength="16" value="5552116333491301"{{--"{{ old('credit_card_number') }}"--}} required/>
                                <span>Número do cartão de crédito</span>

                            </label>
                            <span style="color: red; display: none;" id="span-error-number"></span>
                            <input type="hidden" id="company" name="company">
                        </div>

                        <div class="row">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label class="has-float-label" aria-label="Data de expiração">
                                        <input class="form-control number" type="text" id="expire_date"
                                               placeholder="mm/AA" value="12/19"{{--"{{ old('expires_in') }}"--}}
                                               maxlength="5" name="expires_in" required />
                                        <span>Data de expiração (mm/AA) </span>
                                    </label>
                                    <span style="color: red; display: none;" id="span-error"></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="has-float-label" aria-label="CVC">
                                        <input class="form-control number" type="text"
                                               placeholder="CVC" name="cvc" value="123"{{--"{{ old('cvc') }}"--}} required/>
                                        <span>CVC</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex flex-column flex-sm-row justify-content-between align-items-sm-center border-bottom">
                            <span class="fs-22">Total sem juros</span>
                            <span class="font-weight-bold fs-22">R$ {{ number_format($event->value_money, 2, ',', ' ') }}</span>
                        </div>

                        <div class="form-group pt-3 d-flex justify-content-between align-items-baseline">
                            {{--<label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" required>
                                <span class="custom-control-indicator"><i class="fas fa-check"></i></span>
                                <span class="custom-control-description"><a
                                            href="#">Li e aceito os termos de uso</a></span>
                            </label>--}}

                            <button type="submit" class="btn btn-secondary float-right hidden-xs-down">
                                <i class="fa fa-lock"></i>
                                Enviar
                            </button>
                        </div>

                        <div class="form-group text-center hidden-sm-up">
                            <i class="fa fa-lock"></i>
                            <button type="submit" class="btn btn-secondary px-5">Enviar</button>
                        </div>
                    </form>
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
@include('includes.footer-site')