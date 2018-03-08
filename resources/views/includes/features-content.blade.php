<div class="page-content">
    <div class="container">
        <div class="page-content-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption font-green-haze">
                                <i class="icon-bar-chart font-green-haze"></i>
                                <span class="caption-subject font-green-haze bold"> Características</span>
                            </div> <!-- FIM DIV .caption.font-green-haze -->

                            <div class="actions">
                                <div class="btn-group btn-group-sm">
                                    <div class="col-lg-3">
                                        <div class="btn-group-devided">
                                            <a role="button" class="btn btn-info btn-circle btn-sm" id="newFeature" href="javascript:;" style="margin-top: 2px;">
                                                <i class="fa fa-plus"></i>
                                                <span class="hidden-xs hidden-sm">Nova Feature</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                            <th> Título </th>
                                            <th> Subtítulo </th>
                                            <th> Opções </th>

                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($features as $feature)

                                            <tr>
                                                <td>{{ $feature->title }}</td>
                                                <td>
                                                    @if(strlen($feature->text) > 50)
                                                        <?php $str = substr($feature->text, 0, 50) . " ..."; ?>
                                                        {{ $str }}
                                                    @else
                                                        {{ $feature->text }}
                                                    @endif

                                                </td>
                                                <td>
                                                    <a href="javascript:;" class="btn green btn-circle btn-outline btn-sm btn-new-feat-item"
                                                       id="btn-new-feat-item-{{ $feature->id }}">
                                                        <i class="fa fa-plus"></i>
                                                        Novo Item
                                                    </a>
                                                    <a href="javascript:;" class="btn blue btn-circle btn-outline btn-sm btn-edit"
                                                       id="btn-edit-{{ $feature->id }}">
                                                        <i class="fa fa-pencil"></i>
                                                        Editar
                                                    </a>
                                                    <a href="javascript:;" class="btn red btn-circle btn-outline btn-sm btn-delete"
                                                       id="btn-delete-{{ $feature->id }}">
                                                        <i class="fa fa-trash"></i>
                                                        Excluir
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <br>


                                    <div class="progress" id="progress-danger" style="display: none;">
                                        <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            Excluindo...
                                            <span class="sr-only">Excluindo...</span>
                                        </div>
                                    </div>

                                    <input type="hidden" id="notific8-title">
                                    <input type="hidden" id="notific8-text">
                                    <input type="hidden" id="notific8-type" value="danger">
                                    <a href="javascript:;" class="btn btn-danger" id="notific8" style="display: none;"></a>
                                </div> <!-- FIM DIV .table-scrollable.table-scrollable-borderless.table-striped -->
                            </div> <!-- FIM DIV .portlet-body-config -->

                            <!-- <div class="form-actions ">
                                <button type="button" class="btn blue">Enviar</button>
                                <button type="button" class="btn default">Cancel</button>
                            </div> -->
                        </div> <!-- FIM DIV .portlet-body.form  -->
                    </div> <!-- FIM DIV .portlet.light -->
                </div> <!-- FIM DIV .col-md-12 -->
            </div> <!-- FIM DIV .row -->
        </div> <!-- FIM DIV .page-content-inner -->
    </div>

    <div class="container">
        <div class="page-content-inner hide-container" style="display: none;">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption font-green-haze">
                                <i class="icon-bar-chart font-green-haze"></i>
                                <span class="caption-subject font-green-haze bold"> Editar </span>
                            </div> <!-- FIM DIV .caption.font-green-haze -->
                        </div> <!-- FIM DIV .portlet-title -->

                        <div class="portlet-body form">
                            <form action="#" method="post" id="form-features">
                                <div class="form-group">
                                    <label>Título</label>
                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-font font-purple"></i>
                                                            </span>
                                        <input type="text" class="form-control" name="title" value=""
                                               placeholder="Digite o título" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Subtítulo</label>
                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-font font-purple"></i>
                                                            </span>
                                        <input type="text" class="form-control" name="subtitle" value=""
                                               placeholder="Digite o subtítulo" required>
                                    </div>
                                </div>

                                <div class="form-actions">

                                    <button type="submit" class="btn purple">
                                        <i class="fa fa-check"></i>
                                        Salvar
                                    </button>

                                    <button type="button" class="btn btn-default close-btn">
                                        <i class="fa fa-close"></i>
                                        Fechar
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-content-inner hide-container-item" style="display: none;">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption font-green-haze">
                                <i class="icon-bar-chart font-green-haze"></i>
                                <span class="caption-subject font-green-haze bold"> Novo Item </span>
                            </div> <!-- FIM DIV .caption.font-green-haze -->
                        </div> <!-- FIM DIV .portlet-title -->

                        <div class="portlet-body form">
                            <form action="#" method="post" id="form-features-item">

                                <br>

                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="text" value=""
                                               placeholder="Digite o texto" id="input-1" required>
                                    </div>

                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger" onclick="deleteItem(1);" id="btn-delete-1">
                                            <i class="fa fa-close"></i>
                                            Excluir
                                        </button>
                                    </div>
                                </div>

                                <div id="append-div"></div>


                                <br><br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn purple">
                                            <i class="fa fa-check"></i>
                                            Salvar
                                        </button>

                                        <button type="button" class="btn btn-success btn-new-item" id="btn-new-1" onclick="newItem();">
                                            <i class="fa fa-plus"></i>
                                            Novo
                                        </button>

                                        <button type="button" class="btn btn-default close-btn">
                                            <i class="fa fa-close"></i>
                                            Fechar
                                        </button>
                                    </div>

                                </div>


                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($features as $feature)
        <div class="container">
            <div class="page-content-inner hide-container-edit cont-{{ $feature->id }}" style="display: none;" >
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption font-green-haze">
                                    <i class="icon-bar-chart font-green-haze"></i>
                                    <span class="caption-subject font-green-haze bold"> Editar Feature </span>
                                </div> <!-- FIM DIV .caption.font-green-haze -->
                            </div> <!-- FIM DIV .portlet-title -->

                            <div class="portlet-body form">
                                <form action="#" method="post" id="form-features-edit-{{ $feature->id }}" class="form-edit">

                                    <br>

                                    <div class="row">
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="title" value="{{ $feature->title }}"
                                                   placeholder="Digite o texto" id="input-title" required>
                                        </div>

                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="text" value="{{ $feature->text }}"
                                                   placeholder="Digite o texto" id="input-text" required>
                                        </div>
                                    </div>

                                    <br>

                                    @foreach($features_item as $item)

                                        @if($feature->id == $item->feature_id)
                                            <div id="div-remove-{{ $item->id }}">
                                                <div class="row">

                                                    <div class="col-md-9">

                                                        <div class="input-group">
                                                                                <span class="input-group-addon" id="basic-addon1">
                                                                                    <span><img src="{{ $item->icon_name }}" alt="" id="img-{{ $item->id }}"
                                                                                               class="icon-add" style="width:20px;height:20px"></span></span>
                                                            <input type="text" class="form-control" name="feature_id-{{ $item->id }}"
                                                                   value="{{ $item->text }}" placeholder="Digite o texto"
                                                                   id="input-text-{{ $item->id }}" required>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-danger btn-remove-item"
                                                                id="btn-delete-feat-item-{{ $item->id }}">
                                                            <i class="fa fa-close"></i>
                                                            Excluir
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <br>
                                        @endif

                                    @endforeach


                                    <br><br>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn purple">
                                                <i class="fa fa-check"></i>
                                                Salvar
                                            </button>

                                            <button type="button" class="btn btn-default close-btn">
                                                <i class="fa fa-close"></i>
                                                Fechar
                                            </button>
                                        </div>

                                    </div>


                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>