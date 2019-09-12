$(function(){

    opt = 2;

    row = 1;

    $("#addOption").click(function () {
        addOption();
    });

    $(".btn-del").click(function () {
        var id = this.id.replace('btn-del-', "");

        sweetDeletePoll(id);
    });

    $(".btn-del-item").click(function () {
        var id = this.id.replace('btn-del-item-', "");

        sweetDeleteItem(id);
    });

    $(".btn-clock").click(function () {
        console.log('clock');
        var id = this.id.replace('btn-clock-', "");

        sweetExpirePoll(id);
    });

    $(".btn-itens").click(function () {
        var id = this.id.replace('btn-itens-', "");


        view(id);
    })
});


function addOption()
{
    opt++;

    var div =
            '<div class="row append-row" id="row-'+opt+'">' +
            '<div class="col-md-11">' +
            '<label for="">Entre com a alternativa abaixo</label>'+
            '<div class="form-group"> ' +
            '<div class="input-group"> '+
            '<span class="input-group-addon"><i class="fa fa-dot-circle-o font-blue"></i> </span> '+
            '<input type="text" class="form-control" name="opt[]" placeholder="Ex: Sim, Não, talvez, tenho interesse">'+
            '</div>'+
            '</div>'+
            '</div>'+

            '<div class="col-md-1" style="margin-top: 25px;">' +
            '<a href="javascript:" class="btn btn-danger btn-circle" onclick="deleteOption('+opt+')">' +
            '<i class="fa fa-trash"></i>'+
            '</a> '+
            '</div>'+
            '</div>';

        $("#append").append(div);


}

function deleteOption(id)
{
    $("#row-"+id).remove();
}

function sweetDeletePoll(id)
{
    swal({
        title: 'Atenção',
        text: 'Deseja excluir a enquete selecionada?',
        type: 'error',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Excluir',
        cancelButtonText: 'Cancelar',
        closeOnCancel: true,
        closeOnConfirm: true
    }, function (isConfirm) {

        if(isConfirm){
            deletePoll(id);
        }
    })
}


function deletePoll(id)
{
    var request = $.ajax({
        url: '/delete-poll/' + id + '/' + $("#person_id").val(),
        method: 'DELETE',
        dataType: 'json'
    });

    request.done(function (e) {
        if(e.status)
        {
            swal('Sucesso', 'A enquete foi excluída com sucesso', 'success');

            location.reload();
        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);

        swal('Erro', 'Verifique o log', 'error');
    });
}

function sweetExpirePoll(id)
{
    swal({
        title: 'Atenção',
        text: 'Deseja encerrar a enquete?',
        type: 'info',
        showCancelButton: true,
        confirmButtonClass: 'btn-info',
        confirmButtonText: 'Encerrar',
        cancelButtonText: 'Cancelar',
        closeOnCancel: true,
        closeOnConfirm: true

    }, function (isConfirm) {

        if(isConfirm)
        {
            expirePoll(id);
        }
    })
}

function expirePoll(id)
{
    var request = $.ajax({
        url: '/expire-poll/' + id + '/' + $("#person_id").val(),
        method: 'PUT',
        dataType: 'json'
    });

    request.done(function (e) {
        if(e.status)
        {
            swal('Sucesso', 'A enquete foi encerrada', 'success');

            location.reload();
        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);

        swal('Erro', 'Verifique o console', 'error');
    })
}

function deleteItem(id)
{
    var request = $.ajax({
        url: '/delete-item-poll/' + id,
        method: 'DELETE',
        dataType: 'json'
    });

    request.done(function(e){
        if(e.status){

            swal('Sucesso', 'Você excluiu o item', 'success');

            deleteOption(id);
        }
    })
}

function sweetDeleteItem(id)
{
    swal({
        title: 'Atenção',
        text: 'Deseja excluir o item selecionado',
        type: 'error',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sim, Excluir',
        confirmButtonClass: 'btn-danger',
        closeOnConfirm: true,
        closeOnCancel: true

    }, function (isConfirm) {

        if(isConfirm){
            deleteItem(id);
        }
    })
}

function view(id)
{

    var request = $.ajax({
        url: '/view-poll/' + id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {

        $(".footer-itens h3").remove();
        $(".footer-itens br").remove();

        if(e.status)
        {
            $('.modal-p').css('font-size', '30px').text(e.content);

            var append = '';

            for (var i = 0; i < e.itens.length; i++)
            {
                append = '<h3>'+e.itens[i].description+'</h3><br>';

                $(".footer-itens").append(append);
            }


            $('#modal-padrao').modal('show');
        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);
    })
}
