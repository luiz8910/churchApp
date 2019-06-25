$(function(){

    $("#delete-all").click(function(){

        swal({
            title: 'Atenção',
            text: 'Deseja Excluir todos os inativos?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-primary",
            confirmButtonText: "Sim, Excluir todos",
            cancelButtonText: "Não",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {

                if(deleteAllInactives())
                {
                    swal("Sucesso!", "Todos os inativos foram excluidos", "success");

                    setTimeout(function(){
                        location.reload();
                    }, 2000);
                }



            }

        });
    });

    $('#user').keypress(function (e) {
        console.log(e);

        //findUserTransfer(input);
    })


    $(".new-password").click(function () {

        var id = this.id.replace('new-password-', '');

        var request = $.ajax({
            url: '/new-password/' + id,
            method: 'GET',
            dataType: 'json'

        });

        request.done(function(e){

            if(e.status)
            {
                swal("Sucesso!", "Uma nova senha foi gerada", "success");


                return true;
            }
            else{
                console.log(e.msg);

                swal("Atenção!", "Verifique o log", "error");
            }
        });

        request.fail(function (e) {
            console.log('fail');
            console.log(e);
        })
    });


    $(".btn-person-check").click(function () {

        var event_id = $("#event-id").val();
        var person = this.id.replace('btn-person-check-', '');


        check(event_id, person, false);
    });

    $(".btn-person-uncheck").click(function () {

        var event_id = $("#event-id").val();
        var person = this.id.replace('btn-person-uncheck-', '');

        uncheck(event_id, person, false);
    });

    $(".btn-whats").click(function () {

        var person_id = this.id.replace('btn-whats-', '');
        var event_id = $("#event-id").val();

        sendWhatsAppQR(event_id, person_id);
    })

    $(".btn-email").click(function(){

        var person_id = this.id.replace('btn-email-', '');
        var event_id = $("#event-id").val();

        sendEmailQR(event_id, person_id);
    })
});


function check(event_id, person_id, static_page)
{

    var request = $.ajax({
        url: '/check-in_manual/' + event_id + '/' + person_id,
        method: 'GET',
        dataType: 'json'

    });

    request.done(function(e){

        if(e.status)
        {
            if(!static_page)
            {
                swal('Sucesso', 'O check-in foi feito', 'success');

                setTimeout(function () {
                    location.reload();
                }, 1000);

            }


        }
        else{
            console.log(e.msg);

            swal("Atenção!", "Verifique o log", "error");
        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);
    })
}

function uncheck(event_id, person_id, static_page)
{
    var request = $.ajax({
        url: '/uncheck-in_manual/' + event_id + '/' + person_id,
        method: 'GET',
        dataType: 'json'

    });

    request.done(function(e){

        if(e.status)
        {
            if(!static_page)
            {
                swal('Atenção', 'O check-in foi retirado', 'warning');

                setTimeout(function () {
                    location.reload();
                }, 1000);
            }

        }
        else{
            console.log(e.msg);

            swal("Atenção!", "Verifique o log", "error");
        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);
    })
}

function sendWhatsAppQR(event_id, person_id)
{
    var request = $.ajax({
        url: '/whatsapp/' + event_id + '/' + person_id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {

        if(e.status)
        {
            $('#span-whatsapp-' + person_id).text('Enviado');
        }
        else{
            swal('Atenção', 'Não há celular ou telefone cadastrado para este usuário', 'error');
        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);
    })
}

function sendEmailQR(event_id, person_id)
{
    var request = $.ajax({
        url: '/email-qr/' + event_id + '/' + person_id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {

        if(e.status)
        {
            $('#span-email-' + person_id).text('Enviado');
        }
        else{
            swal('Atenção', 'Não há email cadastrado para este usuário', 'error');
        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);
    })
}

function deleteAllInactives()
{

    var request = $.ajax({
        url: '/delete-all-inactives',
        method: 'GET',
        dataType: 'json'

    });

    request.done(function(e){

        if(e.status)
        {
            return true;
        }
    });

    return false;

}

function findUserTransfer(input)
{
    console.log(input);
}
