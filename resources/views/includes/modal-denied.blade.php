<div class="modal fade" tabindex="-1" role="dialog" id="modal-denied">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Cadastro Negado - <span id="username"></span> </h4>
            </div>

            <form action="{{ url('/denyMember') }}" method="post" id="form-deny">

                {{ csrf_field() }}

                <div class="modal-body">
                    <p class="text-center">Mande uma mensagem para o usuário porque o
                        cadastro não pode ser aprovado</p>

                        <textarea name="msg" id="" cols="30" rows="10"
                                  class="form-control" placeholder="Digite aqui os detalhes..." required></textarea>
                </div>

                <p class="text-center">Será enviado um email para <strong id="span-email"></strong> </p>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success" id="deny-submit">
                        <i class="fa fa-check"></i>
                        Enviar
                    </button>
                </div>

            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->