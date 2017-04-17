<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<script src="../../assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/horizontal-timeline/horizontal-timeline.js" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="../../assets/global/scripts/app.min.js" type="text/javascript"></script>

<script src="../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>

<script src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

<script src="../../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/pdfmake.min.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/vfs_fonts.js" type="text/javascript"></script>

<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="../../assets/layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
<script src="../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<!-- CSS Próprio -->
<script src="../../js/script.js" type="text/javascript"></script>
<script src="../../js/screen.js"></script>
<script src="../../js/cep.js"></script>
<script src="../../js/cpf.js"></script>
<script src="../../js/maskbrphone.js"></script>
<script src="../../js/ajax.js"></script>
<script src="../../js/print.js"></script>
<script src="https://js.pusher.com/4.0/pusher.min.js"></script>

<script>

    if($("#UserRole").val() == 1)
    {
        //instantiate a Pusher object with our Credential's key
        var pusher = new Pusher('9f86933032dbae833b7d', {

            encrypted: true
        });

        //Subscribe to the channel we specified in our Laravel Event
        var channel = pusher.subscribe('my-channel');

        //Bind a function to a Event (the full Laravel class)
        channel.bind('App\\Events\\PersonEvent', UserAdded);

        badgeNotify = 0;

        function UserAdded(data) {
            var li = '<li>' +
                    '<a href="person/'+data.person[0]+'/edit">'+
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

            $("#created_person_id").val(data.person[0]);

            $("#input-badge-count").text(badgeNotify).trigger("change");

            $("#qtdeNotify").text(badgeNotify + " Nova Notificação");

            $("#eventNotify").prepend(li);

            console.log($("#badge-notify").text());
        }
    }

</script>