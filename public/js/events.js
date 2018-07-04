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


    $("#select_event_id_check").change(function () {

        if (this.value != "") {
            var value = this.value;

            $("#form-people-check").css('display', 'none');
            $("#div-loading-check").css('display', 'block');

            setTimeout(function () {
                showPeopleCheckIn(value);
                $("#form-people-check").css('display', 'block');
                $("#fieldset-check").css('display', 'block');
            }, 2000);

        }
        else {
            $("#form-people-check").css('display', 'none');
            $("#opt-group").append("");
            $("#submit-form-people-check").attr('disabled', true);
            $("#div-loading-check").css('display', 'none');
            $("#fieldset-check").css('display', 'none');
        }

    });


});





function showPeopleCheckIn(event) {

    var request = $.ajax({
        url: "/getCheckInListAjax/" + event,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {
        if (e.status) {

            //console.log(e.data);

            var option = '';
            var visitor = '';

            for (var i = 0; i < e.data.length; i++) {

                option += "<option value='" + e.data[i].id + "'>" + e.data[i].name + "</option>";

                /*if (e.data[i].church_id) {

                    option += "<option value='" + e.data[i].id + "'>" + e.data[i].name + " " + e.data[i].lastName + "</option>";
                }
                else {

                    visitor += "<option value='" + e.data[i].id + "-visit'>" + e.data[i].name + " " + e.data[i].lastName + "</option>";
                }*/


            }

            //console.log(option);

            $("#opt-group-check").append(option);
            //$("#opt-group-check-visitor").append(visitor);


            $("#div-loading-check").css('display', 'none');
            $("#form-people-check").css('display', 'block');
            $("#submit-form-people-check").attr('disabled', null);
            $("#fieldset-check").css('display', 'block');

        }
    });

    request.fail(function (e) {
        console.log("fail");
        console.log(e);

        $("#div-loading-check").css('display', 'none');

        $("#modalCheck-in").modal('hide');

        swal('Atenção', e.msg, 'error');
    })
}


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