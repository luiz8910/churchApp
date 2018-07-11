
    <a class="btn blue btn-outline btn-circle btn-sm" href="javascript:;"
       data-toggle="modal" data-target="#new-church" style="margin-top: 3px; margin-left: -10px;">
        <i class="fa fa-home"></i>
        <span class="hidden-xs"> Nova Igreja </span>
    </a>

<div class="col-lg-3">
    <a class="btn red btn-outline btn-circle btn-sm" href="javascript:;"
       data-toggle="dropdown" style="margin-top: 3px; margin-left: -10px;">
        <i class="fa fa-share"></i>
        <span class="hidden-xs"> Opções </span>
        <i class="fa fa-angle-down"></i>
    </a>
    <ul class="dropdown-menu pull-right" id="sample_3_tools">

        <li>
            <a href="{{ route('admin.churches') }}"
               data-action="0" class="tool-action">
                <i class="fa fa-users font-purple"></i> Ativos
            </a>
        </li>

        <li>
            <a href="{{ route('inactive.churches') }}"
               data-action="0" class="tool-action">
                <i class="fa fa-user-times font-purple"></i> Inativos
            </a>
        </li>

        <li>
            <a href="{{ route('waiting.churches') }}"
               data-action="0" class="tool-action">
                <i class="fa fa-binoculars font-purple"></i> Pendentes
            </a>
        </li>

        <!--<li>
                <a href="javascript:;" id="print" onclick="printDiv('printable-table')"
                   data-action="0" class="tool-action">
                    <i class="icon-printer"></i> Imprimir
                </a>
            </li>
            <li>
                <a href="javascript:;" data-action="1" class="tool-action">
                    <i class="icon-check"></i> Copiar</a>
            </li>
            <li>
                <a href="javascript:;" data-action="2"
                   onclick="printDiv('printable-table', 'pdf')" class="tool-action">
                    <i class="icon-doc"></i> PDF</a>
            </li>
            <li>
                <a href="{{ route($route.'.excel', ['format' => 'xls']) }}"
                   data-action="3" target="_blank"
                   class="tool-action">
                    <i class="icon-paper-clip"></i> Excel</a>
            </li>
            <li>
                <a href="{{ route($route.'.excel', ['format' => 'csv']) }}"
                   data-action="4" target="_blank" class="tool-action">
                    <i class="icon-cloud-upload"></i> CSV</a>
            </li>-->
    </ul>
</div>


<div class="modal fade" id="new-church" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Nova Igreja</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-close"></i> Fechar
                </button>

                <button type="button" class="btn btn-success">
                    <i class="fa fa-check"></i>
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div>