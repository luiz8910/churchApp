<div class="container">
    @include('includes.messages')
    <div class="page-content-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-green-haze">
                            <i class="icon-bar-chart font-green-haze"></i>
                            <span class="caption-subject font-green-haze bold"> Planos</span>
                        </div> <!-- FIM DIV .caption.font-green-haze -->

                        <div class="actions">
                            <div class="btn-group btn-group-sm">
                                <div class="col-lg-12">
                                    <div class="btn-group-devided">
                                        <a role="button" class="btn btn-info btn-circle btn-sm" id="newPlan" href="javascript:;" style="margin-top: 2px;">
                                            <i class="fa fa-plus"></i>
                                            <span class="hidden-xs hidden-sm">Novo Plano</span>
                                            <span class="hidden-md hidden-lg">Plano</span>
                                        </a>
                                        <a href="javascript:;" class="btn green btn-circle btn-outline btn-sm btn-new-plan-item"
                                           id="btn-new-plan-item" style="margin-top: 2px;">
                                            <i class="fa fa-plus"></i>
                                            <span class="hidden-xs hidden-sm">Novo Item</span>
                                            <span class="hidden-md hidden-lg">Item</span>
                                        </a>
                                        <a role="button" class="btn purple btn-circle btn-sm btn-outline" id="newPlanFrequency" href="javascript:;" style="margin-top: 2px;">
                                            <i class="fa fa-plus"></i>
                                            <span class="hidden-xs hidden-sm">Tipos de Planos</span>
                                            <span class="hidden-md hidden-lg">Frequência</span>
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
                                        <th> Nome </th>
                                        <th> Descrição </th>
                                        <th> Frequência </th>
                                        <th> Popular </th>
                                        <th> Preço </th>
                                        <th> Opções </th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($plans as $plan)

                                        <tr id="tr-{{ $plan->id }}">
                                            <td>{{ $plan->name }}</td>
                                            <td>
                                                @if(strlen($plan->text) > 50)
                                                    <?php $str = substr($plan->description, 0, 50) . " ..."; ?>
                                                    {{ $str }}
                                                @else
                                                    {{ $plan->description }}
                                                @endif

                                            </td>
                                            <td>
                                                {{ $plan->type_name }}
                                            </td>
                                            <td>
                                                @if($plan->most_popular == 1)
                                                    Sim
                                                @else
                                                    Não
                                                @endif
                                            </td>
                                            <td>
                                                R${{ $plan->price }}
                                            </td>
                                            <td>
                                                <a href="javascript:;" class="btn blue btn-circle btn-outline btn-sm btn-edit-plan"
                                                   id="btn-edit-plan-{{ $plan->id }}">
                                                    <i class="fa fa-pencil"></i>
                                                    Editar
                                                </a>
                                                <a href="javascript:;" class="btn red btn-circle btn-outline btn-sm btn-delete-plan"
                                                   id="btn-delete-plan-{{ $plan->id }}">
                                                    <i class="fa fa-trash"></i>
                                                    Excluir
                                                </a>
                                            </td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                                <br>


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