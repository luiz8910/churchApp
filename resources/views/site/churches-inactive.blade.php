<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    @include('includes.head')
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-boxed">
    <div class="page-wrapper">
        <div class="page-wrapper-row">
            <div class="page-wrapper-top">
                <!-- BEGIN HEADER -->
                @include('includes.header-admin')
                        <!-- END HEADER -->
            </div> <!-- FIM DIV.page-wrapper-top -->
        </div> <!-- FIM DIV.page-wrapper-row -->

        <div class="page-wrapper-row full-height">
            <div class="page-wrapper-middle">
                <div class="page-container">
                    <div class="page-content-wrapper">
                        <div class="page-head">
                            <div class="container">
                                <div class="page-title">
                                    <h1>Organizações</h1>
                                </div>
                            </div> <!-- FIM DIV .container -->
                        </div> <!-- FIM DIV .page-head -->

                        <div class="page-content">
                            <div class="container">
                                @include('includes.messages')

                                <?php $route = "person";?>

                                <div class="page-content-inner">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light">
                                                <div class="portlet-title">
                                                    <div class="caption font-green-haze">
                                                        <i class="fa fa-user font-green-haze"></i>
                                                        <span class="caption-subject font-green-haze bold ">Organizações</span>
                                                    </div>
                                                    <div class="actions">
                                                        <div class="btn-group btn-group-sm">

                                                                {{--<div class="col-lg-9">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" id="btn-search" placeholder="Digite 3 letras ou mais...">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn btn-default" type="button">
                                                                                    <i class="fa fa-search font-green"></i>
                                                                                </button>
                                                                            </span>
                                                                    </div><!-- /input-group -->
                                                                </div><!-- /.col-lg-8 -->--}}


                                                            @include('includes.church-options')



                                                        </div> <!-- FIM DIV .btn-group -->
                                                    </div> <!-- FIM DIV .actions -->
                                                </div> <!-- FIM DIV .portlet-title -->

                                                <div class="portlet-body form">
                                                    <div class="portlet-body-config">
                                                        <div class="col-md-12">
                                                            <div class="div-loading" id="loading-results">
                                                                <i class="fa fa-refresh fa-spin fa-5x fa-fw"
                                                                   id="icon-loading-cep">
                                                                </i>
                                                                <p class="text-center" id="p-loading-cep">
                                                                    Carregando ...
                                                                </p>
                                                            </div>

                                                            <p class="text-center" id="p-zero" style="display: none;">
                                                                Nenhum resultado
                                                            </p>

                                                        </div>
                                                        <div class="table-scrollable table-scrollable-borderless table-striped">
                                                            <table class="table table-hover table-light table-striped">
                                                                <thead>
                                                                <tr class="uppercase">
                                                                    {{--<th> Foto </th>--}}
                                                                    <th> Nome </th>
                                                                    <th> Email </th>
                                                                    <th> Telefone </th>
                                                                    <th> Sigla </th>
                                                                    <th> Cliente desde </th>
                                                                    <th>  </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="hide" id="tbody-search"></tbody>
                                                                <tbody>
                                                                    @foreach($churches as $item)
                                                                        <tr id="tr-{{ $item->id }}">
                                                                            {{--<td> <img src="{{ $item->imgProfile }}" style="width: 50px; height: 50px;"> </td>--}}
                                                                            <td>{{ $item->name }}</td>

                                                                            <td>{{ $item->email }}</td>

                                                                            <td> {{ $item->tel }} </td>

                                                                            <td> {{ $item->alias }} </td>

                                                                            <td> {{ $item->sinceOf }} </td>

                                                                            <td>

                                                                                <button class="btn btn-success btn-sm btn-circle btn-activate" id="btn-activate-{{ $item->id }}">
                                                                                    <i class="fa fa-check"></i>
                                                                                    Ativar
                                                                                </button>

                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            <br>
                                                            <div class="pull-right" id="pagination">
                                                                {{ $churches->links() }}
                                                            </div>
                                                        </div> <!-- FIM DIV .table-scrollable table-scrollable-borderless -->
                                                    </div> <!-- FIM DIV .portlet-body-config -->
                                                </div> <!-- FIM DIV .portlet-body form -->
                                            </div> <!-- FIM DIV .portlet light -->
                                        </div> <!-- FIM DIV .col-md-12 -->
                                    </div> <!-- FIM DIV .row -->
                                </div> <!-- FIM DIV .page-content-inner -->
                            </div> <!-- FIM DIV .container -->
                        </div> <!-- FIM DIV .page-content -->
                    </div> <!-- FIM DIV .page-content-wrapper -->
                </div> <!-- FIM DIV.page-container -->
            </div> <!-- FIM DIV .page-wrapper-middle -->
        </div> <!-- FIM DIV .page-wrapper-row full-height -->


        <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center">Editar Organização</h4>
                    </div>
                    <form action="" method="POST" id="form-edit">

                        <div class="modal-body">

                            <div>

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#church" aria-controls="home" role="tab" data-toggle="tab">Organização</a></li>
                                    <li role="presentation"><a href="#responsible" aria-controls="profile" role="tab" data-toggle="tab">Responsável</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="church">

                                        <br>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome da Organização</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>
                                                        <input type="text" name="church_name" class="form-control" id="church_name"
                                                               placeholder="Digite aqui o nome da Organização" value="{{ old('church_name') }}" required

                                                        >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Sigla da Organização (Opcional)</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>
                                                        <input type="text" name="church_alias" class="form-control" id="church_alias"
                                                               placeholder="Digite aqui a sigla da Organização" value="{{ old('church_alias') }}"

                                                        >
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Telefone da Organização</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-phone font-green"></i>
                                                    </span>
                                                        <input type="text" class="form-control tel" name="tel"
                                                               id="tel" value="{{ old('tel') }}"
                                                               placeholder="(15) 1231413423" required

                                                        >
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group" id="form-cnpj">
                                                    <label>CNPJ (Sem pontos ou traços)</label>
                                                    <div class="input-group input-icon right">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>
                                                        <input type="text" name="cnpj" id="cnpj" maxlength="18" class="form-control"
                                                               placeholder="XXXXXXXXXXX" value="{{ old('cnpj') }}" required
                                                        >
                                                        <i class="fa fa-check font-green" id="icon-success-cnpj" style="display: none;"></i>
                                                        <i class="fa fa-exclamation font-red" id="icon-error-cnpj" style="display: none;"></i>

                                                    </div>
                                                    <div class="help-block small-error">CNPJ Inválido</div>
                                                    <div class="help-block small-error" id="textResponse-cnpj" style="color: red;"></div>
                                                </div>
                                            </div>


                                        </div>

                                        <br>


                                        <div class="caption caption-md">
                                            <i class="icon-globe theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase">Endereço da Organização</span>
                                        </div>
                                        <hr><br>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="div-loading">
                                                    <i class="fa fa-refresh fa-spin fa-5x fa-fw"
                                                       id="icon-loading-cep-2">
                                                    </i>
                                                    <p class="text-center" id="p-loading-cep-2" style="display: block;">
                                                        Buscando Cep ...
                                                    </p>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-6 input-address">
                                                <div class="form-group">
                                                    <label>CEP (sem traços)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-location-arrow font-purple"></i>
                                                        </span>
                                                        <input type="text" class="form-control" name="zipCode-2"
                                                               id="zipCode-2" placeholder="XXXXX-XXX" value="{{ old('zipCode_church') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-9 input-address">
                                                <div class="form-group">
                                                    <label>Logradouro</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-home font-purple"></i>
                                                        </span>
                                                        <input class="form-control" name="street-2" id="street-2"
                                                               type="text" placeholder="Av. Antonio Carlos Comitre"
                                                               value="{{ old('street-2') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 input-address">
                                                <div class="form-group">
                                                    <label class="hidden-xs hidden-sm">Número</label>
                                                    <label class="hidden-md hidden-lg">N°</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-home font-purple"></i>
                                                        </span>
                                                        <input class="form-control number" name="number-2" id="number-2"
                                                               type="text" placeholder="685"
                                                               value="{{ old('number-2') }}">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-5 input-address">
                                                <div class="form-group">
                                                    <label>Bairro</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-home font-purple"></i>
                                                        </span>
                                                        <input class="form-control" name="neighborhood-2" id="neighborhood-2"
                                                               type="text" placeholder="Centro" value="{{ old('neighborhood-2') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-5 input-address">
                                                <div class="form-group">
                                                    <label>Cidade</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building font-purple"></i>
                                                        </span>
                                                        <input class="form-control" name="city-2" id="city-2"
                                                               type="text" placeholder="Sorocaba" value="{{ old('city-2') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 input-address">
                                                <div class="form-group">
                                                    <label>Estado</label>
                                                    <select name="state-2" class="form-control" id="state-2">
                                                        <option value="">Selecione</option>
                                                        @foreach($state as $item)
                                                            <option value="{{ $item->initials }}">{{ $item->state }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div role="tabpanel" class="tab-pane fade" id="responsible">


                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=foto+do+perfil" alt="" id="img-resp"/>
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                        {{--<div>
                                                                <span class="btn default btn-file">
                                                                    <span class="fileinput-new"> Escolher Imagem </span>
                                                                    <span class="fileinput-exists"> Alterar </span>
                                                                    <input type="file" name="img"> </span>
                                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remover </a>
                                                        </div>--}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>
                                                        <input type="text" class="form-control" id="name_resp"
                                                               placeholder="José" value="" required readonly

                                                        >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Sobrenome</label>
                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>
                                                        <input type="text" class="form-control" id="lastname_resp"
                                                               placeholder="da Silva" value="" required readonly

                                                        >
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group" id="form-email">
                                                    <label>Email</label>
                                                    <div class="input-group input-icon right">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-envelope font-blue" id="icon-email"></i>
                                                            </span>
                                                        <input type="text" name="email" id="email" class="form-control"
                                                               placeholder="email@dominio.com" value="" required
                                                        >

                                                        <i class="fa fa-check font-green" id="icon-success-email" style="display: none;"></i>
                                                        <i class="fa fa-exclamation font-red" id="icon-error-email" style="display: none;"></i>
                                                    </div>
                                                    <span class="help-block" id="emailExists" style="display: none; color: red;">
                                                        <i class="fa fa-block"></i>
                                                        Já existe uma conta associada a este email
                                                    </span>
                                                    <span class="help-block" id="invalidEmail" style="display: none; color: red;">
                                                        <i class="fa fa-block"></i>
                                                        Email em formato incorreto
                                                    </span>
                                                    <span class="help-block" id="validEmail" style="display: none; color: green;">
                                                        <i class="fa fa-check"></i>
                                                        Email Válido
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Celular</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-mobile font-blue"></i>
                                                    </span>
                                                        <input type="text" class="form-control tel" id="cel" readonly
                                                               value="{{ old('cel') }}" placeholder="(15) 9231413423"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Data de Nasc.</label>
                                                    <div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar font-blue"></i>
                                                            </span>
                                                        <input type="text" class="form-control input-date" id="dateBirth"
                                                               placeholder="dd/mm/aaaa" maxlength="10" value="{{ old('dateBirth') }}" required readonly
                                                        >
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" id="form-cpf">
                                                    <label>CPF (Sem pontos ou traços)</label>
                                                    <div class="input-group input-icon right">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user font-blue"></i>
                                                            </span>
                                                        <input type="text" id="cpf" maxlength="11" class="form-control"
                                                               placeholder="XXXXXXXXXXX" value="{{ old('cpf') }}" required readonly
                                                        >
                                                        <i class="fa fa-check font-green" id="icon-success-cpf" style="display: none;"></i>
                                                        <i class="fa fa-exclamation font-red" id="icon-error-cpf" style="display: none;"></i>

                                                    </div>
                                                    <div class="help-block small-error">CPF Inválido</div>
                                                    <div class="help-block small-error" id="textResponse" style="color: red;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Gênero</label>
                                                    <div class="input-icon input-icon-lg">
                                                        <select class="form-control" id="gender" required readonly
                                                        >
                                                            <option value="">Selecione</option>
                                                            <option value="M" @if(old('gender') == "M") selected @endif>
                                                                Masculino
                                                            </option>
                                                            <option value="F" @if(old('gender') == "F") selected @endif>
                                                                Feminino
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="maritalStatus">Estado Civil</label>
                                                    <select id="maritalStatus" class="form-control" required>

                                                        <option value="">Selecione</option>
                                                        <option value="Casado" @if(old('maritalStatus') == "Casado") selected @endif>
                                                            Casado
                                                        </option>
                                                        <option value="Solteiro" @if(old('maritalStatus') == "Solteiro") selected @endif>
                                                            Solteiro
                                                        </option>
                                                        <option value="Divorciado" @if(old('maritalStatus') == "Divorciado") selected @endif>
                                                            Divorciado
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <br><br>

                                        @include('includes.address-create')

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <i class="fa fa-close"></i> Fechar
                            </button>

                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> Salvar</button>
                        </div>

                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    </div>

    @include('includes.footer')
    @include('includes.core-scripts')


    <script src="../js/site.js"></script>
    <script src="../js/myAccount.js"></script>
    <script src="../js/church.js"></script>
</body>

</html>