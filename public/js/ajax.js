

    function checkIn(id)
    {
        var request = $.ajax({
            url: '/events/signUp/' + id,
            method: 'POST',
            data: id,
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                $("#alert-success").css('display', 'block');

                $("#i-checkIn").remove();

                $("#checkIn")
                    .text('')
                    .append('<i class="fa fa-check" id="i-checkIn"></i> Check-out');
                //$("#btn-unsub-"+id).css('display', 'block');
                //$("#btn-sub-"+id).css('display', 'none');
            }
            else{
                $("#alert-info").css('display', 'block');

                $("#i-checkIn").remove();

                $("#checkIn")
                    .text('')
                    .append('<i class="fa fa-check" id="i-checkIn"></i> Check-in');
                //$("#btn-unsub-"+id).css('display', 'none');
                //$("#btn-sub-"+id).css('display', 'block');
            }
        });

        request.fail(function (e) {
            $("#alert-danger").css('display', 'block');
            console.log(id);
            console.log(e);
        });

        return false;
    }
