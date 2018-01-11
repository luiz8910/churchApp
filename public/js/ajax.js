

    $("#recoverPassword").submit(function (e) {
        sendPassword();

        e.stopImmediatePropagation();

        return false;
    });

    $(".btnSend").click(function (e) {

        if(!$(".btnSend").attr('disabled'))
        {
            sendPassword();
        }

        e.stopImmediatePropagation();

        return false;
    });

    /*
     * Recupera a senha pelo form de esqueceu a senha
     */
    function sendPassword()
    {
        var email = $("#recoverEmail").val();
        var request = $.ajax({
            url: "/sendPassword/" + email,
            method: "POST",
            //method: "GET",
            dataType: "json"
        });

        request.done(function (e) {
            console.log("done");
            console.log(e);

            if(e.status)
            {
                $("#emailSent").css("display", "block");
            }
            else{
                $("#emailNotSent").css("display", "block");
            }

        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
            $("#emailNotSent").css("display", "block");
        })
    }


    /*
     * Envia o link da senha pelo perfil do usuário
     * Somente para líderes
     */
    function sendPasswordUser()
    {
        $("#msg-spin").css("display", 'block');

        var person = $("#personId").val();

        var request = $.ajax({
            url: "/sendPassword/" + person,
            method: "GET",
            dataType: "json"
        });

        request.done(function (e) {
            if(e.status)
            {
                $("#notific8-title").val("Atenção");
                $("#notific8-text").val("Um email foi enviado para " + e.email);

                setTimeout(function() {
                    $("#msg-spin").css("display", "none");
                    $("#notific8").trigger("click");

                }, 1000);
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        });
    }


    /*
     * var id = id do evento
     * Usado para realizar check-in no evento
     * @param id
     */
    function checkInEvent(id, type)
    {
        var url = type == "visitor" ? '/events/checkInEventVisitor/' + id : '/events/checkInEvent/' + id;

        var request = $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json'
        });

        console.log(type);

        request.done(function(e){
            if(e.status)
            {
                //window.location.href = '/events/'+id+'/edit';
                /*$("#alert-success").css('display', 'block');

                $("#i-checkIn").remove();

                $("#checkIn")
                    .text('')
                    .append('<i class="fa fa-close" id="i-checkIn"></i> Check-out')
                    .removeClass('btn-success')
                    .addClass('btn-danger');*/

                location.reload();



                //$("#btn-unsub-"+id).css('display', 'block');
                //$("#btn-sub-"+id).css('display', 'none');
            }
            else{
                $("#alert-info").css('display', 'block');

                $("#i-checkIn").remove();

                $("#checkIn")
                    .text('')
                    .append('<i class="fa fa-check" id="i-checkIn"></i> Check-in');
                //$("#btn-unsub-"+id).css('display', 'none');
                //$("#btn-sub-"+id).css('display', 'block');
            }


        });

        request.fail(function (e) {
            $("#alert-danger").css('display', 'block');
            console.log(id);
            console.log(e);
        });


    }

    /*
    * @param id
    * Usado para realizar check-out no evento
    * id = id do evento
    * */
    function checkOut(id)
    {
        var request = $.ajax({
            url: '/events/checkOutEvent/' + id,
            method: 'POST',
            dataType: 'json'
        });

        request.done(function(e) {
            if (e.status)
            {
                location.reload();
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        })
    }


    $("#recoverEmail").keyup(function () {
        console.log(this.value);

        if(validateEmail(this.value))
        {
            $("#span-validEmail").css("display", "none");

            var request = $.ajax({
                url: "/emailTest/" + this.value,
                method: "GET",
                dataType: "json"
            });

            request.done(function(e){
                if(e.status)
                {
                    $("#btnSend").attr("disabled", null);
                    $("#emailNotFound").css("display", "none");
                }
                else{
                    $("#emailNotFound").css("display", "block");
                    $("#btnSend").attr("disabled", true);
                }
            });

            request.fail(function (e) {
                console.log(e);
            })
        }
        else{
            $("#span-validEmail").css("display", "block");
        }
    });

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }


    $("#search-results").keyup(function () {

        if(this.value == ""){
            $("#results").css("display", "none");
            $("#results li").remove();
        }
        else{

            if(this.value.length > 2)
            {
                $("#results").css("display", "block");
                search(this.value);
            }

        }

    }).focusout(function () {
        setTimeout(function () {
            $("#results").css("display", "none");
        }, 500);
    }).focus(function () {
        $("#results").css("display", "block");
    });



    function search(text)
    {
        var request = $.ajax({
            url: "/search/" + text,
            method: "GET",
            dataType: "json"
        });

        request.done(function (e) {

            console.log(e);

            var ul = $("#results");


            for(var i = 0; i < e.length; i++)
            {
                if(i == 0)
                {
                    $("#results li").remove();
                }

                var model, icon;

                if(e[i].lastName != undefined)
                {
                    model = "person";
                    icon = "user";
                }

                else if(e[i].eventDate != undefined)
                {
                    model = "events";
                    icon = "calendar";
                }

                else if(e[i].owner_id != undefined)
                {
                    model = "group";
                    icon = "users";
                }

                //console.log(model);

                var li =
                    '<li>' +
                        '<a href="/'+model+'/'+e[i].id+'/edit" class="drop-pesquisar-a">'+
                            '<i class="fa fa-'+icon+' drop-pesquisa-i fa-lg"></i>'+
                            e[i].name
                        +'</a>'+
                    '</li>';

                ul.append(li);
            }

        });

            /*<li class="">
                <a href="#" class="drop-pesquisar-a">
                <i class="icon-bar-chart drop-pesquisa-i fa-lg"></i>
                Grupo de Jovens

                </a>
            </li>*/

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        })
    }


    $("#search-input-mobile").keyup(function () {
        if(this.value != "")
        {
            $("#ul-results-mobile").css("display", "block");

            var request = $.ajax({
                url: "/search-events/" + this.value,
                method: "GET",
                dataType: "json"
            });

            request.done(function (e) {
                console.log("done");
                console.log(e);


                for(var i = 0; i < e.length; i++)
                {
                    if(i == 0)
                    {
                        $("#ul-results-mobile li").remove();
                    }

                    var li = '<li><a rel="external" href="events/'+e[i].id+'/edit">'+e[i].name+'</a></li>';

                    $("#ul-results-mobile").append(li);
                }


            });

            request.fail(function (e) {
                console.log("fail");
                console.log(e);
            })
        }
        else{
            $("#ul-results-mobile").css("display", "none");
            $("#ul-results-mobile li").remove();
        }

    }).focus(function () {
        var pos = $(this).offset();
        var top = $(window).scrollTop();

        if(top < 50)
        {
            window.scrollTo(0, pos.top);
        }
    });

    $("#search-input").keyup(function () {

        if(this.value != "")
        {
            $("#ul-results").css("display", "block");

            var request = $.ajax({
                url: "/search-events/" + this.value,
                method: "GET",
                dataType: "json"
            });

            request.done(function (e) {
                console.log("done");
                console.log(e);


                for(var i = 0; i < e.length; i++)
                {
                    if(i == 0)
                    {
                        $("#ul-results li").remove();
                    }

                    var li = '<li><a rel="external" href="events/'+e[i].id+'/edit">'+e[i].name+'</a></li>';

                    $("#ul-results").append(li);
                }


            });

            request.fail(function (e) {
                console.log("fail");
                console.log(e);
            })
        }
        else{
            $("#ul-results").css("display", "none");
            $("#ul-results li").remove();
        }
    });

    $("#email").change(function () {
        if(validateEmail(this.value))
        {
            var request = $.ajax({
                url: "/emailTest/" + this.value,
                method: "GET",
                //data: this.value,
                dataType: "json"
            });

            request.done(function(e){
                if(!e.status)
                {
                    validEmail();
                }
                else{
                    emailExists();
                }
            });

            request.fail(function (e) {
                console.log(e);
            })
        }else{
            invalidEmail();
        }
    });


    $("#email-edit").change(function () {

       if(validateEmail(this.value))
       {
           var request = $.ajax({
               url: "/emailTest-edit/" + this.value + "/" + $("#personId").val(),
               method: "GET",
               //data: this.value,
               dataType: "json"
           });

           request.done(function(e){
               if(e.status){
                   validEmail();
               }
               else{
                   emailExists();
               }
           });

           request.fail(function (e){
               console.log("fail");
               console.log(e);
           });

       }else{
           invalidEmail();
       }
    });

    function validEmail()
    {
        $("#form-email")
            .removeClass("has-error")
            .addClass("has-success");

        $("#icon-email")
            .removeClass("font-red")
            .addClass("font-blue");

        $("#icon-success-email").css("display", "block");
        $("#icon-error-email").css("display", "none");
        $("#emailExists").css("display", "none");
        $("#validEmail").css("display", "block");
        $("#invalidEmail").css("display", "none");
    }

    function emailExists()
    {
        $("#form-email")
            .removeClass("has-success")
            .addClass("has-error");

        $("#icon-email")
            .removeClass("font-blue")
            .addClass("font-red");


        $("#icon-success-email").css("display", "none");
        $("#icon-error-email").css("display", "block");
        $("#emailExists").css("display", "block");
        $("#validEmail").css("display", "none");
        $("#invalidEmail").css("display", "none");
    }

    function invalidEmail()
    {
        $("#form-email")
            .removeClass("has-success")
            .addClass("has-error");

        $("#icon-email")
            .removeClass("font-blue")
            .addClass("font-red");


        $("#icon-success-email").css("display", "none");
        $("#icon-error-email").css("display", "block");
        $("#emailExists").css("display", "none");
        $("#validEmail").css("display", "none");
        $("#invalidEmail").css("display", "block");
    }

    $("#father_id").change(function () {

        if($("#zipCode").val() == "")
        {
            automaticCep(this.value, 1);
        }

    });

    $("#mother_id").change(function () {

        if($("#zipCode").val() == "")
        {
            automaticCep(this.value, 1);
        }

    });

    $("#partner").change(function(){

        if($("#zipCode").val() == "")
        {
            automaticCep(this.value, 0);
        }
    });


    function automaticCep(id, user)
    {

        var request = $.ajax({
            url: '/automatic-cep/' + id + '/' + user,
            method: 'GET',
            dataType:'json'
        });

        request.done(function (e) {
            console.log("done");
            console.log(e);

            if(e.status)
            {
                $("#zipCode")
                    .val(e.cep)
                    .trigger('blur');

                $("#number").val(e.number);
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        });
    }

    function Delete(id, route, sweet)
    {
        var request = $.ajax({
            url: route+"-delete/" + id,
            method: "GET",
            dataType: 'json'
        });

        console.log(route);

        request.done(function (e) {
            console.log("done");
            console.log(e);
            if(e.status && sweet == null)
            {
                console.log("status: " + e.status);
                console.log("id: " + id);

                $("#notific8-title").val("Atenção");
                $("#notific8-text").val(e.name + " foi excluído");

                setTimeout(function() {
                    $("#progress-danger").css("display", "none");

                    //searchForEvent(e.name);

                    $("#tr-"+id).remove();

                    $("#notific8").trigger("click");

                    location.href = route;

                }, 1000);



            }

        });


        request.fail(function (e) {
            console.log("fail");
            console.log(e);

            //e.stopImmediatePropagation();
        });




        return false;
    }

    //Excluir o Evento Selecionado
    function searchForEvent(text)
    {
        var str = text.replace(/ /gi, "-");

        $("."+str).remove();

        /*var strong = $("strong").get();

        console.log('text: ' + str);
        for (var i = 0; i < label.length; i++)
        {

            if(strong[i].innerText == text)
            {
                console.log(strong[i].innerHTML);

                $("."+str).remove();

                strong[i].remove();
            }
        }*/
    }


    function leaveGroup(group, person)
    {
        var request = $.ajax({
            url: '/deleteMemberGroup/'+ group + '/' + person,
            method: 'GET',
            dataType:'json'
        });

        request.done(function (e) {
            console.log("done");
            console.log(e);

            if(e)
            {
                location.reload();
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        })
    }

    function detachTeen(id)
    {
        var parentId = $("#parentId").val();

        var request = $.ajax({
            url: '/teen-detach/' + id + '/' + parentId,
            method: "GET",
            dataType: "json"
        });

        request.done(function (e) {
           if(e){
               location.reload();
           }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        });
    }


    $("#input-join-new-people").keyup(function(){

        if(this.value != "")
        {
            if(this.value.length > 2)
            {
                var input = this.value;

                console.log('input: ' + this.value);

                var request = $.ajax({
                    url: '/join-new-people/' + input,
                    method: "GET",
                    dataType: "json"
                });

                request.done(function(e){
                    console.log("done");
                    console.log(e);

                    if(e.status)
                    {
                        $("#table-results").css('display', 'none');
                        $(".lblRegistered").css('display', 'none');
                        $("#tbody-create-modal tr td").remove();
                        appendModalTable(e.data);
                    }
                });

                request.fail(function(e){
                    console.log("fail");
                    console.log(e);
                });
            }

        }
        else{
            $("#foundResults").css('display', 'none');
            $("#table-results").css('display', 'none');
            $(".lblRegistered").css('display', 'none');
            $("#tbody-create-modal tr td").remove();
        }

    });

    function appendModalTable(data)
    {
        var table =
            '<td><img src="../../'+data[0]+'" class="img-circle small-img" </td>'+
            '<td>'+data[1]+'</td>'+
            '<td>'+
                '<a href="javascript:;" onclick="addUserToGroup('+data[2]+')" class="btn btn-success btn-xs btn-circle">'+
                    '<i class="fa fa-plus"></i>'+
                '</a>'+
            '</td>';


        $("#foundResults").css('display', 'block');


        $("#table-results").css('display', 'block');


        $("#tbody-create-modal tr").append(table);

    }

    /*
     * Adiciona o Usuário ao grupo
     *
     * */

    function addUserToGroup(personId)
    {
        var group = $("#groupId").val();

        var request = $.ajax({
            url:'/addUserToGroup/' + personId + '/' + group,
            method: 'GET',
            dataType: "json"
        });

        request.done(function (e) {
            console.log("done");
            console.log(e);

            if(e.status)
            {
                location.reload();
            }
            else{
                $(".lblRegistered").css('display', 'block');
            }

        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        });
    }

    function checkCPF(cpf)
    {
        var request = $.ajax({
            url: '/check-cpf/' + cpf,
            method: 'GET',
            dataType: 'json'
        });

        var route = location.pathname;

        console.log('route: ' + route);

        $("#textResponse label")
            .css('display', 'none').remove();

        request.done(function(e){
            console.log("done");
            console.log(e);

            $("#textResponse").css('display', 'block');


            if(e.status){
                if(e.type == "person" && e.data == 0){
                    $("#textResponse")
                        .append('<label><strong>Erro!</strong> Este CPF está em uso em outra igreja</label>')
                }
                else if(e.type == "person" && e.data != 0){
                    if(route == "/myAccount")
                    {
                        console.log("id: " + e.data.id);
                        console.log("user: " + $("#userId").val());

                        if(e.data.id != $("#userId").val())
                        {
                            $("#textResponse")
                                .append('<label><strong>Erro!</strong> Este CPF pertence ao usuário ' +e.data.name+' '+e.data.lastName+' </label>')
                        }
                    }
                    else if(route.search('edit') != - 1){
                        if(e.data.id != $("#personId").val()){
                            $("#textResponse")
                                .append('<label><strong>Erro!</strong> Este CPF pertence ao usuário ' +e.data.name+' '+e.data.lastName+' </label>')
                        }
                    }
                    else{
                        $("#textResponse")
                            .append('<label><strong>Erro!</strong> Este CPF pertence ao usuário ' +e.data.name+' '+e.data.lastName+' </label>')
                    }

                }
                else{
                    $("#textResponse")
                        .append('<label>Este CPF pertence ao visitante ' +e.data.name+' '+e.data.lastName+' </label>')
                }
            }
        });

        request.fail(function(e){
            console.log("fail");
            console.log(e);
        })
    }


    function getPusherKey()
    {
        var request = $.ajax({
            url: "/getPusherKey",
            method: "GET",
            dataType: "json"
        });

        request.done(function (e) {

            return e;
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        });
    }

    /*
    * Marcar todas as notificações do usuário logado como lidas
    * */
    function markAllAsRead()
    {
        var request = $.ajax({
            url: "/markAllAsRead",
            method: "GET",
            dataType: "json"
        });

        request.done(function(e){
            console.log("done");
            console.log(e);

            if(e.status)
            {
                $(".dropdown-menu-list > li").addClass("read-message");
                $("#badge-notify").text('');
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        });
    }

    $("#showGroupEvents").click(function () {
        $("#icon-loading").css('display', 'block');
        showGroupEvents();
    });

    /*
     * Exibe todos os eventos relacionado ao grupo
    *
    */
    function showGroupEvents()
    {
        var group = $("#groupId").val();

        var request = $.ajax({
            url: '/showGroupEvents/' + group,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {
            var events = '';

            if(e.status)
            {
                for(var i = 0; i < e.data.length; i++)
                {
                    events += '<div style="margin-left: 30px; margin-bottom: 10px;">'+
                        '<i class="fa fa-eye"></i> '+
                            '<a href="/events/'+e.data[i].id+'/edit">'+ e.data[i].name +' </a>'+
                        '</div>';
                }

                //a href="/events/6/edit"

                setTimeout(function () {
                    $("#icon-loading").css('display', 'none');
                    $("#div-showGroupEvents").append(events);
                }, 2000);

            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
            $("#icon-loading").css('display', 'none');
        });
    }

    $("#addNote").click(function(){
        $("#div-note span").html("");
        $("#p-note").css("display", "block");
        $("#icon-loading-note").css("display", "block");
        $("#modal-note").modal('hide');
        addNote();
    });


    function addNote()
    {
        var group = $("#groupId").val(),
            notes = $("#note").val();

        var request = $.ajax({
            url: '/addNote/' + group + '/' + notes,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function(e){
           if(e.status)
           {
               setTimeout(function () {
                   $("#icon-loading-note").css("display", "none");
                   $("#div-note").css("display", "block");
                   $("#div-note span").append(notes);
                   $("#notific8-text").val('Nota Adicionada');
                   $("#notific8").trigger('click');
               }, 2000)
           }

        });

        request.done(function (e) {
            console.log("fail");
            console.log(e);
        });
    }

    /*
     * Usado para procurar eventos/grupos
     * de um usuário prestes a ser excluído
     * id = id do usuário (person_id)
     */
    function findUserAction(id)
    {
        var request = $.ajax({
            url: '/findUserAction/' + id,
            method: 'GET',
            dataType: 'json',
            async: false
        });

        var records = new Array();
        var status = "";
        var fail = false;

        request.done(function (e, textStatus) {

            if(e.status)
            {

                for (i = 0; i < e.groups.length; i++)
                {
                    records.push(e.groups[i].name);
                }

                for(i = 0; i < e.events.length; i++)
                {
                    records.push(e.events[i].name);
                }

                console.log("records: " + records);

            }

            status = records.length > 0 ? null : textStatus;
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);

            fail = true;
        });

        return records.length == 0 && status == "success" ? "success" : fail ? false : records;

    }

    function sweetDeleteUser(id, name)
    {

        var text = '';
        var msg = '';

        if(name == undefined)
        {
            text = "Deseja excluir o usuário selecionado ?";
            msg = "O Usuário selecionado foi excluído";
            name = null;
        }
        else{
            text = "Deseja excluir o usuário " + name + "?";
            msg = "O Usuário " + name + " foi excluído";

        }
        swal({
            title: "Você tem certeza?",
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Sim, Excluir!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
            function(){

                var find = findUserAction(id);
                console.log(find);

                if(find == "success")
                {
                    verifyMaritalStatus(id);
                    Delete(id, "/person", true);
                    swal("Sucesso!", msg, "success");

                    setTimeout(function () {
                        location.href = '/person';
                    }, 3000);
                }
                else if(find === false)
                {
                    swal("Atenção!", "Sua requisição não foi processada, verifique sua conexão", "error");
                }
                else{
                    verifyMaritalStatus(id);
                    var data = find.toString();
                    sweetConfirmations(null, data, null, name, id);
                    //Delete(id, "/person");
                }


            });
    }

    function sweetConfirmations(title, data, type, name, id)
    {

        var title = title ? title : "Você tem certeza?";
        var type = type ? type : "warning";
        var text = "O usuário possui os seguintes grupos/eventos: " + data;
        var msg1 = '';
        var msg2 = '';

        if(name)
        {
            msg1 = "O usuário " + name + " e os eventos foram excluídos com sucesso";
            msg2 = "O usuário " + name + " foi excluído, e os eventos/grupos foram transferidos para ";
        }
        else{
            msg1 = "O usuário selecionado e os eventos foram excluídos com sucesso";
            msg2 = "O usuário selecionado foi excluído, e os eventos/grupos foram transferidos para ";
        }

        swal({
            title: title,
            text: text,
            type: type,
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Sim, Excluir todos",
            cancelButtonText: "Não, manter todos os eventos/grupos!",
            closeOnConfirm: false,
            closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    deleteActions(id);
                    Delete(id, "/person", true);
                    swal("Sucesso!", msg1, "success");

                    setTimeout(function () {
                        location.href = '/person';
                    }, 3000);
                } else {
                    var keep = keepActions(id);
                    console.log(keep);
                    Delete(id, "/person", true);

                    swal("Atenção",  msg2 +
                        "o usuário " + keep, "info");

                    setTimeout(function () {
                        location.href = '/person';
                    }, 3000);
                }
            });
    }

    $(".deleteUser").click(function(){
        var str = this.id;

        var id = str.replace("btn-delete-", "");

        var name = $("#name").val();

        sweetDeleteUser(id, name);
    });

    function dataChart()
    {
        var group = $("#groupId").val();

        var request = $.ajax({
            url:"/getChartData/" + group,
            method: "GET",
            dataType:'json',
            async: false
        });

        request.done(function(e){

            if(e.status)
            {
                return simpleChart(e.data);
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        })
    }

    $(".group-delete").click(function(){
        var text = "Excluindo...";

        $(".group-delete").html(text).attr("disabled", true);

        var str = this.id;

        var id = str.replace("btn-delete-", "");

        deleteGroup(id);
    });

    $(".event-delete").click(function(){
        var text = "Excluindo...";

        $(".event-delete").html(text).attr("disabled", true);

        var str = this.id;

        var id = str.replace("btn-delete-", "");

        deleteEvent(id);
    });

    function deleteGroup(id)
    {
        var route = location.pathname;

        var text = false;

        if(route.search("edit") != -1)
        {
            text = true;
        }

        var request = $.ajax({
            url: "/group/" + id,
            method: "GET",
            dataType: "json"
        });

        request.done(function (e) {

            if(e.status)
            {
                if(text)
                {
                    localStorage.setItem('edit', 'O grupo ' + e.name + ' foi excluido');
                    location.href = '/group';
                }
                else{
                    $("#notific8-title").val("Atenção");
                    $("#notific8-text").val(e.name + " foi excluído");

                    setTimeout(function() {
                        $("#progress-danger").css("display", "none");

                        $("#tr-"+id).remove();

                        $("#notific8").trigger("click");

                    }, 1000);
                }
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        });


    }

    function deleteEvent(id)
    {
        var route = location.pathname;

        var text = false;

        if(route.search("edit") != -1)
        {
            text = true;
        }

        var request = $.ajax({
            url: "/events-delete/" + id,
            method: "GET",
            dataType: "json"
        });

        request.done(function (e) {

            if(e.status)
            {
                if(text)
                {
                    localStorage.setItem('edit', 'O evento ' + e.name + ' foi excluido');
                    location.href = '/events';
                }
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        });
    }


    function getChurchZipCode()
    {
        $("#btn-zipCode").css("display", "none");
        $("#loading-zip").css("display", "block");

        var request = $.ajax({
            url: "/getChurchZipCode",
            method: "GET",
            dataType: "json"
        });

        request.done(function (e) {
            console.log(e);
            $("#zipCode").val(e.zipCode);
            $("#street").val(e.street);
            $("#number").val(e.number);
            $("#neighborhood").val(e.neighborhood);
            $("#city").val(e.city);
            $("#state").val(e.state);
            $("#btn-zipCode").css("display", "block");
            $("#loading-zip").css("display", "none");

        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        })
    }

    function UnsubscribeUser(person, event)
    {
        var request = $.ajax({
            url: '/delete-sub/' + person + '/' + event,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {
            if(e.status)
            {

                var num = $("#span-sub").text();

                $("#span-sub").text(num-1);

                $("#notific8-title").val("Atenção");
                $("#notific8-text").val("Usuário foi excluído");

                setTimeout(function() {
                    $("#progress-danger").css("display", "none");

                    $("#tr-"+person).remove();

                    $("#notific8").trigger("click");

                }, 1000);
            }
        });

        request.fail(function (e) {
            console.log('fail');
            console.log(e);
        })
    }

    /*
     * Ativado quando o usuário é excluído, porém
     * os eventos e/ou grupos criados pelo mesmo serão
     * mantidos e transferidos.
     * id = person_id
     */
    function keepActions(id)
    {
        var name = "";
        var request = $.ajax({
            url: "/keepActions/" + id,
            method: "GET",
            dataType: "json",
            async: false
        });

        request.done(function(e){
            if(e.status)
            {
                name = e.name;
            }
        });

        request.fail(function () {
            console.log("fail");
            console.log(e);
        });

        return name;
    }

    /*
     * Ativado quando o usuário é excluído, e
     * os eventos e/ou grupos criados pelo mesmo
     * também serão excluídos.
     * id = person_id
     */
    function deleteActions(id)
    {
        var request = $.ajax({
            url: "/deleteActions/" + id,
            method: "GET",
            dataType: "json",
            async: false
        });

        request.done(function(e){
            if(e.status)
            {
                return true;
            }
        });

        request.fail(function () {
            console.log("fail");
            console.log(e);
        });
    }

    /*
     * Verifica o estado civil do usuário a
     * ser excluído. Se for casado marca o conjugê como
     * casado com "Parceiro(a) fora da igreja"
     * id = person_id
     */
    function verifyMaritalStatus(id)
    {
        var request = $.ajax({
            url: '/verifyMaritalStatus/' + id,
            method: "GET",
            dataType: "json"
        });

        request.done(function (e) {
            if(e.status)
            {
                return true;
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        });


        return true;
    }


    function setUploadStatus(name)
    {
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

    function getUploadStatus(name)
    {
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
            if(e.status)
            {
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

    function ReactivateUser(id)
    {
        var request = $.ajax({
            url: '/reactivateUser/' + id,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                $("#notific8-title").val("Atenção");
                $("#notific8-text").val("Usuário foi reativado");
                $("#notific8-type").val(null);

                setTimeout(function() {
                    $("#progress-success").css("display", "none");

                    $("#tr-"+id).remove();

                    $("#notific8").trigger("click");

                }, 1000);

            }

            location.reload();
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        })
    }

    function forceDeleteUser(id)
    {
        var request = $.ajax({
            url: '/forceDeleteUser/' + id,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                $("#notific8-title").val("Atenção");
                $("#notific8-text").val("Usuário foi reativado");
                $("#notific8-type").val(null);

                setTimeout(function() {
                    $("#progress-success").css("display", "none");

                    $("#tr-"+id).remove();

                    $("#notific8").trigger("click");

                }, 1000);
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        })
    }

    $("#check-auto").click(function(){

        swal({
            title: 'Atenção',
            text: 'Deseja Habilitar o check-in automático?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-primary",
            confirmButtonText: "Habilitar",
            cancelButtonText: "Desabilitar",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm){
            if(isConfirm)
            {
                swal("Sucesso!", "Os check-ins serão automáticos", "success");
                $('#span-check').html('Sim');
                check_auto(1);
            }
            else{
                swal("Atenção!", "Os check-ins automáticos foram desabilitados", "info");
                $('#span-check').html('Não');
                check_auto(0);
            }
        });

        /*var request = $.ajax({
            url: 'enable-check-auto',
            method: 'GET',
            dataType: 'json'
        });

        request.done(function(e){

        });

        request.fail(function(e){
            console.log('fail');
            console.log(e);
        })*/
    });

    function check_auto(check)
    {
        var id = $("#event_id").val();

        var request = $.ajax({
            url: '/check_auto/' + id + '/' + check,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function(e) {
            return true;
        });

        return false;
    }

    $("#btn-search").keyup(function () {

        var str = location.pathname;

        var input = this.value;

        if(input.length > 2)
        {
            $("#p-zero").css('display', 'none');
            $("#pagination").css('display', 'none');
            $('tbody > tr').css('display', 'none');
            $("#tbody-search > tr").remove();
            $("thead").css('display', 'none');
            $("#loading-results").css('display', 'block');
            generalSearch(str, input);
        }
        else{
            $("thead").css('display', 'table-header-group');
            $("#p-zero").css('display', 'none');
            $("#loading-results").css('display', 'none');
            $("#tbody-search").addClass('hide');
            $("#tbody-search > tr").remove();
            $("#pagination").css('display', 'block');
            $('tbody > tr').css('display', 'table-row');
        }
    });

    function makeMember(id)
    {
        var request = $.ajax({
            url: '/make-member/' + id,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {
            if(e.status)
            {
                swal("Sucesso!", "O Usuário selecionado agora é um membro", "success");

                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
        })
    }

    function generalSearch(model, input)
    {
        var request = '';

        if(model == "/inactive-person")
        {
            request = $.ajax({
                url: '/search-person/' + input + '/' + 'inactive',
                method: 'GET',
                dataType: 'json'
            });

            request.done(function(e){
                if(e.status)
                {
                    var i = 0;

                    var tr = '';

                    while(i < e.data.length)
                    {
                        tr += '<tr><td><img src="'+ e.data[i]+'" class="imgProfile img-circle"></td><td>'+e.data[i + 1]+'</td><td>Membro</td>'+
                            '<td>' +
                            '<button class="btn btn-success btn-sm btn-circle pop-created" title="Deseja Re-ativar o Membro"'+
                            'onclick="sweetGeneralSearch('+ e.data[i + 2] +')"'+
                            'id="btn-delete-'+ e.data[i + 2] +'">'+
                            '<i class="fa fa-share"></i>'+
                            '<span class="hidden-xs hidden-sm"> Ativar</span>'+
                            '</button>' +
                            '<button class="btn btn-danger btn-sm btn-circle pop" title="Deseja Excluir o Membro"'+
                            'onclick="sweetGeneralDeleteInac('+ e.data[i + 2] +')"'+
                            'id="btn-delete-'+ e.data[i + 2] +'">'+
                            '<i class="fa fa-trash"></i>'+
                            '<span class="hidden-xs hidden-sm"> Excluir</span>'+
                            '</button>'+
                            '</td>' +
                            '</tr>';

                        i = i + 3;
                    }

                    $("#loading-results").css('display', 'none');

                    $("thead").css('display', 'table-header-group');

                    $("#tbody-search").removeClass('hide').append(tr);

                    console.log(e.data);
                }
                else{
                    $("#loading-results").css('display', 'none');
                    $("#p-zero").css('display', 'block');
                }

            });

            request.fail(function(e){
                console.log("fail");
                console.log(e);
            });

        }

        else if(model == "/person" || model == '/teen')
        {
            request = $.ajax({
                url: '/search-person/' + input + '/' + 'people',
                method: 'GET',
                dataType: 'json'
            });

            var route = location.pathname + '/';

            request.done(function (e) {
                if(e.status)
                {
                    var i = 0;

                    var tr = '';

                    while(i < e.data.length)
                    {
                        tr += '<tr>' +
                            '<td>' +
                                '<img src="'+ e.data[i]+'" class="imgProfile img-circle">' +
                            '</td>' +
                            '<td><a href="'+route+ e.data[i + 5]+'/edit">'+ e.data[i + 1]+'</a></td>' +
                            '<td>'+ e.data[i + 2] +'</td>'+
                            '<td>'+ e.data[i + 3] +'</td>'+
                            '<td>'+ e.data[i + 4] +'</td>'+
                            '<td>' +
                                '<button class="btn btn-danger btn-sm btn-circle" title="Deseja Excluir o Membro"'+
                                'onclick="sweetDeleteUser('+ e.data[i + 5] +')"'+
                                'id="btn-delete-'+ e.data[i + 5] +'">'+
                                '<i class="fa fa-trash"></i>'+
                                '<span class="hidden-xs hidden-sm"> Inativar</span>'+
                                '</button>'+
                            '</td>' +
                            '</tr>';

                        i = i + 6;
                    }

                    $("#loading-results").css('display', 'none');

                    $("thead").css('display', 'table-header-group');

                    $("#tbody-search").removeClass('hide').append(tr);

                    console.log(e.data);
                }
                else{
                    $("#loading-results").css('display', 'none');
                    $("#p-zero").css('display', 'block');
                }
            })
        }
        else{
            if(model == "/visitors")
            {
                request = $.ajax({
                    url: '/search-person/' + input + '/' + 'visitor',
                    method: 'GET',
                    dataType: 'json'
                });


                request.done(function (e) {
                   if(e.status)
                   {
                       var i = 0;

                       var tr = '';

                       while(i < e.data.length)
                       {
                           tr += '<tr>' +
                               '<td>' +
                               '<img src="'+ e.data[i]+'" class="imgProfile img-circle">' +
                               '</td>' +
                               '<td><a href="/visitors/'+ e.data[i + 4]+'/edit">'+ e.data[i + 1]+'</a></td>' +
                               '<td>'+ e.data[i + 2] +'</td>'+
                               '<td>'+ e.data[i + 3] +'</td>'+
                               '<td>' +
                               '<button class="btn btn-success btn-sm btn-circle" title="Deseja Tornar Membro?"'+
                               'onclick="sweetMakeMember('+ e.data[i + 4] +')"'+
                               'id="btn-delete-'+ e.data[i + 4] +'">'+
                               '<i class="fa fa-share"></i>'+
                               '<span class="hidden-xs hidden-sm"> Tornar Membro</span>'+
                               '</button>'+
                               '</td>' +
                               '</tr>';

                           i = i + 5;
                       }

                       $("#loading-results").css('display', 'none');

                       $("thead").css('display', 'table-header-group');

                       $("#tbody-search").removeClass('hide').append(tr);

                       console.log(e.data);
                   }
                   else{
                       $("#loading-results").css('display', 'none');
                       $("#p-zero").css('display', 'block');
                   }
                });
            }
        }
    }

    function sweetGeneralSearch(id)
    {

        swal({
            title: 'Atenção',
            text: 'Você deseja reativar o usuário selecionado ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            closeOnConfirm: true,
            closeOnCancel: true
        },
            function(isConfirm){

                if(isConfirm)
                {
                    ReactivateUser(id);
                }
        });
    }

    function sweetGeneralDeleteInac(id)
    {
        swal({
            title: 'Atenção',
            text: 'Você deseja excluir o usuário selecionado ? \n (Os dados não poderão ser recuperados)',
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            closeOnConfirm: true,
            closeOnCancel: true
        },
            function(isConfirm){

                if(isConfirm)
                {
                    Delete(id, 'inactive-person', null);
                }
            });
    }

    function sweetMakeMember(id)
    {
        swal({
            title: 'Atenção',
            text: 'Você deseja tornar este visitante membro?',
            type: 'info',
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            closeOnConfirm: true,
            closeOnCancel: true
        },
            function (isConfirm) {
                if(isConfirm)
                {
                    makeMember(id);
                }
            }
        );
    }

    function sweetRollback(code, day)
    {
        console.log('code: ' + code);
        console.log('day: ' + day);
        swal({
            title: 'Atenção',
            text: 'Deseja desfazer a importação do dia ' + day + ' ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-info",
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            closeOnConfirm: true,
            closeOnCancel: true
        },
            function(isConfirm){
                if(isConfirm)
                {
                    rollbackImport(code);
                }
            }
        )
    }

    function rollbackImport(code)
    {
        var request = $.ajax({
            url: '/rollback-code/' + code,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                location.reload();
            }
            else{
                swal('Erro', 'Um erro ocorreu: ' + e.error, 'error');
            }
        });

        request.fail(function(e){
            console.log("fail");
            console.log(e);

            swal('Erro', 'Verifique sua conexão, ou realize o login novamente', 'error');
        })
    }


    function sweetFeed(status)
    {
        if(status){
            swal('Sucesso', 'O feed foi cadastrado com sucesso', 'success');
        }
        else{
            swal('Erro', 'Verifique sua conexão, ou realize o login novamente', 'error');
        }

    }


    function newFeed()
    {
        var text = $("#feed-text");
        var link = $("#feed-link").val();
        var stop = false;

        if(text.val() == "")
        {
            $("#span-error-feed").css('display', 'block');
            $("#span-feed-text").css('display', 'block');
            stop = true;
        }

        if(!stop){
            var publico = $("#publico").is(':checked');
            var evento = $("#evento").is(':checked');
            var grupo = $("#grupo").is(':checked');
            var pessoa = $("#pessoa").is(':checked');
            var admin = $("#admin").is(':checked');

            var chosenNumber = null;

            if(publico)
            {
                chosenNumber = 1;
            }
            else if(evento)
            {
                chosenNumber = 2;
            }
            else if(grupo){
                chosenNumber = 3;
            }
            else if(pessoa){
                chosenNumber = 4;
            }
            else if(admin){
                chosenNumber = 5;
            }
            else{
                //Mostrar Erro
                $("#span-error-feed").css('display', 'block');
                text.addClass('has-error');
                stop = true;
            }

            if(!stop)
            {

                var request = $.ajax({
                    url: '/newFeed/' + chosenNumber + '/' + text.val() + '/' + link + '/' + expires_in,
                    method: 'GET',
                    dataType: 'json'
                });

                request.done(function(e){
                    sweetFeed(true);
                });

                request.fail(function(e){
                    console.log(e);
                    sweetFeed(false);
                });
            }
        }



        return false;
    }





