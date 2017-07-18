<div class="row hidden-xs hidden-sm">
    <div class="col-md-12">
        <div class="portlet light portlet-fit calendar">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-calendar font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">Calendário
                        @if(!isset($next)) - Próximas {{ $numWeek }} semanas @endif
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
                    @if(Auth::user()->church_id)
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

                    @if(Auth::user()->church_id)
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
                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @while($x < count($allEvents))
                                                    @if($allEvents[$x]->eventDate == $days[$i])

                                                        <a href="{{ route('event.edit', ['event' => $allEvents[$x]->event_id]) }}">

                                                            <div class="evento-calendario {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                <strong class="{{ str_replace(" ", "-", $allEventsNames[$x]) }}">
                                                                    {{ $allEventsTimes[$x] }}h
                                                                </strong>

                                                                <div class="talk-bubble tri-right round btm-left bubble-margin" id="bubble-{{ $x }}">
                                                                    <div class="talktext">
                                                                        <p>
                                                                            <i class="fa fa-map-marker font-blue"></i>
                                                                            Local do Evento
                                                                            <br>
                                                                            {{ $allEventsAddresses[$x] }}
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <button onclick="event.preventDefault();" id="btn-options-{{ $x }}"
                                                                        class="btn btn-sm pull-right btn-options {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                </button>

                                                                <br>

                                                                {{ $allEventsNames[$x] }}
                                                            </div>
                                                        </a>

                                                    @endif

                                                    <?php $x++; ?>
                                                @endwhile
                                                {{--<a href="">
                                                    <div class="evento-calendario cor-2">
                                                        <strong>14:00h</strong><br>
                                                        Limpeza da igreja completa
                                                    </div>
                                                </a>
                                                <a href="">
                                                    <div class="evento-calendario cor-2">
                                                        <strong>14:00h</strong><br>
                                                        Limpeza da igreja completa
                                                    </div>
                                                </a>
                                                <a href="">
                                                    <div class="evento-calendario cor-2">
                                                        <strong>14:00h</strong><br>
                                                        Limpeza da igreja completa
                                                    </div>
                                                </a>
                                                <a href="">
                                                    <div class="evento-calendario cor-2">
                                                        <strong>14:00h</strong><br>
                                                        Limpeza da igreja completa
                                                    </div>
                                                </a>--}}

                                            </td>
                                            <!--FIM DO DIA -->

                                            @endif
                                        <?php $i++; ?>
                                        <?php $x = 0; ?>


                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @while($x < count($allEvents))
                                                    @if($allEvents[$x]->eventDate == $days[$i])

                                                        <a href="{{ route('event.edit', ['event' => $allEvents[$x]->event_id]) }}">

                                                            <div class="evento-calendario {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                <strong class="{{ str_replace(" ", "-", $allEventsNames[$x]) }}">
                                                                    {{ $allEventsTimes[$x] }}h
                                                                </strong>

                                                                <div class="talk-bubble tri-right round btm-left bubble-margin" id="bubble-{{ $x }}">
                                                                    <div class="talktext">
                                                                        <p>
                                                                            <i class="fa fa-map-marker font-blue"></i>
                                                                            Local do Evento
                                                                            <br>
                                                                            {{ $allEventsAddresses[$x] }}
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <button onclick="event.preventDefault();" id="btn-options-{{ $x }}"
                                                                        class="btn btn-sm pull-right btn-options {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                </button>

                                                                <br>

                                                                {{ $allEventsNames[$x] }}
                                                            </div>
                                                        </a>

                                                    @endif

                                                    <?php $x++; ?>
                                                @endwhile
                                            </td>
                                            <!--FIM DO DIA -->

                                        @endif
                                            <?php $i++; ?>
                                            <?php $x = 0; ?>

                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @while($x < count($allEvents))
                                                    @if($allEvents[$x]->eventDate == $days[$i])

                                                        <a href="{{ route('event.edit', ['event' => $allEvents[$x]->event_id]) }}">

                                                            <div class="evento-calendario {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                <strong class="{{ str_replace(" ", "-", $allEventsNames[$x]) }}">
                                                                    {{ $allEventsTimes[$x] }}h
                                                                </strong>

                                                                <div class="talk-bubble tri-right round btm-left bubble-margin" id="bubble-{{ $x }}">
                                                                    <div class="talktext">
                                                                        <p>
                                                                            <i class="fa fa-map-marker font-blue"></i>
                                                                            Local do Evento
                                                                            <br>
                                                                            {{ $allEventsAddresses[$x] }}
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <button onclick="event.preventDefault();" id="btn-options-{{ $x }}"
                                                                        class="btn btn-sm pull-right btn-options {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                </button>

                                                                <br>

                                                                {{ $allEventsNames[$x] }}
                                                            </div>
                                                        </a>

                                                    @endif

                                                    <?php $x++; ?>
                                                @endwhile
                                            </td>
                                            <!--FIM DO DIA -->

                                        @endif
                                        <?php $i++; ?>
                                        <?php $x = 0; ?>

                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @while($x < count($allEvents))
                                                    @if($allEvents[$x]->eventDate == $days[$i])

                                                        <a href="{{ route('event.edit', ['event' => $allEvents[$x]->event_id]) }}">

                                                            <div class="evento-calendario {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                <strong class="{{ str_replace(" ", "-", $allEventsNames[$x]) }}">
                                                                    {{ $allEventsTimes[$x] }}h
                                                                </strong>

                                                                <div class="talk-bubble tri-right round btm-left bubble-margin" id="bubble-{{ $x }}">
                                                                    <div class="talktext">
                                                                        <p>
                                                                            <i class="fa fa-map-marker font-blue"></i>
                                                                            Local do Evento
                                                                            <br>
                                                                            {{ $allEventsAddresses[$x] }}
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <button onclick="event.preventDefault();" id="btn-options-{{ $x }}"
                                                                        class="btn btn-sm pull-right btn-options {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                </button>

                                                                <br>

                                                                {{ $allEventsNames[$x] }}
                                                            </div>
                                                        </a>

                                                    @endif

                                                    <?php $x++; ?>
                                                @endwhile
                                            </td>
                                            <!--FIM DO DIA -->

                                        @endif
                                        <?php $i++; ?>
                                        <?php $x = 0; ?>


                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @while($x < count($allEvents))
                                                    @if($allEvents[$x]->eventDate == $days[$i])

                                                        <a href="{{ route('event.edit', ['event' => $allEvents[$x]->event_id]) }}">

                                                            <div class="evento-calendario {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                <strong class="{{ str_replace(" ", "-", $allEventsNames[$x]) }}">
                                                                    {{ $allEventsTimes[$x] }}h
                                                                </strong>

                                                                <div class="talk-bubble tri-right round btm-left bubble-margin" id="bubble-{{ $x }}">
                                                                    <div class="talktext">
                                                                        <p>
                                                                            <i class="fa fa-map-marker font-blue"></i>
                                                                            Local do Evento
                                                                            <br>
                                                                            {{ $allEventsAddresses[$x] }}
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <button onclick="event.preventDefault();" id="btn-options-{{ $x }}"
                                                                        class="btn btn-sm pull-right btn-options {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                </button>

                                                                <br>

                                                                {{ $allEventsNames[$x] }}
                                                            </div>
                                                        </a>

                                                    @endif

                                                    <?php $x++; ?>
                                                @endwhile
                                            </td>
                                            <!--FIM DO DIA -->

                                        @endif
                                        <?php $i++; ?>
                                        <?php $x = 0; ?>


                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @while($x < count($allEvents))
                                                    @if($allEvents[$x]->eventDate == $days[$i])

                                                        <a href="{{ route('event.edit', ['event' => $allEvents[$x]->event_id]) }}">

                                                            <div class="evento-calendario {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                <strong class="{{ str_replace(" ", "-", $allEventsNames[$x]) }}">
                                                                    {{ $allEventsTimes[$x] }}h
                                                                </strong>

                                                                <div class="talk-bubble tri-right round btm-left bubble-margin" id="bubble-{{ $x }}">
                                                                    <div class="talktext">
                                                                        <p>
                                                                            <i class="fa fa-map-marker font-blue"></i>
                                                                            Local do Evento
                                                                            <br>
                                                                            {{ $allEventsAddresses[$x] }}
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <button onclick="event.preventDefault();" id="btn-options-{{ $x }}"
                                                                        class="btn btn-sm pull-right btn-options {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                </button>

                                                                <br>

                                                                {{ $allEventsNames[$x] }}
                                                            </div>
                                                        </a>

                                                    @endif

                                                    <?php $x++; ?>
                                                @endwhile
                                            </td>
                                            <!--FIM DO DIA -->

                                        @endif
                                        <?php $i++; ?>
                                        <?php $x = 0; ?>


                                        @if($i < count($days))
                                            <!-- INICIO DO DIA -->
                                            <td @if(date("Y-m-d") == $days[$i]) class="today-back adjust-td-body-table" @endif class="adjust-td-body-table ">
                                                <p class="text-right p-dia-mes">
                                                    {{ substr($days[$i], 8) }}
                                                </p>

                                                @while($x < count($allEvents))
                                                    @if($allEvents[$x]->eventDate == $days[$i])

                                                        <a href="{{ route('event.edit', ['event' => $allEvents[$x]->event_id]) }}">

                                                            <div class="evento-calendario {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                <strong class="{{ str_replace(" ", "-", $allEventsNames[$x]) }}">
                                                                    {{ $allEventsTimes[$x] }}h
                                                                </strong>

                                                                <div class="talk-bubble tri-right round btm-right bubble-margin-right" id="bubble-{{ $x }}">
                                                                    <div class="talktext">
                                                                        <p>
                                                                            <i class="fa fa-map-marker font-blue"></i>
                                                                            Local do Evento
                                                                            <br>
                                                                            {{ $allEventsAddresses[$x] }}
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <button onclick="event.preventDefault();" id="btn-options-{{ $x }}"
                                                                        class="btn btn-sm pull-right btn-options {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}">
                                                                </button>

                                                                <br>

                                                                {{ $allEventsNames[$x] }}
                                                            </div>
                                                        </a>

                                                    @endif

                                                    <?php $x++; ?>
                                                @endwhile
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