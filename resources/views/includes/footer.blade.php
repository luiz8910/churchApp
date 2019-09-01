<div class="page-wrapper-row" id="footer">
    <div class="page-wrapper-bottom">
        <!-- BEGIN FOOTER -->
        <?php $today_year = date_create(); $today_year = date_format($today_year, "Y")?>
        <!-- BEGIN INNER FOOTER -->
        <div class="page-footer">
            <div class="container text-center"> {{ $today_year }} &copy;
                <a target="_blank" href="javascript:;">Beconnect</a> &nbsp;&nbsp;
            </div>
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
        <!-- END INNER FOOTER -->
        <!-- END FOOTER -->
    </div>
</div>

<div id="modal-padrao" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"></h4>
            </div>
            <div class="modal-body" id="modal-padrao-body">
                <p class="modal-p"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
