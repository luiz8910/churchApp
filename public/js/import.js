$(function () {

    $(".dropfile").click(function () {

        $("#file_input").trigger('click');


    });


    $("#file_input").change(function(){

        var stop = true;

        var type = $("#file_input")[0].files[0].type;
        var name = $("#file_input")[0].files[0].name;

        var xls =  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        var csv = 'application/vnd.ms-excel';

        var dot = name.lastIndexOf('.');

        var slice = name.slice(dot);

        if(type != xls && type != csv)
        {

            if(slice != 'xls' && slice != 'xlsx' && slice != 'csv')
            {
                var text = 'Arquivos com a extensão ' + slice + ' não são permitidos';

                $("#error-msg").click(function () {
                    swal("Arquivo Inválido!", text, "info");
                }).trigger('click');
            }

        }else{
            $("#p-filename").text('Nome do Arquivo: ' + name);
            stop = false;
        }
    })
});

function setUploadStatus(name) {
    var request = $.ajax({
        url: '/setUploadStatus/' + name,
        method: 'GET',
        dataType: 'json',
        async: false
    });

    request.done(function (e) {
        console.log('setStatus');
    });

    request.fail(function (e) {
        console.log("fail");
        console.log(e);

        return false;
    });

    return true;
}

function getUploadStatus(name) {
    var request = $.ajax({
        url: '/getUploadStatus/' + name,
        method: 'GET',
        dataType: 'json',
        async: false
    });

    var status = false;

    request.done(function (e) {
        console.log('getStatus: ' + e.status);

        //Função para exibir quantidade cadastrada
        if (e.status) {
            window.localStorage.setItem('qtde', e.qtde);
        }

        status = e.status;

    });

    request.fail(function (e) {
        console.log("fail");
        console.log(e);
    });

    return status;

}
