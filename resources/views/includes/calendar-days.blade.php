

        @while($x < count($allEvents))
            @if($allEvents[$x]->eventDate == $days[$i])

                <a href="{{ route('event.edit', ['event' => $allEvents[$x]->event_id]) }}">

                    <div class="evento-calendario {{ str_replace(" ", "-", $allEventsNames[$x]) }}
                    {{ str_replace(" ", "-", $allEventsFrequencies[$x]) }}" id="evento-calendario-{{ $allEvents[$x]->event_id }}">
                        <span style="color: white;">
                            {{ $allEventsTimes[$x] }}h
                        </span>


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

                <div class="dropdown-content" id="dropdown-content-{{ $allEvents[$x]->event_id }}" style="display: none;">


                    <a href="{{ route('event.edit', ['event' => $allEvents[$x]->event_id]) }}"
                       class="context-menu-p">
                        <p>
                            <i class="fa fa-info-circle font-blue"></i>
                            Detalhes
                        </p>

                    </a>

                    <a href="{{ route('event.subscriptions', ['event' => $allEvents[$x]->event_id]) }}"
                       class="context-menu-p">
                        <p>
                            <i class="fa fa-users font-blue"></i>
                            Inscrições
                        </p>
                    </a>

                    <a href="{{ route('sendqr.email.all', ['event' => $allEvents[$x]->event_id]) }}"
                       class="context-menu-p">
                        <p>
                            <i class="fa fa-envelope font-blue"></i>
                            Enviar Qr Por Email
                        </p>

                    </a>


                    <a href="javascript:" class="context-menu-p"
                       onclick='generateCertificateAll({!! $allEvents[$x]->event_id !!})'>
                        <p>
                            <i class="fa fa-file-pdf-o font-blue"></i>
                            Enviar Certificado Por Email
                        </p>

                    </a>

                    <hr>

                    <a href="javascript:;" class="context-menu-p delete-event"
                       id="delete-event-{{ $allEvents[$x]->event_id }}">
                        <p>
                            <i class="fa fa-ban font-red"></i>
                            Excluir Evento
                        </p>
                    </a>


                </div>

            @endif

            <?php $x++; ?>
        @endwhile
