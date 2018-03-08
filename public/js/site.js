/**
 * Created by luizfernandosanches on 22/02/18.
 */

$(function(){

    function Request(url, data, id, method, static_page)
    {
        var values = [];
        var request = '';

        if(data && !id)
        {
            for(var i = 0; i < data.length; i ++)
            {
                data[i].value = data[i].value.replace('?', "--");
                values.push(data[i].value);
            }

            values = JSON.stringify(values);

            request = $.ajax({
                url: url + values,
                method: method ? method : 'GET',
                dataType: 'json'
            });

            request.done(function(e){
                if(e.status)
                {
                    SuccessMsg(static_page);
                }
                else{

                    ErrorMsg();

                }
            });

            request.fail(function(e){
                console.log('fail');
                console.log(e);

                ErrorMsg();
            });
        }

        else if(!data && id)
        {
            request = $.ajax({
                url: url + id,
                method: method ? method : 'GET',
                dataType: 'json'
            });

            request.done(function(e){
                if(e.status){
                    SuccessMsg(static_page);
                }
                else{
                    ErrorMsg();
                }
            });

            request.fail(function(e){
                console.log('fail');
                console.log(e);

                ErrorMsg();
            });
        }

        else if(data && id)
        {
            for(var x = 0; x < data.length; x++)
            {
                data[x].value = data[x].value.replace('?', "--");
                values.push(data[x].value);
            }

            values = JSON.stringify(values);

            request = $.ajax({
                url: url + values + '/' + id,
                method: method ? method : 'GET',
                dataType: 'json'
            });

            request.done(function(e){
                if(e.status){
                    SuccessMsg(static_page);
                }
                else{
                    ErrorMsg();
                }
            });

            request.fail(function(e){
                console.log('fail');
                console.log(e);

                ErrorMsg();
            });
        }

    }

    function SimpleRequest(url, data, id, method, static_page)
    {
        var request = '';

        if(data && id)
        {
            request = $.ajax({
                url: url + data + '/' + id,
                method: method ? method : 'GET',
                dataType: 'json'
            });

            request.done(function(e){
                if(e.status){
                    SuccessMsg(static_page);
                }
                else{
                    ErrorMsg();
                }
            });

            request.fail(function(e){
                console.log('fail');
                console.log(e);

                ErrorMsg();
            });
        }

    }
    
    function clearTextArea()
    {
        $('textarea').each(function () {

            var trim = $.trim($(this).text());

            $(this).text(trim);
        })
    }

    checkList();
    clearTextArea();

    function checkList()
    {
        $('li').each(function(){

            if($.trim($(this).text()) == ''){
                $(this).remove();
            }

        });

    }

    $("#btn-main").click(function(){
       $("#edit-main").css('display', 'block');
    });

    $("#btn-about").click(function(){
        $("#edit-about").css('display', 'block');
    });

    $("#btn-about-item").click(function(){
        $("#edit-about-item").css('display', 'block');
    });

    $("#btn-features").click(function(){
        $("#edit-features").css('display', 'block');
    });

    $(".btn-faq").click(function(){
        var str = this.id;

        var id = str.replace('btn-faq-', '');

        $("#edit-faq-"+id).css('display', 'block');
    });

    $("#form-main").submit(function(e){
        e.preventDefault();

        var data = $(this).serializeArray();

        var url = '/edit-main-site/';

        Request(url, data, null, 'POST');

        //editMain(data);
    });

    $("#form-about").submit(function(e){
        e.preventDefault();

        var data = $(this).serializeArray();

        var url = '/edit-about-site/';

        Request(url, data, null, 'POST');
        //editAbout(data);
    });

    $("#form-about-item").submit(function(e){
        e.preventDefault();

        var data = $(this).serializeArray();

        var url = '/edit-about-item-site/';

        Request(url, data, null, 'POST');

        //editAboutItem(data);
    });

    $(".form-faq-edit").submit(function(e){
        e.preventDefault();

        var data = $(this).serializeArray();

        var id = data[2].value;

        var url = '/edit-faq/';

        Request(url, data, id, 'POST');
    });

    $("#form-new-faq").submit(function(e){
        e.preventDefault();

        var data = $(this).serializeArray();

        var url = '/new-faq/';

        $('#new-faq').modal('hide');

        Request(url, data, null, 'POST');
    });

    $('.delete-faq').click(function(){
        var str = this.id;

        var id = str.replace('delete-faq-', '');

        var url = '/delete-faq/';

        sweetAlertDel(id, url, true);




    });

    function editMain(data)
    {
        var values = [];

        for(var i = 0; i < data.length; i ++)
        {
            values.push(data[i].value);
        }

        values = JSON.stringify(values);

        var request = $.ajax({
            url: '/edit-main-site/' + values,
            method: 'POST',
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                SuccessMsg();
            }
            else{

                ErrorMsg();

            }
        });

        request.fail(function(e){
            console.log('fail');
            console.log(e);

            ErrorMsg();
        })

    }

    function editAbout(data)
    {
        var values = [];

        for(var i = 0; i < data.length; i ++)
        {
            values.push(data[i].value);
        }

        values = JSON.stringify(values);

        var request = $.ajax({
            url: '/edit-about-site/' + values,
            method: 'POST',
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                SuccessMsg();
            }
            else{

                ErrorMsg();

            }
        });

        request.fail(function(e){
            console.log('fail');
            console.log(e);

            ErrorMsg();
        })
    }

    function editAboutItem(data)
    {
        var values = [];

        for(var i = 0; i < data.length; i ++)
        {
            values.push(data[i].value);
        }

        values = JSON.stringify(values);

        var request = $.ajax({
            url: '/edit-about-item-site/' + values,
            method: 'POST',
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                SuccessMsg();
            }
            else{

                ErrorMsg();

            }
        });

        request.fail(function(e){
            console.log('fail');
            console.log(e);

            ErrorMsg();
        })
    }

    function editFeatures(data)
    {
        var values = [];

        for(var i = 0; i < data.length; i ++)
        {
            values.push(data[i].value);
        }

        values = JSON.stringify(values);

        var request = $.ajax({
            url: '/edit-features-site/' + values,
            method: 'POST',
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                SuccessMsg();
            }
            else{

                ErrorMsg();

            }
        });

        request.fail(function(e){
            console.log('fail');
            console.log(e);

            ErrorMsg();
        })
    }


    function SuccessMsg(static_page)
    {
        swal('Sucesso', 'Os dados foram salvos', 'success');

        if(!static_page){
            setTimeout(function(){
                location.reload();
            }, 2000);
        }

    }

    function ErrorMsg()
    {
        swal('Erro', 'Verifique sua conexão', 'error');
    }

    $("#form-site").submit(function(e){
        e.preventDefault();

        var data = $(this).serializeArray();

        //console.log(data);

        var url = '/contact-site/';

        Request(url, data, null, 'POST');

        //contactForm(data);
    });

    function contactForm(data)
    {
        var values = [];

        for (var i = 0; i < data.length; i++) {
            values.push(data[i].value);
        }

        values = JSON.stringify(values);

        var request = $.ajax({
            url: '/contact-site/' + values,
            method: 'POST',
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                swal('Sucesso', 'Sua mensagem foi enviada', 'success');

                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
            else{
                swal('Atenção', 'Não foi possível enviar sua mensagem, verifique sua conexão com a internet', 'error');
            }
        });

        request.fail(function(e){
            console.log('fail');
            console.log(e);

            swal('Atenção', 'Não foi possível enviar sua mensagem, verifique sua conexão com a internet', 'error');
        });



    }

    $(".hide-a").click(function () {
        $(".hide-container").css('display', 'none');
    });



    $(".tel").maskbrphone({
        useDdd: true,
        useDddParenthesis: true,
        dddSeparator: ' ',
        numberSeparator:'-'
    });

    $(".close-btn").click(function(){
        $(".hide-container").css('display', 'none');
        $(".hide-container-item").css('display', 'none');
        $(".hide-container-edit").css('display', 'none');
    });

    $("#newFeature").click(function(){
        $(".hide-container").css('display', 'block');
    });

    $("#form-features").submit(function(e){
        e.preventDefault();

        var data = $(this).serializeArray();

        var url = '/newFeature/';

        Request(url, data, null, 'POST');

        /*var values = [];

        for(var i = 0; i < data.length; i++)
        {
            values.push(data[i].value);
        }

        values = JSON.stringify(values);

        var request = $.ajax({
            method: 'POST',
            url: '/newFeature/' + values,
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status){
                SuccessMsg();
            }
            else{
                ErrorMsg();
            }
        });

        request.fail(function(e){
            console.log('fail');
            console.log(e);

            ErrorMsg();
        });*/
    });

    $(".btn-delete").click(function(){

        var str = this.id;

        var id = str.replace('btn-delete-', "");

        var url = '/delete-feature/';

        sweetAlertDel(id, url);
    });

    function sweetAlertDel(id, url, static_page)
    {
        swal({
                title: 'Atenção',
                text: 'Deseja excluir o item selecionado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Sim, Excluir",
                cancelButtonText: "Não",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {

                    Request(url, null, id, null, static_page);

                    $('#tr-faq-'+id).remove();
                    $('#tr-'+id).remove();

                }
            });
    }

    function deleteFeature(id)
    {
        var request = $.ajax({
            url: '/delete-feature/' + id,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status){
                SuccessMsg();
            }
            else{
                ErrorMsg();
            }
        });

        request.fail(function(e){
            console.log('fail');
            console.log(e);

            ErrorMsg();
        });
    }

    $(".btn-new-feat-item").click(function(){
        var str = this.id;

        var id = str.replace('btn-new-feat-item-', '');

        $(".hide-container-item").css('display', 'block');

        localStorage.setItem('feature_id', id);
    });

    localStorage.setItem('btn_id', 2);

    $("#form-features-item").submit(function(e){
        e.preventDefault();

        var data = $(this).serializeArray();

        var id = localStorage.getItem('feature_id');

        var url = '/new-feature-item/';

        Request(url, data, id, 'POST');

        /*var values = [];

        for(var i = 0; i < data.length; i++)
        {
            values.push(data[i].value);
        }

        values = JSON.stringify(values);

        var request = $.ajax({
            url: "/new-feature-item/" + values + "/" + id,
            method: 'POST',
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status){
                SuccessMsg();
            }
            else{
                ErrorMsg();
            }
        });

        request.fail(function(e){
            console.log('fail');
            console.log(e);

            ErrorMsg();
        })*/
    });


    $(".btn-edit").click(function(){
        var str = this.id;

        var id = str.replace('btn-edit-', '');

        $(".cont-"+id).css('display', 'block');
    });

    $(".btn-remove-item").click(function(){
        var str = this.id;

        var id = str.replace('btn-delete-feat-item-', '');

        swal({
                title: 'Atenção',
                text: 'Deseja excluir o item selecionado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Sim, Excluir",
                cancelButtonText: "Não",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    $("#div-remove-"+id).remove();

                    var url = '/deleteItemFeature/';

                    Request(url, null, id, null, true);

                    //deleteItemFeature(id);
                }
            });

    });

    function deleteItemFeature(id)
    {
        $("#div-remove-"+id).remove();


        var request = $.ajax({
            url: '/deleteItemFeature/' + id,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                SuccessMsg(true);
            }
            else{
                ErrorMsg();
            }

        });

        request.fail(function(e){
            console.log('fail');
            console.log(e);

            ErrorMsg();
        });
    }

    $(".form-edit").submit(function(e){
        e.preventDefault();

        var str = this.id;

        var id = str.replace('form-features-edit-', '');

        var data = $(this).serializeArray();

        values = JSON.stringify(data);

        console.log(values);

        var request = $.ajax({
            url: '/editFeatures/' + values + '/' + id,
            method: 'POST',
            dataType: 'json'
        });

        request.done(function(e){
            if(e.status)
            {
                SuccessMsg();
            }
            else{
                ErrorMsg();
            }
        });

        request.fail(function(e){
            console.log('fail');
            console.log(e);

            ErrorMsg();
        });
    });

    $(".icon-add").click(function(){
        var str = this.id;

        var id = str.replace('img-', '');

        localStorage.setItem('feature_id', id);

        $("#trigger-modal").trigger('click');
    });



    $(".icon-img").click(function()
    {
        var src = $(this).attr('src');

        var icon_id = this.id; icon_id = icon_id.replace('icon_id-', '');

        localStorage.setItem('icon_id', icon_id);

        $('#none-selected').css('display', 'none');

        $('#img-selected').attr('src', src);

        $('#img-selected-a').css('display', 'inline');
    });

    $("#btn-submit-icon").click(function(){

        var feature_id = localStorage.getItem('feature_id');

        var icon_id = localStorage.getItem('icon_id');

        $("#modal-icon").modal('hide');

        if(feature_id && icon_id)
        {
            localStorage.removeItem('feature_id');

            localStorage.removeItem('icon_id');

            var url = '/change-icon/';

            SimpleRequest(url, feature_id, icon_id);
        }
    });

    $("#newPlan").click(function(){
        var url = $("#url").val();

        var append = option('type_id');

        var form = '<div class="row"> <div class="col-md-12"> <div class="form-group"> <label for="name">Nome:</label> <input type="text" name="name" id="name" class="form-control" placeholder="Nome" required> </div></div></div><div class="row"> <div class="col-md-12"> <div class="form-group"> <label for="description">Descrição</label> <textarea name="description" id="description" cols="30" rows="5" placeholder="Descrição" required class="form-control"></textarea> </div></div></div><div class="row"> <div class="col-md-12"> <div class="form-group"> <label for="price">Preço</label> <div class="input-group"> <span class="input-group-addon" id="basic-addon1">$</span> <input type="number" name="price" id="price" class="form-control" placeholder="Preço" required aria-describedby="basic-addon1"> </div></div></div></div><div class="row"> <div class="col-md-12"> <div class="form-group"> <label for="type_id">Frequência de cobrança</label> '+append+' </div></div></div><div class="row"> <div class="col-md-12"> <div class="form-group"> <fieldset id="fieldset-check"> <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"> <input type="checkbox" name="check-insert" class="checkboxes check-model" id="check-insert" value="1"/> <span></span> </label> Mais popular </fieldset> </div></div></div>';

        setFormData(url, form);
    });

    $("#newPlanFrequency").click(function(){
        var url = $("#url2").val();

        var form = '<div class="row"> <div class="col-md-12"> <div class="form-group"> <label for="type">Tipo:</label> <input type="text" name="type" id="type" class="form-control" placeholder="Tipo" required> </div></div></div><div class="row"> <div class="col-md-12"> <div class="form-group"> <label for="selected_text">Texto selecionado</label> <input name="selected_text" id="selected_text" placeholder="Texto selecionado" required class="form-control"/> </div></div></div><div class="row"> <div class="col-md-12"> <div class="form-group"> <label for="adjective">Adjetivo</label> <input type="text" name="adjective" id="adjective" class="form-control" placeholder="Mensais, Anual, Trimestrais" required> </div></div></div><div class="row"> <div class="col-md-12"> <div class="form-group"> <label for="save_money">Economia</label> <div class="input-group"> <span class="input-group-addon" id="basic-addon1">%</span> <input type="number" name="save_money" id="save_money" class="form-control" placeholder="20%, 30%" aria-describedby="basic-addon1"> </div></div></div></div>';

        setFormData(url, form)
    });

    $('.btn-edit-plan').click(function () {
        var str = this.id;

        var id = str.replace('btn-edit-plan-', '');

        $('.container-plan-edit-'+id).css('display', 'block');
    });



    function option(component_id)
    {
        var values = [];
        var txt = [];
        var append = '<select name="'+component_id+'" id="'+component_id+'" class="form-control" required> <option value="">Selecione</option>';


        $("#"+component_id+" option").each(function () {
            var val = $(this).val();
            var text = $(this).text();

            values.push(val);
            txt.push(text);
        });

        for(var i = 1; i < values.length; i++)
        {
            append += '<option value="'+values[i]+'"> '+txt[i]+'</option>';
        }

        append += '</select>';

        return append;
    }

    function setFormData(url, form)
    {
        $("#div-form").remove();

        $("#form-insert").attr('action', url);

        $(".modal-body").append('<div id="div-form"></div>');

        $("#div-form").append(form);

        $('#btn-insert-modal').trigger('click');
    }

    $(".btn-delete-plan").click(function () {
        var str = this.id;

        var id = str.replace('btn-delete-plan-', '');

        var url = '/deletePlan/';

        sweetAlertDel(id, url, true);

    });

    $("#btn-new-plan-item").click(function () {

        var url = '/new-plan-item';

        var form = '<div class="row"> <div class="col-md-12"> <div class="form-group"> <label for="text_item">Texto (Vantagens) </label> <input type="text" name="text" id="text_item" class="form-control" placeholder="Digite aqui uma das vantagens dos planos" required> </div> </div> </div>'

        setFormData(url, form);
    });

    $(".btn-delete-plan-item").click(function () {
        var str = this.id;

        var id = str.replace('btn-delete-plan-item-', '');

        var url = '/delete-plan-item/';

        sweetAlertDel(id, url)
    });

    $('.btn-edit-type-plan').click(function () {
        var str = this.id;

        var id = str.replace('btn-edit-type-plan-', '');

        $(".container-type-plan-edit-"+id).css('display', 'block');
    });

    $('.btn-delete-type-plan').click(function () {
        var str = this.id;

        var id = str.replace('btn-delete-type-plan-', '');

        var url = '/delete-plan-type/';

        sweetAlertDel(id, url);
    });

    typePlanSelected();

    $('.btn-type').click(function () {

        var str = this.id;

        var id = str.replace("btn-type-", '');

        typePlanSelected(id);
    });

    function typePlanSelected(type_id)
    {
        $('.type-card').css('display', 'none');

        if(type_id)
        {
            $(".type-id-"+type_id).css('display', 'block');
        }
        else{

            $('.type-class').each(function () {

                if ($('#'+this.id).is(':checked'))
                {
                    var str = this.id;

                    var id = str.replace("option-", '');

                    $(".type-id-"+id).css('display', 'block');
                }

            })
        }

    }


});

    function newItem()
    {
        var btn_id = localStorage.getItem('btn_id');

        var div =
            '<div id="div-'+btn_id+'">'+'<br>'+
            '<div class="row">'+
            '<div class="col-md-9">'+
            '<input type="text" class="form-control" name="text" value=""'+
            'placeholder="Digite o texto" id="input-'+btn_id+'" required>'+
            '</div>'+

            '<div class="col-md-3">'+
            '<button type="button" class="btn btn-danger" onclick="deleteItem('+btn_id+')" id="btn-delete-'+btn_id+'">'+
            '<i class="fa fa-close"></i>'+
            ' Excluir'+
            '</button>'+
            '</div>'+
            '</div>'+
            '</div>';

        $("#append-div").append(div);

        btn_id++;
        localStorage.setItem('btn_id', btn_id);
    }

    function deleteItem(id)
    {

        if(id == 1){
            $("#input-1").val('');
        }
        else{
            $('#div-'+id).remove();
        }

    }