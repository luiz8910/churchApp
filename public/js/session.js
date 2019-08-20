$(function(){

    //Usado para montar o modal de edição de sessão
    $(".btn-edit-session").click(function () {

        var id = this.id.replace('btn-edit-session-', '');

        var name = $("#td_name_" + id).text();

        var location = $("#td_location_" + id).text();

        var session_date = $("#session_date_" + id).val();

        var start_time = $("#short_start_time_" + id).val();

        var end_time = $("#end_time_" + id).val();

        var description = $("#description_" + id).val();

        var max_capacity = $("#max_capacity_" + id).val();

        $("#modal_name").val(name);

        $("#modal_location").val(location);

        $("#modal_session_date").val(session_date);

        $("#modal_start_time option[value|='"+start_time+"']").attr('selected', true);

        $("#modal_end_time option[value|='"+end_time+"']").attr('selected', true);

        $("#modal_description").val(description);

        if(max_capacity == -1)
        {
            max_capacity = '';
        }

        $("#modal_max_capacity").val(max_capacity);

        $("#session-id").val(id);


    });


    //Exibe o form de criação de nova sessão
    $('#btn-new-session').click(function () {

        $('#new-session').css('display', 'block');
    });

    //Limpa o form de criação de nova sessão
    $('#clear-fields').click(function(){

        $("#name").val('');
        $("#location").val('');
        $("#max_capacity").val('');
        $("#description").val('');
        $("#start_time").val('');
        $("#end_time").val('');
    });

    //Verifica se a o término da sessão é menor que o ínicio
    $("#end_time").change(function () {

        if(this.value != "")
        {
            verifyHours(this.value);
        }

    })

    $("#start_time").change(function () {

        var end_time = $("#end_time").val();

        if(this.value != "" && end_time != "")
        {
            verifyHours(end_time);
        }
    });

    $("#session_date").change(function () {

        verify_days();
    });

    $(".btn-delete-session").click(function () {

        var id = this.id.replace('btn-delete-session-', '');

        deleteSession(id);

    });

    $(".btn-deny").click(function () {

        var id = this.id.replace('btn-deny-', '');

        denyQuestion(id);
    });

    $('.btn-approve').click(function () {

        var id = this.id.replace('btn-approve-', '');

        approveQuestion(id);
    });


    $(".btn-itens").click(function () {

        var id = this.id.replace('btn-itens-', '');


        var request = $.ajax({
            url: '/getAnswers/' + id,
            method: 'GET',
            dataType: 'json'
        });

        $("#tbody-details tr").remove();

        request.done(function (e) {
            if(e.status)
            {
                var append = '';

                for (var i = 0; i < e.answers.length; i++)
                {
                    var percent = parseFloat(e.answers[i].count / e.count_itens);

                    percent *= 100;

                    append = ''+
                        '<tr>' +
                        '<td></td>'+
                        '<td>'+e.answers[i].text+'</td>'+
                        '<td>'+e.answers[i].count+'</td>'+
                        '<td>'+ percent.toFixed(2) +'%</td>'+
                        '</tr>';

                    $("#tbody-details").append(append);
                }

            }
        })
    });


});

function getSpeakers(id)
{
    var request = $.ajax({
        url: '/getSpeakers/' + id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {
        if(e.status)
        {
            speakers = array();

            for (var i = 0; i < e.speakers; i++)
            {

            }
        }
    })
}


function verifyHours(end_time)
{
    var start_time = $("#start_time").val();

    if(start_time == "")
    {
        $("#error-start-time").css('display', 'block');

        $("#btn-submit-session").attr('disabled', true);
    }
    else{

        var end = '';
        var start = '';

        if(end_time.charAt(0) == 0)
        {
            end = end_time.charAt(1) + end_time.charAt(3) + end_time.charAt(4);
        }
        else{
            end = end_time.charAt(0) + end_time.charAt(1) + end_time.charAt(3) + end_time.charAt(4);
        }

        if(start_time.charAt(0) == 0)
        {
            start = start_time.charAt(1) + start_time.charAt(3) + start_time.charAt(4);
        }
        else{
            start = start_time.charAt(0) + start_time.charAt(1) + start_time.charAt(3) + start_time.charAt(4);
        }


        if(parseInt(end) < parseInt(start))
        {

            $("#error-start-time").css('display', 'none');
            $("#error-end-time").css('display', 'block');
            $("#btn-submit-session").attr('disabled', true);
        }

        else{

            $("#btn-submit-session").attr('disabled', null);
            $("#error-start-time").css('display', 'none');
            $("#error-end-time").css('display', 'none');
        }

    }
}

function verify_days()
{
    var event_id = $("#event_id").val();

    var request = $.ajax({

        url: '/verify_days_session/' + event_id,
        method: 'GET',
        dataType: 'json'

    });


    request.done(function (e) {

        if(e.status)
        {
            console.log(e.days);
        }
    });

    request.fail(function (e) {

        console.log('fail');
        console.log(e);
    })
}

function deleteSession(id)
{
    swal({
        title: 'Atenção!',
        text: 'Deseja excluir esta sessão? (Todos os dados serão perdidos)',
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
            var url = '/session/';
            var msg = 'A sessão foi excluída com sucesso';

            if(Request(url, null, id, 'DELETE', false, msg))
            {
                $("#tr_" + id).remove();
            }
        }
    });
}

function approveQuestion(id)
{

    var url = '/approve-question/';

    var msg = 'A questão foi aprovada';

    Request(url, null, id, 'PUT', false, msg);
}

function denyQuestion(id)
{

    var url = '/deny-question/';

    var msg = 'A questão foi reprovada';

    Request(url, null, id, 'PUT', false, msg);
}

