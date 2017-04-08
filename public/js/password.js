

    var pass = $("#password");
    var confirm = $("#confirmPassword");
    var error = $("#error-pass");
    var success = $("#success-pass");


    pass.keyup(function () {

       if(this.value == confirm.val())
       {
           $("#btnSend").attr("disabled", null);
           error.css("display", "none");
           success.css("display", "block");
       }
       else{
           $("#btnSend").attr("disabled", true);
           error.css("display", "block");
           success.css("display", "none");
       }

    });


    confirm.keyup(function () {

        if(this.value == pass.val())
        {
            $("#btnSend").attr("disabled", null);
            error.css("display", "none");
            success.css("display", "block");
        }
        else{
            $("#btnSend").attr("disabled", true);
            error.css("display", "block");
            success.css("display", "none");
        }

    });


    $("body").keypress(function(e){
        if(e.which == 13)
        {
            if(!$("#btnSend").attr('disabled'))
            {
                if(pass.val().length > 5)
                {
                    $("#form").submit();
                }
            }
        }
    });
