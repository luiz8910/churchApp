@if(count($faq) > 0)
    @foreach($faq as $f)
        <div class="container"  >
            <div id="edit-faq-{{ $f->id }}" style="display: none;" class="page-content-inner hide-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption font-purple">
                                    <i class="icon-settings font-purple"></i>
                                    <span class="caption-subject bold uppercase"> FAQ </span>
                                </div>

                            </div>
                            <div class="portlet-body form">
                                <form role="form" action="#" class="form-faq-edit" id="form-faq-edit-{{ $f->id }}" method="post">

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="question-edit">Pergunta</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-font font-purple"></i>
                                                </span>
                                                <input type="text" class="form-control" id="question-edit-{{ $f->id}}" name="question-edit" value="{{ $f->question }}"
                                                       placeholder="Digite a pergunta" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="answer-edit">Resposta</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-font font-purple"></i>
                                                </span>
                                                <input type="text" class="form-control" id="answer-edit-{{ $f->id }}" name="answer-edit" value="{{ $f->answer }}"
                                                       placeholder="Digite a resposta" required>
                                            </div>
                                        </div>

                                    </div>

                                    <input type="hidden" name="faq-id" value="{{ $f->id }}">
                                    <div class="form-actions">
                                        <button type="submit" class="btn purple">
                                            <i class="fa fa-check"></i>
                                            Salvar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- FIM DIV .col-md-12 -->
                </div> <!-- FIM DIV .row -->
            </div> <!-- FIM DIV .page-content-inner -->
        </div>
    @endforeach
@endif