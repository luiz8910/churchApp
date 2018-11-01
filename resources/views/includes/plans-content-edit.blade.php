@foreach($plans as $plan)
    <div class="container">
        <div class="page-content-inner hide-container-item container-plan-edit-{{ $plan->id }}" style="display: none;">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light " id="portlet-{{$plan->id}}">
                        <div class="portlet-title">
                            <div class="caption font-green-haze">
                                <i class="icon-bar-chart font-green-haze"></i>
                                <span class="caption-subject font-green-haze bold"> Editar </span>
                            </div> <!-- FIM DIV .caption.font-green-haze -->
                        </div> <!-- FIM DIV .portlet-title -->

                        <div class="portlet-body form">
                            <form action="{{ route('admin.update-plan') }}" method="post" class="form-plan-item">

                                <br>

                                <input type="hidden" value="{{ $plan->id }}" name="input-id">

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Nome do Plano</label>
                                        <input type="text" class="form-control" name="name" value="{{ $plan->name }}"
                                               placeholder="Digite o nome do plano" id="" required>
                                    </div>

                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Descrição</label>
                                        <textarea type="text" cols="30" rows="10" class="form-control" name="description">
                                            {{ $plan->description }}
                                        </textarea>
                                    </div>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Tipo</label>
                                        <select name="type_id" id="" class="form-control">
                                            @foreach($plans_types as $type)
                                                <option value="{{ $type->id }}"
                                                @if($type->id == $plan->type_id) selected @endif
                                                >{{ $type->type }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Preço</label>
                                        <input type="text" class="form-control money" id="price-{{ $plan->id }}" name="price" value="{{ $plan->price }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Payu Code</label>
                                        <input type="text" class="form-control" readonly value="{{ $plan->payu_code }}">
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="people_check">
                                                <span>Itens selecionados:
                                                    <?php $none = true; ?>
                                                    @if(count($plan_features) > 0)

                                                        @foreach($plan_features as $feature)

                                                            @if($plan->id == $feature->plan_id)

                                                                @foreach($plans_item as $item)
                                                                    @if($feature->plan_item_id == $item->id)
                                                                        {{ $item->text }},
                                                                    @endif
                                                                @endforeach

                                                                <?php $none = false; ?>
                                                            @endif
                                                        @endforeach

                                                    @endif

                                                    @if($none)
                                                        Nenhum
                                                    @endif
                                                </span>
                                            </label>
                                            <select class="form-control select2-multiple" id="people_check"
                                                    name="item[]" multiple>
                                                <optgroup label="Itens" id="opt-group-check">
                                                    @foreach($plans_item as $item)
                                                        <option value="{{ $item->id }}">{{ $item->text }}</option>
                                                    @endforeach
                                                </optgroup>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset id="fieldset-check">
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" name="most_popular" class="checkboxes check-model" id="" value="1"
                                                       @if($plan->most_popular == 1) checked @endif/>
                                                <span></span>
                                            </label>
                                            Mais popular
                                        </fieldset>
                                    </div>
                                </div>






                                <br><br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn purple">
                                            <i class="fa fa-check"></i>
                                            Salvar
                                        </button>

                                        <button type="button" class="btn btn-default close-btn">
                                            <i class="fa fa-close"></i>
                                            Fechar
                                        </button>
                                    </div>

                                </div>


                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach