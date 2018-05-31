/**
 * Created by Luiz on 08/03/2017.
 */

$(function () {

    /*$.getJSON("js/events.json", function(json) {

        $("#agenda").fullCalendar({
            eventSources: [
                {
                    events: json
                }
            ]
        })
    });*/



    $("#submit-form-people-check").click(function () {
        var form = $("#form-people-check");

        form.submit();

        var event = $("#select_event_id_check").val();

        peopleCheckIn(form.serializeArray(), event);
    });



});



function peopleCheckIn(array, event) {

    var values = [];
    var request = '';

    if (array[0].name == 'check-all')
    {
        value = 0;

        request = $.ajax({
            url: '/checkInPeople/' + value + "/" + event,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {
            if (e.status) {
                $("#modalCheck-in").modal('hide');
                swal('Sucesso', e.qtde + ' usuários confirmaram presença', 'success');

                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
            else{
                $("#modalCheck-in").modal('hide');

                console.log(e.msg);

                swal("Atenção", "Um erro ocorreu", 'error');
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);

            $("#modalCheck-in").modal('hide');

            swal("Atenção", "Um erro ocorreu", 'error');
        });
    }
    else {
        for (var i = 0; i < array.length; i++) {
            values.push(array[i].value);
        }

        values = JSON.stringify(values);

        //console.log(array[0].name);
        request = $.ajax({
            url: '/checkInPeople/' + values + "/" + event,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {
            if (e.status) {
                $("#modalCheck-in").modal('hide');
                swal('Sucesso', array.length + ' usuários confirmaram presença', 'success');

                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);

            $("#modalCheck-in").modal('hide');

            swal("Atenção", "Um erro ocorreu", 'error');
        });
    }

}