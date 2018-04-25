$(function(){

    $(".btn-ok").click(function(){

        var id = this.id.replace('btn-ok-', '');

        approveUser(id);
    });

    $('.btn-delete').click(function(){

        var id = this.id.replace('btn-delete-', '');

        var name = $.trim($('#name-' + id).text());

        var email = $.trim($('#email-' + id).text());

        deny(name, email, id);
    });

    $("#form-deny").submit(function(){

        $("#deny-submit").attr('disabled', true).text('Enviando...');

    });

    $(".btn-details").click(function(){

        var id = this.id.replace('btn-details-', '');

        denyDetails(id);

    });

});

function denyDetails(id)
{
    var url = '/deny-details/';

    request = $.ajax({
        url: url + id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function(e){
        if(e.status)
        {
            console.log(e.details);

            var name = $.trim($('#name-' + id).text());

            $("#denied-username").text(name);

            $("#denied-by").text(e.details.denied_by_person);

            $("#span-msg").text(e.details.msg);

            $("#modal-denied-details").modal('show');
        }
    });


    request.fail(function(e){
        console.log('fail');
        console.log(e);

    });





}

function deny(name, email, id)
{
    $("#username").text(name);

    $("#span-email").text(email);

    var form = $("#form-deny");

    var action = form.attr('action');

    action += '/' + id;

    form.attr('action', action);

    $("#modal-denied").modal('show');
}

function approveUser(id)
{

    swal({
            title: "Deseja Aprovar este usuário?",
            text: '',
            type: "info",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Sim, Aprovar!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function(isConfirm){
            if(isConfirm)
            {
                var url = '/approve-member/';

                Request(url, null, id, null, true);

                $("#tr-" + id).css('display', 'none');
            }

        });
}