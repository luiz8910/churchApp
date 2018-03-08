<div class="container">
    <div class="page-content-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-green-haze">
                            <i class="icon-bar-chart font-green-haze"></i>
                            <span class="caption-subject font-green-haze bold"> Items (Vantagens) </span>
                        </div> <!-- FIM DIV .caption.font-green-haze -->

                        <div class="actions">
                            <div class="btn-group btn-group-sm">
                                <div class="col-lg-12">
                                    <div class="btn-group-devided">
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div> <!-- FIM DIV .portlet-title -->


                    <div class="portlet-body form">
                        <div class="portlet-body-config">

                            <div class="table-scrollable table-scrollable-borderless table-striped">
                                <table class="table table-hover table-light table-striped">
                                    <thead>
                                    <tr class="uppercase">
                                        <th> Texto </th>
                                        <th> Opções </th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($plans_item as $plan)

                                        <tr id="tr-{{ $plan->id }}">

                                            <td>
                                                @if(strlen($plan->text) > 50)
                                                    <?php $str = substr($plan->text, 0, 50) . " ..."; ?>
                                                    {{ $str }}
                                                @else
                                                    {{ $plan->text }}
                                                @endif

                                            </td>

                                            <td>
                                                <a href="javascript:;" class="btn red btn-circle btn-outline btn-sm btn-delete-plan-item"
                                                   id="btn-delete-plan-item-{{ $plan->id }}">
                                                    <i class="fa fa-trash"></i>
                                                    Excluir
                                                </a>
                                            </td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                                <br>


                            </div> <!-- FIM DIV .table-scrollable.table-scrollable-borderless.table-striped -->
                        </div> <!-- FIM DIV .portlet-body-config -->

                        <!-- <div class="form-actions ">
                            <button type="button" class="btn blue">Enviar</button>
                            <button type="button" class="btn default">Cancel</button>
                        </div> -->
                    </div> <!-- FIM DIV .portlet-body.form  -->
                </div> <!-- FIM DIV .portlet.light -->
            </div> <!-- FIM DIV .col-md-12 -->
        </div> <!-- FIM DIV .row -->
    </div> <!-- FIM DIV .page-content-inner -->
</div>