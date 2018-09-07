<div class="page-content-inner" id="new-church" style="display: none;">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-green-haze">
                        <i class="fa fa-home font-blue"></i>
                        <span class="caption-subject font-blue bold ">Nova Igreja</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-sm">

                            {{-- <div class="col-lg-9">
                                 <div class="input-group">
                                     <input type="text" class="form-control" id="btn-search" placeholder="Digite 3 letras ou mais...">
                                         <span class="input-group-btn">
                                             <button class="btn btn-default" type="button">
                                                 <i class="fa fa-search font-green"></i>
                                             </button>
                                         </span>
                                 </div><!-- /input-group -->
                             </div><!-- /.col-lg-8 -->--}}

                            <div class="col-md-12">
                                <div class="input-group" style="cursor: pointer;" onclick="closeForm();">
                                    X
                                </div>
                            </div>

                        </div> <!-- FIM DIV .btn-group -->
                    </div> <!-- FIM DIV .actions -->
                </div> <!-- FIM DIV .portlet-title -->

                <div class="portlet-body form">
                    <div class="portlet-body-config">


                        <form action="{{ route('new.church') }}" class="form" role="form" method="post">
                            {{ csrf_field() }}


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nome da Igreja</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-home font-blue"></i>
                                            </span>
                                            <input type="text" name="name" class="form-control" id="name"
                                                   placeholder="Nome da Igreja" value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Sigla da Igreja</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-home font-blue"></i>
                                            </span>
                                            <input type="text" name="alias" class="form-control" id="alias"
                                                   placeholder="Sigla da Igreja" value="{{ old('alias') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Telefone</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-phone font-blue"></i>
                                            </span>
                                            <input type="text" name="tel" class="form-control tel" id="tel"
                                                   placeholder="Telefone da Igreja" value="{{ old('tel') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">CNPJ</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-home font-blue"></i>
                                            </span>
                                            <input type="text" name="cnpj" class="form-control" id="cnpj"
                                                   placeholder="CNPJ da Igreja" value="{{ old('cnpj') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br><br>

                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Dados do Responsável</span>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="responsible_name">Nome do Responsável</label>

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-user font-blue"></i>
                                            </span>

                                            <input type="text" name="responsible_name" class="form-control" id="responsible_name"
                                                placeholder="Nome do Responsável" value="{{ old('responsible_name') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="email">Email do Responsável</label>

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-envelope font-blue"></i>
                                            </span>

                                            <input type="email" name="email" class="form-control" id="email"
                                                   placeholder="Email do Responsável" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="form-password">

                                        <label for="password">Senha:</label>

                                        <div class="input-group input-icon right">
                                            <span class="input-group-addon">
                                                <i class="fa fa-lock font-blue icon-green" aria-hidden="true"></i>
                                                <i class="fa fa-lock font-red icon-red" style="display: none;" aria-hidden="true"></i>
                                            </span>
                                            <input type="password" class="form-control" placeholder="Digite sua senha" minlength="6" maxlength="15"
                                                   id="password" name="password">
                                            <i class="fa fa-check font-green" id="icon-success-pass" style="display: none;"></i>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group" id="form-password-conf">

                                        <label for="password_conf">Confirmar Senha:</label>

                                        <div class="input-group input-icon right">
                                            <span class="input-group-addon">
                                                <i class="fa fa-lock font-blue icon-green" aria-hidden="true"></i>
                                                <i class="fa fa-lock font-red icon-red" style="display: none;" aria-hidden="true"></i>
                                            </span>

                                            <input type="password" class="form-control" placeholder="Confirme sua senha" id="password_conf">
                                            <i class="fa fa-check font-green" id="icon-success-pass-conf" style="display: none;"></i>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">

                                        <fieldset>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" name="parents" class="checkboxes check-model"
                                                       id="checkbox-pass" value="1" />
                                                <span></span>Gerar Senha
                                            </label>
                                        </fieldset>

                                    </div>
                                </div>
                            </div>



                            <br><br>

                            @include('includes.address-create')


                            <div class="form-actions">
                                <button type="submit" class="btn blue" id="btn-submit-church">
                                    <i class="fa fa-check"></i>
                                    Enviar
                                </button>

                                <a href="javascript:;" class="btn btn-default" id="btn-close" onclick="clearFields();">
                                    <i class="fa fa-paint-brush"></i>
                                    Limpar
                                </a>
                                <div class="progress" style="display: none;">
                                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                                         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                        Enviando...
                                        <span class="sr-only">Enviando...</span>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div> <!-- FIM DIV .portlet-body-config -->
                </div> <!-- FIM DIV .portlet-body form -->
            </div> <!-- FIM DIV .portlet light -->
        </div> <!-- FIM DIV .col-md-12 -->
    </div> <!-- FIM DIV .row -->
