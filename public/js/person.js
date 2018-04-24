$(function(){

    $(".btn-ok").click(function(){

        var id = this.id.replace('btn-ok-', '');

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
    });

});