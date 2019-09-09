<form class="form-dark" action="{{ route('url.payment', ['event_id' => $url->id]) }}" method="POST" id="form-credit_card" style="display: none;">

    <div class="form-group d-flex justify-content-between align-items-center border-bottom">

        {{--<select class="form-control border-0" name="installments" required>
            <option value="">Selecione um parcelamento</option>
            <option value="1" selected>1x á vista</option>
            @if($event->installments > 1)
                @for($i = 2; $i <= $event->installments; $i++)
                    <option value="{{ $i }}" @if(old('installments') == $i) selected @endif >
                        {{ $i }}x de R$ {{ number_format( $event->value_money / $i , 2, ',', ' ')}}
                    </option>
                @endfor
            @endif
        </select>--}}

    </div>


    <div class="form-group">
        <label class="has-float-label" aria-label="Nome">
            <input class="form-control" type="text" placeholder="Nome"
                   name="name" value="{{ old('name') }}" required/>
            <span>Nome</span>
        </label>
    </div>

    <div class="form-group">
        <label class="has-float-label" aria-label="Email">
            <input class="form-control" type="email" placeholder="Email"
                   name="email" value="{{ old('email') }}" required/>
            <span>Email</span>
        </label>
        <p><strong>É permitida a compra de apenas um ingresso por email</strong></p>
    </div>

    <div class="form-group p-relative {{ $errors->has('cel') ? ' has-error' : '' }}">

        <label class="has-float-label" aria-label="cel">
            <input class="form-control tel" type="text" placeholder="Celular" name="cel"
                   value="{{ old('cel') }}" required/>
            <span>Celular</span>
        </label>

        @if ($errors->has('cel'))
            <span class="help-block"><strong>{{ $errors->first('cel') }}</strong></span>
        @endif
    </div>

    <div class="form-group p-relative {{ $errors->has('cpf') ? ' has-error' : '' }}">

        <label class="has-float-label" aria-label="cpf">
            <input class="form-control cpf" type="text" placeholder="CPF" name="cpf"
                   value="{{ old('cpf') }}" required maxlength="11" autocomplete="new-password"/>
            <span>CPF</span>
        </label>

        @if ($errors->has('cpf'))
            <span class="help-block"><strong>{{ $errors->first('cpf') }}</strong></span>
        @endif
    </div>

    <div class="form-group p-relative {{ $errors->has('dateBirth') ? ' has-error' : '' }}">

        <label class="has-float-label" aria-label="dateBirth">
            <input class="form-control dateBirth" type="date" placeholder="Data de Nascimento" name="dateBirth"
                   value="{{ old('dateBirth') }}" required/>
            <span>Data de Nascimento</span>
        </label>

        @if ($errors->has('dateBirth'))
            <span class="help-block"><strong>{{ $errors->first('dateBirth') }}</strong></span>
        @endif
    </div>

    <div class="form-group">
        <label class="has-float-label" aria-label="Nome no cartão">
            <input class="form-control" type="text"
                   placeholder="Nome no cartão" name="holder_name" value="{{ old('holder_name') }}" required/>
            <span>Nome no cartão</span>
        </label>
    </div>

    <div class="form-group">
        <label class="has-float-label" aria-label="Número do cartão de crédito">
            <input class="form-control number" id="credit_card_number" type="text"
                   placeholder="Número do cartão de crédito"
                   name="credit_card_number" maxlength="16" value="{{ old('credit_card_number') }}" required/>
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
                           placeholder="mm/AA" value="{{ old('expires_in') }}"
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
                           placeholder="CVC" name="cvc" value="{{ old('cvc') }}" required/>
                    <span>CVC</span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group d-flex flex-column flex-sm-row justify-content-between align-items-sm-center border-bottom">
        <span class="fs-22">Total sem juros</span>
        <span class="font-weight-bold fs-22">R$ {{ number_format($url->value, 2, ',', ' ') }}</span>
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
