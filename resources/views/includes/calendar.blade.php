<div class="row hidden-xs hidden-sm">
    <div class="col-md-12">
        <div class="portlet light portlet-fit calendar">


            <div class="portlet-title">

                <div class="btn-group btn-group-sm" style="float: right; margin-top: 5px;">
                    <a class="btn green btn-outline btn-circle btn-sm"
                       href="javascript:;" data-toggle="dropdown">
                        <i class="fa fa-share"></i>
                        <span class="hidden-xs"> Opções </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-right"
                        id="sample_3_tools">
                        <li>
                            <a href="{{ route('event.create') }}" class="tool-action font-purple">
                                <i class="fa fa-calendar font-purple"></i>
                                Novo Evento
                            </a>
                        </li>
                        <li>
                            <a href="javascript:" class="tool-action">
                                <i class="fa fa-print"></i>
                                Lista dos Próximos Eventos (.PDF)
                            </a>
                        </li>
                        <!--<li>
                            <a href="javascript:;" data-action="1" class="tool-action">
                                <i class="icon-check"></i> Copiar</a>
                        </li>-->

                    </ul>
                </div>

                <div class="caption">
                    <i class="fa fa-calendar font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">Calendário

                        <span class="label label-default lbl-opacity" id="all" style="margin-left: 20px;">Todos</span>
                        <span class="label label-primary lbl-opacity" id="daily">Diário</span>
                        <span class="label label-success lbl-opacity" id="weekly">Semanal</span>
                        <span class="label label-Quinzenal lbl-opacity" id="biweekly">Quinzenal</span>
                        <span class="label label-warning lbl-opacity" id="monthly">Mensal</span>
                        <span class="label label-danger lbl-opacity" id="singleEvent">Encontro Único</span>
                    </span>

                </div>



            </div>


            <div class="header-box-calendario">
                <ul class="pagination ">
                    @if(Auth::user()->church_id == $church_id)
                        <li>
                            <a class="btn-pagination" href="{{ route('events.agenda-mes', ['thisMonth' => $thisMonth - 2])}}">
                                <i class="fa fa-angle-left fa-2x"></i>
                            </a>
                        </li>
                        <li>
                            <a class="btn-pagination" href="{{ route('events.agenda-mes', ['thisMonth' => $thisMonth - 2])}}">
                                {{ $allMonths[$thisMonth - 1] }}
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="btn-pagination" href="{{ route('events.agenda-mes',
                            ['thisMonth' => $thisMonth - 2, 'church_id' => $church_id])}}">
                                <i class="fa fa-angle-left fa-2x"></i>
                            </a>
                        </li>
                        <li>
                            <a class="btn-pagination" href="{{ route('events.agenda-mes',
                            ['thisMonth' => $thisMonth - 2, 'church_id' => $church_id])}}">
                                {{ $allMonths[$thisMonth - 1] }}
                            </a>
                        </li>
                    @endif

                    <li class="active">
                        <a href="javascript:;"> <strong>{{ $allMonths[$thisMonth] }}</strong> </a>
                    </li>

                    @if(Auth::user()->church_id == $church_id)
                        <li>
                            <a class="btn-pagination" href="{{ route('events.agenda-mes', ['thisMonth' => $thisMonth])}}">
                                {{ $allMonths[$thisMonth + 1] }}
                            </a>
                        </li>
                        <li>
                            <a class="btn-pagination" href="{{ route('events.agenda-mes', ['thisMonth' => $thisMonth])}}">
                                <i class="fa fa-angle-right fa-2x"></i>
                            </a>
                        </li>

                    @else

                        <li>
                            <a class="btn-pagination" href="{{ route('events.agenda-mes',
                            ['thisMonth' => $thisMonth, 'church_id' => $church_id])}}">
                                {{ $allMonths[$thisMonth + 1] }}
                            </a>
                        </li>
                        <li>
                            <a class="btn-pagination" href="{{ route('events.agenda-mes',
                            ['thisMonth' => $thisMonth, 'church_id' => $church_id])}}">
                                <i class="fa fa-angle-right fa-2x"></i>
                            </a>
                        </li>

                    @endif
                </ul>


                <div class="ano-calendario">
                    <p class="ano-calendario"><strong>{{ $ano }}</strong></p>
                </div>

            </div>

                <div class="portlet-body">
                <div class="row">


                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="color-head-table">
                            <tr>
                                <th class="adjust-th-table"> Segunda </th>
                                <th class="adjust-th-table"> Terça</th>
                                <th class="adjust-th-table"> Quarta </th>
                                <th class="adjust-th-table"> Quinta </th>
                                <th class="adjust-th-table"> Sexta </th>
                                <th class="adjust-th-table"> Sabado </th>
                                <th class="adjust-th-table"> Domingo </th>
                            </tr>
                            </thead>

                            <tbody>

                                <?php $i = 0; ?>
                                <?php $x = 0; ?>

                                @while($i < count($days))

                                    <tr class="">
                                        <!-- Segunda-Feira -->
                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @include('includes.calendar-days')

                                            </td>
                                            <!--FIM DO DIA -->

                                            @endif
                                        <?php $i++; ?>
                                        <?php $x = 0; ?>


                                    <!-- Terça-Feira -->
                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @include('includes.calendar-days')
                                            </td>
                                            <!--FIM DO DIA -->

                                        @endif
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>

                                    <!-- Quarta-Feira -->
                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @include('includes.calendar-days')
                                            </td>
                                            <!--FIM DO DIA -->

                                        @endif
                                        <?php $i++; ?>
                                        <?php $x = 0; ?>

                                    <!-- Quinta-Feira -->
                                    @if($i < count($days))
                                        <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @include('includes.calendar-days')
                                            </td>
                                            <!--FIM DO DIA -->

                                    @endif
                                    <?php $i++; ?>
                                    <?php $x = 0; ?>


                                    <!-- Sexta-Feira -->
                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @include('includes.calendar-days')
                                            </td>
                                            <!--FIM DO DIA -->

                                        @endif
                                        <?php $i++; ?>
                                        <?php $x = 0; ?>


                                    <!-- Sábado -->
                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @include('includes.calendar-days')
                                            </td>
                                            <!--FIM DO DIA -->

                                        @endif
                                        <?php $i++; ?>
                                        <?php $x = 0; ?>


                                    <!-- Domingo -->
                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @include('includes.calendar-days')
                                            </td>
                                            <!--FIM DO DIA -->

                                        @endif
                                        <?php $i++; ?>
                                        <?php $x = 0; ?>
                                </tr>
                                @endwhile
                            <!--
                            |
                            |FIM DA SEMANA
                            |
                            -->
                            </tbody>
                        </table>
                    </div>




                </div>
            </div>

        </div>
    </div>
</div>
