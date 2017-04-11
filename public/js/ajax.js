

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


    $("#search-results").keyup(function () {

        if(this.value == ""){
            $(".ul-search").css("display", "none");
            $(".ul-search li").remove();
        }
        else{

            if(this.value.length > 2)
            {
                $(".ul-search").css("display", "block");
                search(this.value);
            }

        }

    });


    function search(text)
    {
        var request = $.ajax({
            url: "/search/" + text,
            method: "GET",
            dataType: "json"
        });

        request.done(function (e) {
            console.log("done");

            console.log(e);



            var ul = $(".ul-search");


            for(var i = 0; i < e.length; i++)
            {
                if(i == 0)
                {
                    $(".ul-search li").remove();
                }

                var model;

                if(e[i].lastName != undefined)
                {
                    model = "person";
                }

                else if(e[i].eventDate != undefined)
                {
                    model = "events";
                }

                else if(e[i].owner_id != undefined)
                {
                    model = "group";
                }

                console.log(model);

                var li =
                    '<li class="dropdown dropdown-extended dropdown-notification dropdown-dark">' +
                        '<a href="/'+model+'/'+e[i].id+'/edit" class="dropdown-toggle"'+
                        'data-close-others="true">'+
                        '<i class="fa fa-calendar font-grey"></i>'+
                        e[i].name
                        +'</a>'+
                    '</li>';

                ul.append(li);

                model = "";
            }

        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        })
    }