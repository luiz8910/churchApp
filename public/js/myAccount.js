

//id = church_id
function deleteChurch(id)
{
    swal({
            title: 'Atenção',
            text: 'Deseja excluir a Igreja selecionada?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Sim, Excluir",
            cancelButtonText: "Não",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {

                var url = '/delete-church/';

                Request(url, null, id, null, true);

                $('#tr-'+id).remove();

            }
        });
}