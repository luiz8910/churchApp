<li class="dropdown dropdown-extended dropdown-notification dropdown-dark"
    id="header_notification_bar">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
       data-close-others="true">
        <i class="icon-bell"></i>
        <span class="badge badge-default" id="badge-notify"></span>
        <input type="hidden" id="input-badge-count">
        <input type="hidden" id="created_person_id">

        <input type="hidden" id="input-event">
        <input type="hidden" id="created_event_id">
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


                        <li>
                            <a href='' class="black-link">
                                <span class="time white-span">

                                </span>
                                <span class="details">
                                    <span class="label label-sm label-icon label-success">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                </span>
                            </a>
                        </li>
            </ul>
        </li>
    </ul>
</li>
