$(function () {

   $(".btn-delete-feed").click(function () {
       var id = this.id.replace('btn-delete-feed-', '');

       delete_feed(id);
   });

});


function delete_feed(id)
{
    swal({
        title: 'Atenção!',
        text: 'Deseja excluir este feed?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Sim, Excluir',
        cancelButtonText: 'Cancelar',
        closeOnConfirm: true,
        closeOnCancel: true

    }, function (isConfirm) {

        if(isConfirm)
        {
            var url = '/delete-feed/';
            var msg = 'O feed foi excluído com sucesso';
            var data = null;
            var method = 'DELETE';
            var static_page = false;

            if(Request(url, data, id, method, static_page, msg))
            {
                $("#tr_" + id).remove();
            }
        }
    });
}
