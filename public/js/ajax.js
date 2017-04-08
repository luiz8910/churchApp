

    function checkInEvent(id)
    {
        var request = $.ajax({
            url: '/events/checkInEvent/' + id,
            method: 'POST',
            data: id,
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                window.location.href = '/events/'+id+'/edit';
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


    }

    $("#recoverPassword").submit(function () {

        if(!$("#btnSend").attr('disabled'))
        {
            var email = $("#recoverEmail").val();
            var request = $.ajax({
                url: "/sendPassword/" + email,
                method: "POST",
                //data: email,
                dataType: "json"
            });

            request.done(function (e) {

                if(e.status)
                {
                    $("#emailSent").css("display", "block");
                }
                else{
                    $("#emailNotSent").css("display", "block");
                }
            });

            request.fail(function (e) {
                console.log("fail");
                console.log(e);
                $("#emailNotSent").css("display", "block");
            })
        }

        return false;
    });

    $("#recoverEmail").change(function () {
        console.log("email");

        if(validateEmail(this.value))
        {
            var request = $.ajax({
                url: "/emailTest/" + this.value,
                method: "GET",
                //data: this.value,
                dataType: "json"
            });

            request.done(function(e){
                if(e.status)
                {
                    $("#btnSend").attr("disabled", null);
                    $("#emailNotFound").css("display", "none");
                }
                else{
                    $("#emailNotFound").css("display", "block");
                    $("#btnSend").attr("disabled", true);
                }
            });

            request.fail(function (e) {
                console.log(e);
            })
        }
        else{
            alert("entre com um email válido");
        }
    });

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
