<button type="button" data-toggle="modal" id="btn-insert-modal" data-target="#insert-modal" hidden>Launch modal</button>

<input type="hidden" value="{{ $url }}" id="url">
<input type="hidden" value="{{ $url2 }}" id="url2">

<!-- Modal -->
<div class="modal fade" id="insert-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <h4 class="modal-title text-center" id="myModalLabel">Novo Registro</h4>
            </div>


            <form action="" method="post" id="form-insert">

                <div class="modal-body">

                    <div id="div-form">



                    </div>


                </div>

                <div class="modal-footer">


                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                    <button type="submit" id="btn-submit-insert" class="btn btn-success">
                        <i class="fa fa-check"></i>
                        Salvar
                    </button>

                </div>
            </form>


            <div class="row" style="display: none;">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="type_id">Frequência de cobrança</label>
                        <select id="type_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($plans_types as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->type }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>