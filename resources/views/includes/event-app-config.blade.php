<div class="caption caption-md">
    <i class="icon-globe theme-font hide"></i>
    <span class="caption-subject font-blue-madison bold uppercase">Configurações do Aplicativo</span>
</div>
<hr><br>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Cor Primária</label>
            <div class="input-group colorpicker-component">
                <span class="input-group-addon"><i></i></span>
                <input class="form-control" name="primary_color" type="text"
                       value="{{ $model->primary_color }}">
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Cor Secundária</label>
            <div class="input-group colorpicker-component">
                <span class="input-group-addon"><i></i></span>
                <input class="form-control" name="secondary_color" type="text"
                       value="{{ $model->secondary_color }}">
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Cor Terciária</label>
            <div class="input-group colorpicker-component">
                <span class="input-group-addon"><i></i></span>
                <input class="form-control" name="tertiary_color" type="text"
                       value="{{ $model->tertiary_color }}">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.onload = function () {
        $('.colorpicker-component').colorpicker();
    };
</script>
