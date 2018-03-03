<div class="container" >
    <div id="edit-about-item" style="display: none;" class="page-content-inner hide-container">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-purple">
                            <i class="icon-settings font-purple"></i>
                            <span class="caption-subject bold uppercase"> Sobre (Itens) </span>
                        </div>

                    </div>
                    <div class="portlet-body form">
                        <form role="form" id="form-about-item" method="post">
                            <div class="form-body">
                                @foreach($about_item as $item)
                                    <div class="form-group">
                                        <label>Título</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font font-purple"></i>
                                            </span>
                                            <input type="text" class="form-control" name="title-about-item" value="{{ $item->title }}"
                                                   placeholder="Digite o título" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Subtítulo</label>
                                        <textarea class="form-control" rows="3" name="subTitle-main"
                                                  required >{{ $item->text }}</textarea>
                                    </div>

                                @endforeach

                            </div>
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