var btn_forgot_pass = $("#btn-forgot-pass");
var square_pass = $("#square-recover-pass");
var square_login = $("#square-login");
var btn_back = $("#btn-back");
var btn_recover_pass = $("#btn-recover-pass");
var span = $("#span-email-error");
var form_group = $("#form-group-recover-pass");
var email_pass = $("#email-pass");
var icon_red = $(".icon-red");
var valid_email = $("#valid-email");

$(function(){

    btn_forgot_pass.click(function(){
        squarePass()
    });

    btn_back.click(function(){
        squareLogin()
    });

    email_pass.blur(function () {

        if(validateEmail(email_pass.val()))
        {
            valid_email.css('display', 'none');
            verifyEmail(email_pass.val());
        }
        else{
            valid_email.css('display', 'block');
            btn_recover_pass.attr('disabled', true);
        }
    });

});

function verifyEmail(email)
{
    var request = $.ajax({
        url : '/check-email/' + email,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function(e){

        if(e.status && e.email)
        {
            //Email existe
            span.css('display', 'none');

            form_group.removeClass('has-error');

            btn_recover_pass.attr('disabled', null);

            icon_red.css('display', 'none');
        }
        else if(e.status && !e.email)
        {
            //Email não existe
            span.css('display', 'block');

            form_group.addClass('has-error');

            btn_recover_pass.attr('disabled', true);

            icon_red.css('display', 'block');
        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);
    })
}


function squarePass()
{
    btn_forgot_pass.css('display', 'none');

    btn_back.css('display', 'block');

    square_login.css('display', 'none');

    square_pass.css('display', 'block');
}

function squareLogin()
{

    btn_forgot_pass.css('display', 'block');

    btn_back.css('display', 'none');

    square_login.css('display', 'block');

    square_pass.css('display', 'none');
}
