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

                $("#btn-dropzone").attr('disabled', true);
            }

        }else{

            $("#p-filename").text('Nome do Arquivo: ' + name);

            stop = false;

            $("#btn-dropzone").attr('disabled', null);
        }
    });

    $("#btn-dropzone").click(function(){

        $("#btn-submit-plan").trigger('click');
    });


    $("#btn-submit-plan").submit(function () {

        var name = $("#file_input")[0].files[0].name;

        /*setUploadStatus(name);

        var i = 0;

        var get = false;

        var repeat = setInterval(function () {
            get = getUploadStatus(name);

            if(get)
            {
                clearInterval(repeat);
                location.reload();
            }

        }, 3000);


        if(get)
        {
            location.reload();
        }*/
    });
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

readPlan();

function readPlan()
{
    var qtde = $("#qtde").val();

    if(qtde)
    {
        console.log(qtde);


    }
    else{

        console.log('session empty')

    }
}
