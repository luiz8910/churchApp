<div class="caption caption-md">
    <i class="icon-globe theme-font hide"></i>
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
                    <i class="fa fa-location-arrow font-purple"></i>
                </span>
                <input type="text" class="form-control" name="zipCode"
                       id="zipCode" placeholder="XXXXX-XXX" value="{{ $org->zipCode }}">
            </div>
        </div>
    </div>

    <div class="col-md-8 input-address">
        <div class="form-group">
            <label>Logradouro</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-home font-purple"></i>
                </span>
                <input class="form-control" name="street" id="street"
                       type="text" placeholder="Av. Antonio Carlos Comitre"
                       value="{{ $org->street }}">
            </div>
        </div>
    </div>

    <div class="col-md-2 input-address">
        <div class="form-group">
            <label class="hidden-xs hidden-sm">Número</label>
            <label class="hidden-md hidden-lg">N°</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-home font-purple"></i>
                </span>
                <input class="form-control number" name="number" id="number"
                       type="text" placeholder="685"
                       value="{{ $org->number }}">
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
                    <i class="fa fa-home font-purple"></i>
                </span>
                <input class="form-control" name="neighborhood" id="neighborhood"
                       type="text" placeholder="Centro" value="{{ $org->neighborhood }}">
            </div>
        </div>
    </div>

    <div class="col-md-5 input-address">
        <div class="form-group">
            <label>Cidade</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-building font-purple"></i>
                </span>
                <input class="form-control" name="city" id="city"
                       type="text" placeholder="Sorocaba" value="{{ $org->city }}">
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
                            @if($org->state == $item->initials) selected @endif >{{ $item->state }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
