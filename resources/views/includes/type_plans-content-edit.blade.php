@foreach($plans_types as $plan)
    <div class="container">
        <div class="page-content-inner hide-container-item container-type-plan-edit-{{ $plan->id }}" style="display: none;">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption font-green-haze">
                                <i class="icon-bar-chart font-green-haze"></i>
                                <span class="caption-subject font-green-haze bold"> Editar Tipo de Plano </span>
                            </div> <!-- FIM DIV .caption.font-green-haze -->
                        </div> <!-- FIM DIV .portlet-title -->

                        <div class="portlet-body form">
                            <form action="{{ route('admin.edit-plan-type') }}" method="post" class="form-plan-item">

                                <br>

                                <input type="hidden" value="{{ $plan->id }}" name="input-id">

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Tipo</label>
                                        <input type="text" class="form-control" name="type" value="{{ $plan->type }}"
                                               placeholder="Digite o tipo do plano" id="" required>
                                    </div>

                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Texto Selecionado</label>
                                        <textarea type="text" cols="30" rows="10" class="form-control" name="selected_text" required>
                                            {{ $plan->selected_text }}
                                        </textarea>
                                    </div>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Adjetivo</label>
                                        <input type="text" class="form-control" name="type" value="{{ $plan->adjective }}"
                                               placeholder="Digite o Adjetivo" id="" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Economize</label>
                                        <input type="number" class="form-control" name="save_money" value="{{ $plan->save_money }}">
                                    </div>
                                </div>

                                <br>


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