

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
                async: false,
                dataType: "json"
            });

            request.done(function (e) {
                console.log("done");
                console.log(e);

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
                var icon;

                if(e[i].lastName != undefined)
                {
                    model = "person";
                    icon = "user";
                }

                else if(e[i].eventDate != undefined)
                {
                    model = "events";
                    icon = "calendar";
                }

                else if(e[i].owner_id != undefined)
                {
                    model = "group";
                    icon = "users";
                }

                //console.log(model);

                var li =
                    '<li class="dropdown dropdown-extended dropdown-notification dropdown-dark">' +
                        '<a href="/'+model+'/'+e[i].id+'/edit" class="dropdown-toggle"'+
                        'data-close-others="true">'+
                        '<i class="fa fa-'+icon+' font-grey"></i>'+
                        e[i].name
                        +'</a>'+
                    '</li>';

                ul.append(li);
            }

        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        })
    }


    $("#search-input-mobile").keyup(function () {
        if(this.value != "")
        {
            $("#ul-results-mobile").css("display", "block");

            var request = $.ajax({
                url: "/search-events/" + this.value,
                method: "GET",
                dataType: "json"
            });

            request.done(function (e) {
                console.log("done");
                console.log(e);


                for(var i = 0; i < e.length; i++)
                {
                    if(i == 0)
                    {
                        $("#ul-results-mobile li").remove();
                    }

                    var li = '<li><a rel="external" href="events/'+e[i].id+'/edit">'+e[i].name+'</a></li>';

                    $("#ul-results-mobile").append(li);
                }


            });

            request.fail(function (e) {
                console.log("fail");
                console.log(e);
            })
        }
        else{
            $("#ul-results-mobile").css("display", "none");
            $("#ul-results-mobile li").remove();
        }

    }).focus(function () {
        var pos = $(this).offset();
        var top = $(window).scrollTop();

        if(top < 50)
        {
            window.scrollTo(0, pos.top);
        }
    });

    $("#search-input").keyup(function () {

        if(this.value != "")
        {
            $("#ul-results").css("display", "block");

            var request = $.ajax({
                url: "/search-events/" + this.value,
                method: "GET",
                dataType: "json"
            });

            request.done(function (e) {
                console.log("done");
                console.log(e);


                for(var i = 0; i < e.length; i++)
                {
                    if(i == 0)
                    {
                        $("#ul-results li").remove();
                    }

                    var li = '<li><a rel="external" href="events/'+e[i].id+'/edit">'+e[i].name+'</a></li>';

                    $("#ul-results").append(li);
                }


            });

            request.fail(function (e) {
                console.log("fail");
                console.log(e);
            })
        }
        else{
            $("#ul-results").css("display", "none");
            $("#ul-results li").remove();
        }
    });

    $("#email").change(function () {
        if(validateEmail(this.value))
        {
            var request = $.ajax({
                url: "/emailTest/" + this.value,
                method: "GET",
                //data: this.value,
                dataType: "json"
            });

            request.done(function(e){
                if(!e.status)
                {
                    validEmail();
                }
                else{
                    emailExists();
                }
            });

            request.fail(function (e) {
                console.log(e);
            })
        }else{
            invalidEmail();
        }
    });


    $("#email-edit").change(function () {

       if(validateEmail(this.value))
       {
           var request = $.ajax({
               url: "/emailTest-edit/" + this.value + "/" + $("#personId").val(),
               method: "GET",
               //data: this.value,
               dataType: "json"
           });

           request.done(function(e){
               if(e.status){
                   validEmail();
               }
               else{
                   emailExists();
               }
           });

           request.fail(function (e){
               console.log("fail");
               console.log(e);
           });

       }else{
           invalidEmail();
       }
    });

    function validEmail()
    {
        $("#form-email")
            .removeClass("has-error")
            .addClass("has-success");

        $("#icon-email")
            .removeClass("font-red")
            .addClass("font-blue");

        $("#icon-success-email").css("display", "block");
        $("#icon-error-email").css("display", "none");
        $("#emailExists").css("display", "none");
        $("#validEmail").css("display", "block");
        $("#invalidEmail").css("display", "none");
    }

    function emailExists()
    {
        $("#form-email")
            .removeClass("has-success")
            .addClass("has-error");

        $("#icon-email")
            .removeClass("font-blue")
            .addClass("font-red");


        $("#icon-success-email").css("display", "none");
        $("#icon-error-email").css("display", "block");
        $("#emailExists").css("display", "block");
        $("#validEmail").css("display", "none");
        $("#invalidEmail").css("display", "none");
    }

    function invalidEmail()
    {
        $("#form-email")
            .removeClass("has-success")
            .addClass("has-error");

        $("#icon-email")
            .removeClass("font-blue")
            .addClass("font-red");


        $("#icon-success-email").css("display", "none");
        $("#icon-error-email").css("display", "block");
        $("#emailExists").css("display", "none");
        $("#validEmail").css("display", "none");
        $("#invalidEmail").css("display", "block");
    }

