$(function () {

    $(".btn-edit").click(function () {

        var id = this.id.replace('btn-edit-', '');

        editChurch(id);


    });

    $("#email").blur(function () {


        checkEmail(this.value);
    });

    $(".btn-activate").click(function () {

        var id = this.id.replace('btn-activate-', '');

        activateChurch(id)
    });

    $(".btn-full-activate").click(function () {

        var id = this.id.replace('btn-full-activate-', '');

        fullActivateChurch(id);
    });


    setRequiredFields();


    $("#password").keyup(function () {
        checkPass();
    });

    $("#password_conf").keyup(function () {
        checkPass();
    });

    $("#btn-submit-church").click(function () {

        if (errors.length > 0)
        {
            event.preventDefault();

            $("#span-error-submit").css('display', 'block');

            setTimeout(function () {
                $("#span-error-submit").css('display', 'none');
            }, 10000);
        }
    });

    $("#checkbox-pass").click(function () {

        var pass_input = $("#password");
        var pass_conf = $("#password_conf");


        if ($(this).is(':checked')) {
            var pass = randomPassword();

            pass_input.val(pass);

            pass_conf.val(pass);

            pass_input.attr('readonly', true);
            pass_input.attr('type', 'text');

            pass_conf.attr('readonly', true);
            pass_conf.attr('type', 'text');

            checkPass();
        }
        else {
            pass_input.val('');

            pass_conf.val('');

            pass_input.attr('readonly', false);

            pass_conf.attr('readonly', false);

            pass_input.attr('type', 'password');

            pass_conf.attr('type', 'password');

            checkPass();
        }

    });

    /*
     * Checar se as senhas combinam
     */
    function checkPass() {
        var pass = $("#password").val();
        var conf = $("#password_conf").val();

        var i_green = $(".icon-green");
        var i_red = $(".icon-red");

        var i_pass = $("#icon-success-pass");
        var i_pass_conf = $("#icon-success-pass-conf");


        if (pass != conf) {

            i_green.css('display', 'none');

            i_red.css('display', 'block');

            $("#form-password").addClass('has-error');

            $("#form-password-conf").addClass('has-error');

            i_pass.css('display', 'none');

            i_pass_conf.css('display', 'none');

            $("#btn-submit-church").attr('disabled', true);

        }

        else {

            if (pass.length > 5) {
                i_green.css('display', 'block');

                i_red.css('display', 'none');

                i_pass.css('display', 'block');

                i_pass_conf.css('display', 'block');

                $("#form-password").removeClass('has-error');

                $("#form-password-conf").removeClass('has-error');

                $("#btn-submit-church").attr('disabled', null);
            }

        }
    }

    function checkEmail(email)
    {

        var request = $.ajax({
            url : '/check-email/' + email,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {
            if(e.status)
            {

                var success = $("#icon-success-email");
                var error = $("#icon-error-email");
                var form = $("#form-email");
                var span = $("#span-error-email");
                var envelope = $("#envelope-success");
                var envelope_error = $("#envelope-error");
                var index = 0;

                if(e.email)
                {

                    error.css('display', 'block');
                    form.addClass('has-error');
                    success.css('display', 'none');
                    span.css('display', 'block');
                    envelope.css('display', 'none');
                    envelope_error.css('display', 'block');

                    if(errors.indexOf('email') != -1)
                    {
                        index = errors.indexOf('email');

                        errors.splice(index, 1);
                    }

                    errors.push('email');

                }
                else{
                    error.css('display', 'none');
                    form.removeClass('has-error');
                    success.css('display', 'block');
                    span.css('display', 'none');
                    envelope.css('display', 'block');
                    envelope_error.css('display', 'none');

                    index = errors.indexOf('email');

                    errors.splice(index, 1);
                }
            }
        });

        request.fail(function (e) {
            console.log('fail');
            console.log(e);
        })
    }
    


    /*
    * Gera um senha aleatória
     */
    function randomPassword() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 8; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

});

var errors = [];


function fullActivateChurch(id) {

    var url = '/full-activate-church/';

    swal({
            title: "Deseja Ativar esta igreja?",
            text: '',
            type: "info",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Sim, Ativar!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function (isConfirm) {
            if (isConfirm) {
                Request(url, null, id);
            }

        });
}


function activateChurch(id) {
    var url = '/activate-church/';

    swal({
            title: "Deseja Ativar esta igreja?",
            text: '',
            type: "info",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Sim, Ativar!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function (isConfirm) {
            if (isConfirm) {
                Request(url, null, id);
            }

        });


}

function clearFields() {
    $(".form-control").val("");
}

function closeForm() {
    clearFields();

    $("#new-church").css("display", "none");
}

function openForm() {
    $("#new-church").css("display", "block");

    $("#name").focus();

    $('html, body').animate({
        scrollTop: $("#new-church").offset().top
    }, 2000);
}

function setRequiredFields() {
    $("#street").attr('required', true);
    $("#number").attr('required', true);
    $("#city").attr('required', true);
    $("#state").attr('required', true);
}


function editChurch(id) {
    var url = '/edit-church/';

    var request = $.ajax({
        url: url + id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {

        if (e.status) {
            //Igreja

            console.log(e.church);

            var name = e.church.name;

            var alias = e.church.alias;

            var tel = e.church.tel;

            var cnpj = e.church.cnpj;

            var zipcode = e.church.zipCode;

            var street = e.church.street;

            var number = e.church.number;

            var neighborhood = e.church.neighborhood;

            var city = e.church.city;

            var state = e.church.state;

            $("#church_name").val(name);

            $("#church_alias").val(alias);

            $("#phone").val(tel);

            $("#cnpj").val(cnpj);

            $("#zipCode-2").val(zipcode);

            $("#street-2").val(street);

            $("#number-2").val(number);

            $("#neighborhood-2").val(neighborhood);

            $("#city-2").val(city);

            $("#state-2").val(state);

            //Responsável

            name = e.responsible.name;

            var lastName = e.responsible.lastName;

            var email = e.responsible.email;

            var cel = e.person.cel;

            var dateBirth = e.person.dateBirth;

            var cpf = e.person.cpf;

            var gender = e.person.gender;

            var marital_status = e.person.maritalStatus;

            var imgProfile = '';

            if (e.person.imgProfile.search('uploads') != -1) {
                imgProfile = '../../' + e.person.imgProfile;
            }
            else {
                imgProfile = e.person.imgProfile;
            }

            zipcode = e.person.zipCode;

            street = e.person.street;

            neighborhood = e.person.neighborhood;

            number = e.person.number;

            city = e.person.city;

            state = e.person.state;

            $("#name_resp").val(name).attr('disabled', true);

            $("#lastname_resp").val(lastName).attr('disabled', true);

            $("#email-resp").val(email);

            $("#cel").val(cel).attr('disabled', true);

            $("#dateBirth").val(dateBirth).attr('disabled', true);

            $("#cpf").val(cpf).attr('disabled', true);

            $("#gender").val(gender).attr('disabled', true);

            $("#maritalStatus").val(marital_status).attr('disabled', true);

            $("#img-resp").attr('src', imgProfile);

            $("#zipCode").val(zipcode).attr('disabled', true);

            $("#street").val(street).attr('disabled', true);

            $("#neighborhood").val(neighborhood).attr('disabled', true);

            $("#number").val(number).attr('disabled', true);

            $("#city").val(city).attr('disabled', true);

            $("#state").val(state).attr('disabled', true);

            $("#form-edit").attr('action', 'update-church/' + e.church.id);

            $("#edit-modal").modal('show');
        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);
    });

}