
$(function () {

    $(".btn-edit-resp").click(function () {

        var id = this.id.replace('btn-edit-resp-', "");

        var form = $("#form-edit");

        var url = 'http://' + location.host;

        form.attr('action', url + '/responsible-update/' + id);

        getRespData(id);
    });

    $(".btn-delete-resp").click(function () {

        var id = this.id.replace('btn-delete-resp-', '');

        deleteResp(id);
    });


});


function getRespData(id)
{
    var request = $.ajax({
        url: 'get-resp-data/' + id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {
        if(e.status)
        {
            $("#abbreviation").val(e.abbreviation);

            $("#name").val(e.name);

            $("#special_role").val(e.special_role);

            $("#role_id").val(e.role_id);
        }
        else{

            swal('Atenção', 'Verifique sua conexão com a Internet', 'error');
        }
    });

    request.fail(function (e) {
        swal('Atenção', 'Verifique sua conexão com a Internet', 'error');
        console.log('fail');
        console.log(e);
    })
}

function deleteResp(id)
{
    var url = '/responsible-delete/';

    swal({
        title: 'Atenção',
        text: 'Deseja Excluir este responsável?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Sim, Excluir",
        cancelButtonText: "Não!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
        function (isConfirm) {
            if(isConfirm)
            {
                Request(url, null, id, 'DELETE', false);
            }
        })


}
