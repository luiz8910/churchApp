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

        var request = $.ajax({
            url: '/check-in_manual/' + event_id + '/' + person,
            method: 'GET',
            dataType: 'json'

        });

        request.done(function(e){

            if(e.status)
            {
                location.reload();
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

    $(".btn-person-uncheck").click(function () {

        var event_id = $("#event-id").val();
        var person = this.id.replace('btn-person-uncheck-', '');

        var request = $.ajax({
            url: '/uncheck-in_manual/' + event_id + '/' + person,
            method: 'GET',
            dataType: 'json'

        });

        request.done(function(e){

            if(e.status)
            {
                location.reload();
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
});


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
