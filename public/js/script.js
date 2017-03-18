$(function () {

    member_id = '';
    member = '';
    members = [];


    $("#addMember").click(function () {

        member_id = $("#select_members").val();
        member = $("#select_members option:selected").text();

        if(members.length > 0){
            console.log(members.length);

            var result = true;

            for(var i = 0; i < members.length; i++)
            {
                if(members[i] == member_id)
                {
                    result = false;
                }
            }


            if(result){
                $("#table_name tbody").append("<tr id=tr-td-"+member_id+"></tr>");

                var $input = "<input hidden name=member-"+member_id+" id=memberInput-td-"+member_id+" value="+member_id+">";

                var tdDynamic = member;
                var tdId = "td-"+member_id;
                var $td = $("<td>", {
                    "id" : tdId
                }).html(tdDynamic).click(function () {
                    $("#tr-"+this.id).remove();
                    $("#memberInput-"+this.id).remove();
                    var index = members.indexOf(member_id);
                    members.splice(index, 1);
                });

                $("#tr-td-"+member_id).append($td);
                $("#hidden-input").append($input);
                members.push(member_id);
            }
        }

        else{
            $("#table_name tbody").append("<tr id=tr-td-"+member_id+"></tr>");

            var $input = "<input hidden name=member-"+member_id+" id=memberInput-td-"+member_id+" value="+member_id+">";

            var tdDynamic = member;
            var tdId = "td-"+member_id;
            var $td = $("<td>", {
                "id" : tdId
            }).html(tdDynamic).click(function () {
                $("#tr-"+this.id).remove();
                $("#memberInput-"+this.id).remove();
                var index = members.indexOf(member_id);
                members.splice(index, 1);
            });

            $("#tr-td-"+member_id).append($td);
            $("#hidden-input").append($input);
            members.push(member_id);
        }



    });

    $("#tr-td-"+member_id).find("td:first").trigger("click");



    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#img").attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

        }
    }



    $("#file-upload").change(function(){

        readURL(this);

        $("#table tbody").append('<tr>'+
            '<td>'+
            '<a href="#" class="fancybox-button" data-rel="fancybox-button">'+
            '<img class="img-responsive" src="#" name="img" id="img" style="width: 150px; height: 150px;"> </a>'+
            '<a href="javascript:;" class="btn btn-default btn-md" style="width: 150px;">'+
            '<i class="fa fa-times"></i> Remover </a>'+
            '</td>'+
            '</tr>');

    });
    
    $("#maritalStatus").change(function () {
        var status = $("#maritalStatus").val();

        if (status == 'Casado')
        {
            $("#form-partner").attr('hidden', false);
        }

        else
        {
            $("#form-partner").attr('hidden', true);
        }
    });


    $("#input-badge-count").change(function () {

        toastr.success("Clique aqui para ver Detalhes", "Novo Usuário Registrado", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            extendedTimeOut: 1000,
            onclick: function () {
                var id = parseInt($("#created_person_id").val());

                window.location.href = "/person/"+id+"/edit";
            }
        });

    });

    $("#input-event").change(function () {
        toastr.success("Clique aqui para ver Detalhes", "Novo Evento", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            extendedTimeOut: 1000,
            onclick: function () {
                var id = parseInt($("#created_event_id").val());

                window.location.href = "/events/"+id+"/edit";
            }
        });
    });

    //called when key is pressed in input
    $(".time").keypress(function (e) {
        //if the letter is not digit don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 58)) {

            return false;
        }
    });

    $(".check-event").click(function () {

        var n = $( ".check-event:checked" ).length;


        if(n > 0)
        {
            if($("#check-"+this.value).is(':checked'))
            {
                var input = "<input type='hidden' value='"+this.value+"' id='inputId-"+this.value+"' name='input[]'/>";

                $("#btn-delete-event").css('display', 'block');
                $("#eventToDel").append(input);
            }
            else{
                $("#inputId-"+this.value).remove();
            }

        }
        else{
            $("#inputId-"+this.value).remove();
            $("#btn-delete-event").css('display', 'none');
        }

    });

    $("#button-success").click(function () {
        $("#alert-success").css("display", "none");
    });

    $("#button-info").click(function () {
        $("#alert-info").css("display", "none");
    });

    $("#button-danger").click(function () {
        $("#alert-danger").css("display", "none");
    });


    $("#frequency").change(function () {

        var chosen = $("#select-frequency").val();

        var week =
            '<div class="col-md-3" id="day">'+
                '<div class="form-group">'+
                    '<label>Selecione o dia da semana</label>'+
                    '<div class="input-icon input-icon-sm">'+
                        '<i class="fa fa-briefcase"></i>'+
                        '<select class="form-control" name="day" required>'+
                            '<option value="">Selecione</option>'+
                            '<option value="Domingo">Domingo</option>'+
                            '<option value="Segunda-Feira">Segunda-Feira</option>'+
                            '<option value="Terça-Feira">Terça-Feira</option>'+
                            '<option value="Quarta-Feira">Quarta-Feira</option>'+
                            '<option value="Quinta-Feira">Quinta-Feira</option>'+
                            '<option value="Sexta-Feira">Sexta-Feira</option>'+
                            '<option value="Sábado">Sábado</option>'+
                        '</select>'+
                    '</div>'+
                '</div>'+
            '</div>';

        var month =
            '<div class="col-md-3" id="day">'+
                '<div class="form-group">'+
                    '<label>Selecione o dia</label>'+
                        '<div class="input-icon input-icon-sm">'+
                            '<i class="fa fa-briefcase"></i>'+
                            '<select class="form-control" name="day" required>'+
                                '<option value="">Selecione</option>'+
                                '<option value="1">1</option>'+
                                '<option value="2">2</option>'+
                                '<option value="3">3</option>'+
                                '<option value="4">4</option>'+
                                '<option value="5">5</option>'+
                                '<option value="6">6</option>'+
                                '<option value="7">7</option>'+
                                '<option value="8">8</option>'+
                                '<option value="9">9</option>'+
                                '<option value="10">10</option>'+
                                '<option value="11">11</option>'+
                                '<option value="12">12</option>'+
                                '<option value="13">13</option>'+
                                '<option value="14">14</option>'+
                                '<option value="15">15</option>'+
                                '<option value="16">16</option>'+
                                '<option value="17">17</option>'+
                                '<option value="18">18</option>'+
                                '<option value="19">19</option>'+
                                '<option value="20">20</option>'+
                                '<option value="21">21</option>'+
                                '<option value="22">22</option>'+
                                '<option value="23">23</option>'+
                                '<option value="24">24</option>'+
                                '<option value="25">25</option>'+
                                '<option value="26">26</option>'+
                                '<option value="27">27</option>'+
                                '<option value="28">28</option>'+
                                '<option value="29">29</option>'+
                                '<option value="30">30</option>'+
                                '<option value="31">31</option>'+
                            '</select>'+
                        '</div>'+
                '</div>'+
            '</div>';

        if(chosen == "Semanal")
        {
            $("#day").remove();

            $("#frequency")
                .addClass('col-md-3')
                .removeClass('col-md-6')
                .after(week);

        }
        else if(chosen == "Mensal"){
            $("#day").remove();

            $("#frequency")
                .addClass('col-md-3')
                .removeClass('col-md-6')
                .after(month);
        }
        else{
            $("#day").remove();

            $("#frequency")
                .addClass('col-md-6')
                .removeClass('col-md-3')
        }


    });

    function allDay()
    {
        if($("#allDay").is(":checked"))
        {
            var eventDate = $("#eventDate").val();

            if(eventDate)
            {
                $("#endEventDate").val(eventDate);
            }
        }
        else{
            $("#endEventDate").val("");
        }
    }

    $("#eventDate").change(function () {

        allDay();
    });

    $("#allDay").click(function () {

        allDay();
    })

});
