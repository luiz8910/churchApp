<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Nome" required>

        </div>
    </div>


</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="description">Descrição</label>
            <textarea name="description" id="description" cols="30" rows="5"
                      placeholder="Descrição" required class="form-control"></textarea>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="price">Preço</label>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">$</span>
                <input type="number" name="price" id="price" class="form-control" placeholder="Preço" required aria-describedby="basic-addon1">

            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="type_id">Frequência de cobrança</label>
            <select name="type_id" id="type_id" class="form-control" required>
                <option value="">Selecione</option>
                <option value="1">Mensal</option>
                <option value="2">Anual</option>
            </select>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <fieldset id="fieldset-check">
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" name="check-insert" class="checkboxes check-model" id="check-insert"
                           value="1" />
                    <span></span>
                </label>
                Mais popular
            </fieldset>
        </div>
    </div>

</div>
