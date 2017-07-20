
    <h3 id="h3-pass" @if(isset($visitor)) style="display: none;" @endif>Senha</h3>

    <div class="row" id="row-pass" @if(isset($visitor)) style="display: none;" @endif>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Senha</label>
                <div class="input-group input-icon right">
                    <span class="input-group-addon">
                        <i class="fa fa-lock font-blue" id="icon-password"></i>
                    </span>

                    <input type="password" name="password" id="password"
                           placeholder="Digite sua senha" class="form-control" minlength="6"
                           @if(!isset($visitor)) required @endif
                           >

                    <i class="fa fa-check font-green" id="icon-success-password" style="display: none;"></i>
                    <i class="fa fa-exclamation font-red" id="icon-error-password" style="display: none;"></i>

                </div>

                <span class="help-block" id="passDontMatch" style="display: none; color: red;">
                    <i class="fa fa-ban font-red"></i>
                    As senhas não combinam
                </span>

                <span class="help-block" id="passMatch" style="display: none; color: #3598DC;">
                    <i class="fa fa-check font-blue"></i>
                    Senha válida
                </span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Confirme sua Senha</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-lock font-blue"></i>
                    </span>

                    <input type="password" id="confirm-password" name="confirm-password"
                           placeholder="Confirme sua senha" class="form-control"
                           @if(!isset($visitor)) required @endif>
                </div>

            </div>
        </div>
    </div>

