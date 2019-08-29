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

    $(".input-date").keypress(function (e) {

        if(e.which < 48 || e.which > 57)
        {
            return false;
        }

        var v = this.value;
        if (v.match(/^\d{2}$/) !== null) {
            this.value = v + '/';
        } else if (v.match(/^\d{2}\/\d{2}$/) !== null) {
            this.value = v + '/';
        }

    });

    $("#zipCode").keypress(function (e) {
        if(e.which < 48 || e.which > 57)
        {
            return false;
        }

    });

    $("#rg, .cpf").keypress(function (e) {
        if(e.which < 48 || e.which > 57){
            if(e.which != 88 && e.which != 120){
                return false;
            }
        }
    });


    $(".tel").maskbrphone({
        useDdd: true,
        useDddParenthesis: true,
        dddSeparator: ' ',
        numberSeparator:'-'
    });


    //called when key is pressed in input
    $(".time").keypress(function (e) {
        //if the letter is not digit don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

            return false;
        }else{

            if(this.value.length == 2)
            {
                this.value = this.value + ':';
            }
        }


    });

    $(".number").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 58)) {

            return false;
        }
    });

    $(".money").keypress(function (e) {

        if (e.which != 8 && e.which != 0 && e.which != 44 && (e.which < 48 || e.which > 58)) {

            return false;
        }

        if(e.which == 44)
        {

            var value = this.value;

            if(value.indexOf(',') != -1){
                return false;
            }
        }
    });

    $(".url").blur(function () {
        if(this.value.indexOf("http://") == -1)
        {
            this.value = "http://" + this.value;
        }

    });

    $('.string').keypress(function (e) {
        if((e.which > 32 && e.which < 65) || (e.which > 90 && e.which < 97) || e.which > 122)
        {

            console.log(e.which);

            return false;

        }
    });


    $(".check-model").click(function () {


        var n = $( ".check-model:checked" ).length;


        if(n > 0)
        {
            if($("#check-"+this.value).is(':checked'))
            {
                var input = "<input type='hidden' value='"+this.value+"' id='inputId-"+this.value+"' name='input[]'/>";

                $("#btn-delete-model").css('display', 'block');
                $("#modelToDel").append(input);
            }
            else{
                $("#inputId-"+this.value).remove();
            }

        }
        else{
            $("#inputId-"+this.value).remove();
            $("#btn-delete-model").css('display', 'none');
        }

    });

    $("#check-0").click(function () {
        if($("#check-0").is(':checked'))
        {
            $('.check-model').prop('checked', true);
        }
        else{
            $('.check-model').prop('checked', false);
            $("#btn-delete-model").css('display', 'none');
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

        var biweekly1 =
            '<div class="col-md-2" id="biweek1">'+
                '<div class="form-group">'+
                    '<label>Selecione o dia</label>'+
                    '<div class="input-icon input-icon-sm">'+
                        '<i class="fa fa-briefcase"></i>'+
                        '<select class="form-control" name="day[]" required>'+
                            '<option value="">Selecione</option>'+
                            '<option value="01">1</option>'+
                            '<option value="02">2</option>'+
                            '<option value="03">3</option>'+
                            '<option value="04">4</option>'+
                            '<option value="05">5</option>'+
                            '<option value="06">6</option>'+
                            '<option value="07">7</option>'+
                            '<option value="08">8</option>'+
                            '<option value="09">9</option>'+
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

        var biweekly2 =
            '<div class="col-md-2" id="biweek2">'+
                '<div class="form-group">'+
                    '<label>Selecione o dia</label>'+
                    '<div class="input-icon input-icon-sm">'+
                        '<i class="fa fa-briefcase"></i>'+
                        '<select class="form-control" name="day[]" required>'+
                            '<option value="">Selecione</option>'+
                            '<option value="01">1</option>'+
                            '<option value="02">2</option>'+
                            '<option value="03">3</option>'+
                            '<option value="04">4</option>'+
                            '<option value="05">5</option>'+
                            '<option value="06">6</option>'+
                            '<option value="07">7</option>'+
                            '<option value="08">8</option>'+
                            '<option value="09">9</option>'+
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

            $('#biweek1').remove();
            $('#biweek2').remove();

            $("#frequency")
                .addClass('col-md-3')
                .removeClass('col-md-6')
                .after(week);

        }
        else if(chosen == "Mensal"){
            $("#day").remove();

            $('#biweek1').remove();
            $('#biweek2').remove();

            $("#frequency")
                .addClass('col-md-3')
                .removeClass('col-md-6')
                .after(month);
        }
        else if(chosen == "Quinzenal")
        {
            $("#day").remove();


            $("#frequency")
                .addClass('col-md-2')
                .removeClass('col-md-6')
                .removeClass('col-md-3')
                .after(biweekly1);

            $("#frequency")
                .addClass('col-md-2')
                .removeClass('col-md-6')
                .removeClass('col-md-3')
                .after(biweekly2);
        }
        else{
            $("#day").remove();

            $('#biweek1').remove();
            $('#biweek2').remove();

            $("#frequency")
                .addClass('col-md-6')
                .removeClass('col-md-3')
                .removeClass('col-md-2')
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
    });



    $("#role_id").change(function () {
       if(this.value != 3)
       {
           $("#row-pass").css("display", "block");
           $("#h3-pass").css("display", "block");
           $("#password").attr('required');
           $("#confirm-password").attr('required');
       }
       else{
           $("#row-pass").css("display", "none");
           $("#h3-pass").css("display", "none");
           $("#password").attr('required', null);
           $("#confirm-password").attr('required', null);
       }
    });

    $("#password").keyup(function(){
        password(this.value, 'confirm-password');
    });

    $("#confirm-password").keyup(function () {
       password(this.value, 'password');
    });

    function password(password, id) {
        var pass = $("#"+id).val();

        if(pass != "" && pass != password)
        {
            $("#icon-password")
                .removeClass("font-blue")
                .addClass("font-red");

            $("#icon-success-password").css("display", "none");
            $("#icon-error-password").css("display", "block");
            $("#passDontMatch").css("display", "block");
            $("#passMatch").css("display", "none");
            $("#btn-submit").attr("disabled", true);
        }
        else if(pass == password){
            $("#icon-password")
                .removeClass("font-red")
                .addClass("font-blue");

            $("#icon-success-password").css("display", "block");
            $("#icon-error-password").css("display", "none");
            $("#passDontMatch").css("display", "none");
            $("#passMatch").css("display", "block");
            $("#btn-submit").attr("disabled", null);
        }
    }

     /*function setFocusResults() {
        $("#input-results").focus();
    }*/

     $("#check-parents").click(function () {

         if($("#check-parents").is(':checked'))
         {
            $(".parent").attr('hidden', null);
         }
         else{
            $(".parent").attr('hidden', true);
         }

     });

    $("td img").addClass("img-circle");

    $("#form").submit(function () {
        $("#btn-submit").css("display", "none");
        $(".progress").css("display", "block");
    });


    /*$("#changePicture").click(function () {
       $("#file").trigger("click");
    });

     $("#file").change(function () {
        $("#submit-img").trigger("click");
    });*/

    $("#file").change(function(){

        $("#btn-upload-img").attr('disabled', true);

        var interval = setInterval(function(){
            var img = $(".fileinput-preview > img")[0];

            if(img.naturalWidth)
            {
                if(img.naturalWidth > 800 || img.naturalHeight > 800)
                {
                    $("#removeImg").trigger('click');

                    $('#img-error')
                        .text('Envie uma imagem menor que 800x800')
                        .css('display', 'block');
                }

                else if(img.naturalWidth < 150 || img.naturalHeight < 150)
                {
                    $("#removeImg").trigger('click');

                    $('#img-error')
                        .text('Envie uma imagem maior que 150x150')
                        .css('display', 'block');
                }

                else{
                    $('#img-error').css('display', 'none');

                    $("#btn-upload-img").attr('disabled', null);
                }

                clearInterval(interval)
            }

            else{
                $("#btn-upload-img").attr('disabled', null);

            }

        }, 500);

    });

    $("#file_bg").change(function(){

        $("#btn-upload-img-bg").attr('disabled', true);

        var interval = setInterval(function(){
            var img = $(".fileinput-preview > img")[0];

            if(img.naturalWidth)
            {

                if(img.naturalWidth < 150 || img.naturalHeight < 150)
                {
                    $("#removeImg_bg").trigger('click');

                    $('#img-error-bg')
                        .text('Envie uma imagem maior que 150x150')
                        .css('display', 'block');
                }

                else{
                    $('#img-error-bg').css('display', 'none');

                    $("#btn-upload-img-bg").attr('disabled', null);
                }

                clearInterval(interval)
            }

            else{
                $("#btn-upload-img-bg").attr('disabled', null);

            }

        }, 500);

    });

    if(window.localStorage.getItem('edit') != null)
    {
        $("#delete-group-alert").css("display", "block");
        $("#message").append(window.localStorage.getItem('edit'));
        window.localStorage.removeItem('edit');
    }

    if (window.localStorage.getItem('qtde') != null)
    {
        var qtde = window.localStorage.getItem('qtde');

        swal("Sucesso!", qtde + " usuários foram cadastrados", "success");

        window.localStorage.removeItem('qtde');
    }

    if (window.localStorage.getItem('plan') != null)
    {
        swal("Sucesso!", "Upload realizado", "success");

        window.localStorage.removeItem('plan');
    }

    $(".select2-search__field").attr('placeholder', 'Selecione');
    $(".select2-selection__placeholder").text('Selecione');

    $(".select2-multiple .select2").select2({
        dropdownParent: $('#newSub')
    });

    $("#search-form").click(function(){

        $("#results").addClass('open');
    });



    /*$("#container-pagination").cleverInfiniteScroll({
        contentsWrapperSelector: "#container-pagination",
        contentSelector: ".feeds",
        nextSelector: "#next",
        loadImage: "ajax-loader.gif"
    })*/
});

function isString(input)
{
    if((input.which > 32 && input.which < 65) || (input.which > 90 && input.which < 97) || input.which > 122)
    {
        return false;
    }

    return true;

}

$(".modal").on("show.bs.modal", function (e) {
    var link = $(e.relatedTarget);
    if (link.attr("modal-remote") == 'true') {

        var $modal = $(this);
        var body = $(this).find(".modal-body");
        body.html('Carregando...');
        body.load(link.attr("href"), function () {
            if (link.data('modal-title')) {
                body.prepend('<h4 class="modal-title">' + link.data('modal-title') + '</h4>');
            }

            if (link.data('modal-class')) {
                $modal.addClass(link.data('modal-class'));
            }
            else {
                $modal.removeClass('modal-invert');
            }

            esconderLoader();
        });
    }
});



function excluir(obj) {
    var link = $(obj).attr('href');
    var id = $(obj).attr('data-id');

    swal({
        title: "Você tem certeza?",
        text: "Você não poderá mais recuperar este registro!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Sim, excluir",
        cancelButtonText: "Não, cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then(
        function () {
            $.ajax({
                url: link,
                data: {'id': id},
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    if (response == 1) {
                        swal({
                            title: "Deletado!",
                            text: "O registro foi excluído com sucesso.",
                            type: "success"
                        }).then(function () {
                            location.reload()
                        });
                    } else {
                        swal("Erro", "Ocorreu algum erro ao tentar excluir este registro, tente novamente.", "error");
                    }
                    ;
                },
                error: function (response) {
                    if (response == 1) {
                        swal({
                            title: "Deletado!",
                            text: "O registro foi excluído com sucesso.",
                            type: "success"
                        }).then(function () {
                            location.reload()
                        });
                    } else {
                        swal("Erro", "Ocorreu algum erro ao tentar excluir este registro, tente novamente.", "error");
                    }
                    ;
                }
            });
        }, function (dismiss) {
            // dismiss can be 'cancel', 'overlay', 'close', 'timer'
//            if (dismiss === 'cancel') {
//                swal(
//                    'Cancelled',
//                    'Your imaginary file is safe :)',
//                    'error'
//                );
//            }
        });

    return false;
}
