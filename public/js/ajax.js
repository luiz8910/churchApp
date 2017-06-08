


    $(".btnSend").click(function (e) {

        if(!$(".btnSend").attr('disabled'))
        {
            var email = $("#recoverEmail").val();
            var request = $.ajax({
                url: "/sendPassword/" + email,
                method: "POST",
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

        e.stopImmediatePropagation();

        return false;
    });



    /*
     * var id = id do evento
     * Usado para realizar check-in no evento
     * @param id
     */
    function checkInEvent(id)
    {
        var request = $.ajax({
            url: '/events/checkInEvent/' + id,
            method: 'POST',
            dataType: 'json'
        });

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


    $("#recoverEmail").change(function () {
        console.log("email");

        if(validateEmail(this.value))
        {
            var request = $.ajax({
                url: "/emailTest/" + this.value,
                method: "GET",
                //data: this.value,
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
            alert("entre com um email válido");
        }
    });

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }


    $("#search-results").keyup(function () {

        if(this.value == ""){
            $(".ul-search").css("display", "none");
            $(".ul-search li").remove();
        }
        else{

            if(this.value.length > 2)
            {
                $(".ul-search").css("display", "block");
                search(this.value);
            }

        }

    });


    function search(text)
    {
        var request = $.ajax({
            url: "/search/" + text,
            method: "GET",
            dataType: "json"
        });

        request.done(function (e) {
            console.log("done");

            console.log(e);



            var ul = $(".ul-search");


            for(var i = 0; i < e.length; i++)
            {
                if(i == 0)
                {
                    $(".ul-search li").remove();
                }

                var model;
                var icon;

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
                    '<li class="dropdown dropdown-extended dropdown-notification dropdown-dark">' +
                        '<a href="/'+model+'/'+e[i].id+'/edit" class="dropdown-toggle"'+
                        'data-close-others="true">'+
                        '<i class="fa fa-'+icon+' font-grey"></i>'+
                        e[i].name
                        +'</a>'+
                    '</li>';

                ul.append(li);
            }

        });

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
            automaticCep(this.value);
        }

    });

    $("#mother_id").change(function () {

        if($("#zipCode").val() == "")
        {
            automaticCep(this.value);
        }

    });


    function automaticCep(id)
    {
        var request = $.ajax({
            url: '/automatic-cep/' + id,
            method: 'GET',
            dataType:'json'
        });

        request.done(function (e) {
            console.log("done");
            console.log(e);

            if(e.cep)
            {
                $("#zipCode")
                    .val(e.cep)
                    .trigger('blur');
            }
        });

        request.fail(function (e) {
            console.log("fail");
            console.log(e);
        });
    }

    function Delete(id, route)
    {
        var request = $.ajax({
            url: route+"-delete/" + id,
            method: "GET",
            dataType: 'json'
        });

        request.done(function (e) {

            if(e.status)
            {
                $("#notific8-title").val("Atenção");
                $("#notific8-text").val("O evento " + e.name + " foi excluído");

                setTimeout(function() {
                    $("#progress-danger").css("display", "none");

                    searchForEvent(e.name);

                    $("#tr-"+id).remove();

                    $("#notific8").trigger("click");

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
        var label = $("label").get();
        var str = text.replace(/ /gi, "-");

        console.log('text: ' + str);
        for (var i = 0; i < label.length; i++)
        {

            if(label[i].innerText == text)
            {
                console.log(label[i].innerHTML);

                $("."+str).remove();

                label[i].remove();
            }
        }
    }


    function leaveGroup(group, person)
    {
        var request = $.ajax({
            url: 'deleteMemberGroup/'+ group + '/' + person,
            method: 'GET',
            dataType:'json'
        });

        request.done(function (e) {
            console.log("done");
            console.log(e);

            if(e){
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

