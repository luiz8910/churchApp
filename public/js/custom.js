$(function(){

    $("#btn-search").change(function () {

        if(this.value.length > 2)
        {
            generalSearchInput(this.value);
        }
    });

    $(".btn-del-custom").click(function(){
        var id = this.id.replace('btn-del-custom-', "");

        var person_id = $("#person_id").val();

        sweetDelete(id, person_id);
    });

    $(".btn-download-custom").click(function(){
        var id = this.id.replace('btn-download-custom-', "");

        console.log('console');

        window.open('/redirect-download/' + id, '_blank');

    });

    $(".btn-active-custom").click(function () {
        var id = this.id.replace('btn-active-custom-', "");

        sweetActivate(id);
    });


    $("#list").click(function(){
       $("#modal_list").modal('show');
    });

    $("#upload-doc").click(function(){
       $("#upload").modal('show');
    });

    $("#btn-file").click(function(){

        $("#file").trigger('click');

    });

    $("#file").change(function () {

        var name = $(this).val().replace("C:\\fakepath\\", "");

        $("#file-name").text(name);
    })
});


function generalSearchInput(input)
{

    var table = $("#table").val();

    var route = location.pathname;

    var request = $.ajax({
        url: '/general-search/' + input + '/' + table,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {
        if (e.status) {

            console.log(e.data);

            var i = 0;

            var tr = '';

            //arr = [e.select[1]];

            while (i < e.data.length) {

                tr += '<tr>' +
                    '<td>' +
                    '<img src="' + e.data[i + 1] + '" class="imgProfile img-circle">' +
                    '</td>' +
                    '<td><a href="' + route + '_editar/' + e.data[i] + '">' + e.data[i + 2] + '</a></td>' +
                    '<td>' + e.data[i + 3] + '</td>' +
                    '<td>' + e.data[i + 4] + '</td>' +
                    '<td>' + e.data[i + 5] + '</td>' +
                    '<td>' +
                    '<button class="btn btn-danger btn-sm btn-circle" title="Deseja Excluir o Membro"' +
                    'onclick="sweetDeleteUser(' + e.data[i] + ')"' +
                    'id="btn-delete-' + e.data[i] + '">' +
                    '<i class="fa fa-trash"></i>' +
                    '<span class="hidden-xs hidden-sm"></span>' +
                    '</button>' +
                    '</td>' +
                    '</tr>';

                i = i + e.select.length;
            }

            $("#loading-results").css('display', 'none');

            $("thead").css('display', 'table-header-group');

            $("#tbody-search").removeClass('hide').append(tr);
        }
        else {
            $("#loading-results").css('display', 'none');
            $("#p-zero").css('display', 'block');
        }
    });

}


function sweetDelete(id, person_id) {

    var text = $("#text-delete").val() ? $("#text-delete").val() : "Deseja excluir o recurso selecionado?";

    swal({
            title: 'Atenção',
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {

            if (isConfirm) {
                deleteModel(id, person_id);


            }
        });
}

function deleteModel(id, person_id)
{
    var route = "/" + $("#table").val() + "/";

    var url = route + id;

    if(person_id)
    {
        url = route + id + "/" + person_id;
    }

    var request = $.ajax({
        url: url,
        method: 'DELETE',
        dataType: 'json'
    });

    request.done(function (e) {
        if(e.status)
        {
            $("#tr-" + id).css('display', 'none');

            swal('Sucesso', "O recurso selecionado foi excluído", "success");
        }
    });

    request.fail(function (e) {
        console.log("fail");
        console.log(e.status);

        swal('Atenção', "Um erro ocorreu, tente novamente mais tarde", 'error');
    });
}


function sweetActivate(id) {

    var text = "Deseja ativar o recurso selecionado?";

    swal({
            title: 'Atenção',
            text: text,
            type: 'info',
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {

            if (isConfirm) {
                activateModel(id);

            }
        });
}


function activateModel(id)
{
    var route = "/" + $("#table").val() + "-activate/";

    var url = route + id;

    var request = $.ajax({
        url: url,
        method: 'PUT',
        dataType: 'json'
    });

    request.done(function (e) {
        if(e.status)
        {
            $("#tr-" + id).css('display', 'none');

            swal('Sucesso', "O recurso selecionado foi ativado", "success");
        }
    });

    request.fail(function (e) {
        console.log("fail");
        console.log(e.status);

        swal('Atenção', "Um erro ocorreu, tente novamente mais tarde", 'error');
    });
}