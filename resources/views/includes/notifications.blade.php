<li class="dropdown dropdown-extended dropdown-notification dropdown-dark"
    id="header_notification_bar">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
       data-close-others="true">
        <i class="icon-bell"></i>
        <span class="badge badge-default" id="badge-notify">{{ $qtde = isset($qtde) && $qtde > 0 ? $qtde : '' }}</span>
        <input type="hidden" id="input-badge-count">
        <input type="hidden" id="created_person_id">

        <input type="hidden" id="input-event">
        <input type="hidden" id="created_event_id">

        <input type="hidden" id="notific8-title-pusher" value="Atenção">
        <input type="hidden" id="notific8-text-pusher">
        <input type="hidden" id="notific8-type-pusher" value="lime">

        <a href="javascript:;" class="btn btn-danger" id="notific8-pusher" style="display: none;"></a>
    </a>
    <ul class="dropdown-menu white-menu">
        <li class="external" >
            <h3 id="qtdeNotify" >
                Notificações

            </h3>
            <a href="javascript:;" onclick="markAllAsRead()" style="font-size: 10px; !important;">Marcar todas como lida</a>
        </li>
        <li>
            <ul class="dropdown-menu-list scroller" style="height: 250px;"
                data-handle-color="#637283" id="eventNotify">

                @if(isset($notify))
                    @foreach($notify as $n)
                        <li>
                            <a href='@if(isset($n["data"]["link"])) /{{ $n["data"]["link"] }} @endif' class="black-link">
                                <span class="time white-span">
                                    @if(\Carbon\Carbon::now()->diffInMinutes($n["created_at"]) > 60)
                                        @if(\Carbon\Carbon::now()->diffInHours($n["created_at"]) > 24)
                                            @if(\Carbon\Carbon::now()->diffInWeeks($n["created_at"]) > 7)
                                                há {{ \Carbon\Carbon::now()->diffInWeeks($n["created_at"]) }} Semanas
                                            @else
                                                há {{ \Carbon\Carbon::now()->diffInDays($n["created_at"]) }} Dias
                                            @endif
                                        @else
                                            há {{ \Carbon\Carbon::now()->diffInHours($n["created_at"])}} horas
                                        @endif
                                    @else
                                        @if(\Carbon\Carbon::now()->diffInMinutes($n["created_at"]) < 1)
                                            Agora
                                        @else
                                            há {{ \Carbon\Carbon::now()->diffInMinutes($n["created_at"])}} minutos
                                        @endif
                                    @endif
                                </span>
                                <span class="details">
                                    <span class="label label-sm label-icon label-success">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    {{ $n["data"]["id"] }}.
                                </span>
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </li>
    </ul>
</li>