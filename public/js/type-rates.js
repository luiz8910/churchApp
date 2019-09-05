$(function () {


    $(".btn-del").click(function () {

        var id = this.id.replace('btn-del-', '');

        swal({
            title: 'Atenção',
            text: 'Deseja excluir esta avaliação?',
            type: 'info',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sim, Excluir',
            confirmButtonClass: 'btn-danger',
            closeOnConfirm: true,
            closeOnCancel: true

        }, function (isConfirm) {

            if(isConfirm){
                deleteType(id);
            }
        })
    })
});

function deleteType(id)
{

    var url = '/session-delete-type-rate/';

    var method = "DELETE";

    var data = null;

    var static_page = false;

    var msg = 'O item foi excluído';

    Request(url, data, id, method, static_page, msg);
}
