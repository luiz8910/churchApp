<div class="caption caption-md">
    <i class="fa fa-globe theme-font"></i>
    <span class="caption-subject font-blue-madison bold uppercase">Endereço</span>
</div>
<hr><br>


<div class="row">
    <div class="col-md-12">
        <div class="div-loading">
            <i class="fa fa-refresh fa-spin fa-5x fa-fw"
               id="icon-loading-cep">
            </i>
            <p class="text-center" id="p-loading-cep" style="display: block;">
                Buscando Cep ...
            </p>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-2 input-address">
        <div class="form-group">
            <label>CEP (sem traços)</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-location-arrow font-blue"></i>
                </span>
                <input type="text" class="form-control border-input" name="zipCode"
                       id="zipCode" placeholder="XXXXX-XXX" value="{{ $model->zipCode }}">
            </div>
        </div>
    </div>


    <div class="col-md-8 input-address">
        <div class="form-group">
            <label>Logradouro</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-home font-blue"></i>
                </span>
                <input class="form-control border-input" name="street" id="street"
                       type="text" placeholder="Av. Antonio Carlos Comitre"
                       value="{{ $model->street }}">
            </div>
        </div>
    </div>

    <div class="col-md-2 input-address">
        <div class="form-group">
            <label class="hidden-xs hidden-sm">Número</label>
            <label class="hidden-md hidden-lg">N°</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-home font-blue"></i>
                </span>
                <input class="form-control number border-input" name="number" id="number"
                       type="text" placeholder="685"
                       value="{{ $model->number }}">
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-5 input-address">
        <div class="form-group">
            <label>Bairro</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-home font-blue"></i>
                </span>
                <input class="form-control border-input" name="neighborhood" id="neighborhood"
                       type="text" placeholder="Centro" value="{{ $model->neighborhood }}">
            </div>
        </div>
    </div>

    <div class="col-md-5 input-address">
        <div class="form-group">
            <label>Cidade</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-building font-blue"></i>
                </span>
                <input class="form-control border-input" name="city" id="city"
                       type="text" placeholder="Sorocaba" value="{{ $model->city }}">
            </div>
        </div>
    </div>
    <div class="col-md-2 input-address">
        <div class="form-group">
            <label>Estado</label>
            <select name="state" class="form-control" id="state">
                <option value="">Selecione</option>
                @foreach($state as $item)
                    <option value="{{ $item->initials }}"
                            @if($model->state == $item->initials) selected @endif >{{ $item->state }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
