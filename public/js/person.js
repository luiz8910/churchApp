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