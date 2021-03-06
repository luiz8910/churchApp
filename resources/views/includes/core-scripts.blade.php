<!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

<!-- END CORE PLUGINS -->
<script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>

<script src="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>

<script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

<script src="../assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/ui-confirmations.js" type="text/javascript"></script>

<script src="../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/pdfmake.min.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/vfs_fonts.js" type="text/javascript"></script>

<script src="../assets/global/plugins/jquery-notific8/jquery.notific8.min.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/ui-notific8.js" type="text/javascript"></script>


<!--<script src="../assets/pages/scripts/ui-toastr.js" type="text/javascript"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="../assets/layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
<script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

<script src="../assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/ui-sweetalert.min.js" type="text/javascript"></script>

<script src="../assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>

<script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>

<script src="../js/jquery.clever-infinite-scroll.js"></script>

<script src="../assets/global/plugins/sweetalert2/sweetalert2.min.js" type="text/javascript"></script>

<!-- END THEME LAYOUT SCRIPTS -->
<!-- JS Próprio -->
<script src="../js/script.js" type="text/javascript"></script>
<script src="../js/screen.js"></script>
<script src="../js/cep.js"></script>
<script src="../js/cpf.js"></script>
<script src="../js/maskbrphone.js"></script>
<script src="../js/ajax.js"></script>
<script src="../js/print.js"></script>
<script src="../js/agenda.js"></script>
<script src="../js/menu.js"></script>
<script src="../js/events.js"></script>
<script src="../js/session.js"></script>
<script src="../js/person.js"></script>
<script src="../js/regex.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.1.0"></script>


{{--<script>

        //instantiate a Pusher object with our Credential's key
        var pusher = new Pusher('9f86933032dbae833b7d', {

            encrypted: true
        });

        //Subscribe to the channel we specified in our Laravel Event
        var channel = pusher.subscribe('my-channel');
        var event = pusher.subscribe('new-event');

        //Bind a function to a Event (the full Laravel class)
        channel.bind('App\\Events\\PersonEvent', UserAdded);
        event.bind('App\\Events\\AgendaEvent', newEvent);

        badgeNotify = 0;

        function newEvent(data) {
            console.log(data);

            var li = '<li>' +
                    '<a href="events/'+data.event.id+'/edit">'+
                    '<span class="time">Agora</span>'+
                    '<span class="details">'+
                    '<span class="label label-sm label-icon label-success">'+
                    '<i class="fa fa-plus"></i>'+
                    '</span> '+data.event.name+'</span>'+
                    '</a>'+
                    '</li>';



            if($("#badge-notify").val() != "")
            {
                badgeNotify = parseInt($("#badge-notify").val());
            }

            badgeNotify++;

            $("#badge-notify").text(badgeNotify);

            $("#created_event_id").val(data.event.id);

            //$("#input-event").trigger("change");

            $("#notific8-text-pusher").val("O evento " + data.event.name + " acaba de ser criado");

            $("#notific8-pusher").trigger("click");

            $("#input-badge-count").text(badgeNotify);

            $("#qtdeNotify").text(badgeNotify + " Notificações");

            $("#eventNotify").prepend(li);

            console.log($("#badge-notify").text());
        }

        function UserAdded(data) {
            var li = '<li>' +
                    '<a href="person/'+data.person.id+'/edit">'+
                    '<span class="time">Agora</span>'+
                    '<span class="details">'+
                    '<span class="label label-sm label-icon label-success">'+
                    '<i class="fa fa-plus"></i>'+
                    '</span> Novo Usuário Registrado. </span>'+
                    '</a>'+
                    '</li>';



            if($("#badge-notify").val() != "")
            {
                badgeNotify = parseInt($("#badge-notify").val());
            }

            badgeNotify++;

            $("#badge-notify").text(badgeNotify);

            $("#created_person_id").val(data.person.id);

            $("#input-badge-count").text(badgeNotify).trigger("change");

            $("#qtdeNotify").text(badgeNotify + " Notificações");

            $("#eventNotify").prepend(li);

            $("#notific8-text-pusher").val("O usuário " + data.person.name + " acaba de ser criado");

            $("#notific8-pusher").trigger("click");

            console.log($("#badge-notify").text());
        }




</script>--}}
