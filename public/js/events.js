
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

        //console.log(form.serializeArray());
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

    $(".btn-person").click(function () {

        var person = this.id.replace("btn-person-", "");

        var event = $("#event-id").val();

        swal({
            title: 'Atenção',
            text: 'Deseja Desinscrever este usuário?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Sim, Excluir",
            cancelButtonText: "Não",
            closeOnConfirm: true,
            closeOnCancel: true

        }, function (isConfirm) {
            if (isConfirm) {

                $("#progress-danger").css("display", "block");

                UnsubscribeUser(person, event);

                swal("Sucesso!", "O usuário foi desinscrito do evento", "success");

                location.reload();
            }

        });

    });


    $("#gen_public_url").click(function () {

        gen_public_url();

    });

    $("#name").change(function () {

        if(!$("#gen_public_url").is(':checked'))
        {
            if(location.pathname.search('edit') == -1)
            {

                $('#gen_public_url').trigger('click');
            }

        }
        else{
            if($("#name").val() == "")
            {
                $("#public_url").val('');
                $('#gen_public_url').trigger('click');
            }
            else{
                gen_public_url();
            }
        }


    });


    //Pesquisa de Inscritos
    $("#btn-search-check").click(function () {

        $("#div_search").css('display', 'block');

        $("#row_sub").css('display', 'none');

        $("#input-search-check").trigger('focus');
    });

    $("#close-search").click(function () {

        $("#div_search").css('display', 'none');

        $("#row_sub").css('display', 'block');

        $("#input-search-check").val('');

        $("#search_results").css('display', 'none');
    });

    $("#input-search-check")
        .keyup(function () {

            if(this.value == "")
            {
                $("#search_results").css('display', 'none');
            }

        })
        .keypress(function (e) {


            //Verifica se apenas letras foram digitadas
            if(isString(e))
            {
                var length_input_search = $("#input-search-check").val().length;

                if(length_input_search >= 2)
                {

                    findSubUsers(e);
                }
            }
            else{

                return false;
            }

    });
    //Fim Pesquisa Inscritos


    $("#generate-certicate-all").click(function () {

        var id = $("#event_id").val();
        
        generateCertificateAll(id);
    });

    $(".event-certificate").click(function () {

        var id = this.id.replace('event-certificate-', '');

        var person_id = $("#personId").val();

        generateCertificate(id, person_id);
    })

});

function generateCertificateAll(id)
{
    var request = $.ajax({
        method: 'GET',
        url: '/certified-hours/' + id,
        dataType: 'json'
    });

    request.done(function (e) {
        if(e.status)
        {
            var req = $.ajax({
                url: '/qtde-check/' + id,
                method: 'GET',
                dataType: 'json'
            });

            req.done(function (e) {

                if(e.status)
                {
                    if(e.count > 0)
                    {
                        var ajax = $.ajax({
                            url: '/generate-certificate/' + id,
                            method: 'GET',
                            dataType: 'json'
                        });

                        ajax.done(function (e) {
                            if(e.status)
                            {
                                location.reload();
                            }
                        });
                    }
                    else{

                        swal('Atenção', 'Este evento não tem nenhum participante', 'error');
                    }


                }
                else{
                    swal('Atenção', e.msg, 'error');
                }
            });
        }
        else{
            if(e.msg)
            {
                swal('Atenção', e.msg, 'error');
            }
            else{
                swal('Atenção', 'Insira a carga horária do evento', 'warning');
            }
        }

    });
}

function generateCertificate(id, person_id)
{
    var request = $.ajax({
        method: 'GET',
        url: '/certified-hours/' + id,
        dataType: 'json'
    });

    request.done(function (e) {
        if(e.status)
        {
            if(person_id) {
                var req = $.ajax({
                    url: '/is-check/' + id + '/' + person_id,
                    method: 'GET',
                    dataType: 'json'
                });

                req.done(function (e) {

                    if (e.status)
                    {
                        if (e.count > 0)
                        {
                            var ajax = $.ajax({
                                url: '/generate-certificate/' + id + '/' + person_id,
                                method: 'GET',
                                dataType: 'json'
                            });

                            ajax.done(function (e) {
                                if(e.status)
                                {
                                    location.reload();
                                }
                            });
                        }
                        else{
                            swal('Atenção', 'Esta pessoa não participou do evento', 'error');
                        }
                    }
                    else{

                        swal('Atenção', e.msg, 'error');
                    }
                })
            }

        }
        else{
            if(e.msg)
            {
                swal('Atenção', e.msg, 'error');
            }
            else{
                swal('Atenção', 'Insira a carga horária do evento', 'warning');
            }
        }
    })
}

function findSubUsers(e)
{

    var input = $("#input-search-check").val() + e.key;
    var event_id = $('#event-id').val();

    var request = $.ajax({
        url: '/findSubUsers/' + input + '/' + event_id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {

        if(e.status)
        {
            if(e.count > 0)
            {

                $("#search_results").css('display', 'block');

                var i = 0;
                var append = '';

                $("#tbody-search tr").remove();

                while (i < e.count)
                {

                    var button = '';

                    var lastName = e.person_sub[i].lastName ? e.person_sub[i].lastName : '';

                    if(e.person_sub[i].check == 0)
                    {
                        button = '<a href="javascript:;" class="btn btn-success btn-sm btn-circle"' +
                            'title="Fazer Check-in"' +
                            'onclick="check('+event_id+', '+e.person_sub[i].id+', false)">' +
                            '<i class="fa fa-check"></i> Check-in</a>';
                    }
                    else{
                        button = '<a href="javascript:;" class="btn btn-danger btn-sm btn-circle"' +
                            'title="Retirar Check-in"' +
                            'onclick="uncheck('+event_id+', '+e.person_sub[i].id+', false)">' +
                            '<i class="fa fa-close"></i> Retirar Check-in</a>';
                    }


                    append += '' +
                        '<tr id="tr-result">\n' +
                        '                                                            <td>\n' +
                        '                                                                <!-- Img Profile e Name -->\n' +
                        '\n' +
                        '                                                                <a href="/person/'+e.person_sub[i].id+'/edit"  style="margin-left: 10px;">\n' +
                        '\n' +
                        '\n' +
                        '                                                                    <img src="../../uploads/profile/noimage.png" class="img-circle" style="width: 50px; height: 50px;">\n' +
                        '\n' +
                        '                                                                    <span>'+e.person_sub[i].name + ' ' +lastName+'</span>\n' +
                        '                                                                </a>\n' +
                        '\n' +
                        '\n' +
                        '                                                            </td>\n' +
                        '\n' +
                        '                                                            <td>\n' +
                        '\n' +
                        '                                                                '+button+'\n' +
                        '\n' +
                        '\n' +
                        '                                                                <a href="javascript:;" class="btn btn-danger btn-sm btn-circle"\n' +
                        '                                                                   title="Excluir Pessoa?"\n' +
                        '                                                                   onclick="unsubUser('+event_id+', '+e.person_sub[i].id+')">\n' +
                        '                                                                    <i class="fa fa-trash"></i>\n' +
                        '                                                                    Excluir\n' +
                        '                                                                </a>\n' +
                        '                                                            </td>\n' +
                        '                                                        </tr>'

                    i++;

                }

                $("#tbody-search").append(append);
            }
            else{
                $("#search_results").css('display', 'none');
            }
        }
    });

    request.fail(function (e) {

        console.log('fail');
        console.log(e);
    })
}

function gen_public_url()
{
    var name = $("#name").val();
    var public_url = '';
    var org_name = $("#org_name").val();

    if($("#gen_public_url").is(':checked'))
    {

        if(name == "")
        {
            $("#public_url").val('');

            swal('Atenção', 'Preencha o campo nome primeiro', 'error');

            $("#gen_public_url").attr('checked', false);
        }
        else{

            var r_name = name.replace(/ /g, '-');

            var r_org = org_name.replace(' ', '-');

            public_url = r_name + '-' + r_org;

            $("#public_url").val(public_url.toLowerCase());
        }
    }
    else{
        $("#public_url").val('');
    }

}


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


        console.log(values);

        //values = JSON.stringify(values);



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

function unsubUser(event_id, person_id)
{
    swal({
        title: 'Atenção',
        text: 'Deseja Desinscrever este usuário?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Sim, Excluir",
        cancelButtonText: "Não",
        closeOnConfirm: true,
        closeOnCancel: true

    }, function (isConfirm) {
        if (isConfirm) {

            $("#progress-danger").css("display", "block");

            UnsubscribeUser(person_id, event_id);

            swal("Sucesso!", "O usuário foi desinscrito do evento", "success");

            location.reload();
        }

    });
}
