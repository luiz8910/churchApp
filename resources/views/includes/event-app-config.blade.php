<div class="caption caption-md">
    <i class="icon-globe theme-font hide"></i>
    <span class="caption-subject font-blue-madison bold uppercase">Configurações do Aplicativo</span>
</div>
<hr><br>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Cor Primária</label>
            <div class="input-group colorpicker-component">
                <span class="input-group-addon"><i></i></span>
                <input class="form-control" name="app_primary_color" type="text"
                       value="@if(isset($org)){{ $org->app_primary_color }}@else{{ old('app_primary_color', '#000000') }}@endif">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Cor Secundária</label>
            <div class="input-group colorpicker-component">
                <span class="input-group-addon"><i></i></span>
                <input class="form-control" name="app_secondary_color" type="text"
                       value="@if(isset($org)){{ $org->app_secondary_color }}@else{{ old('app_secondary_color', '#000000') }}@endif">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.onload = function () {
        $('.colorpicker-component').colorpicker();
    };
</script>