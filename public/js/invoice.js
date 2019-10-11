$(function(){

    localStorage.clear();

    $(".btn-delete-invoice").click(function () {

        //var id = this.id.replace('btn-delete-', '');

        var id = this.id.replace('btn-delete-invoice-', '');

        delete_invoice(id);
    });

    $(".btn-resend-invoice").click(function () {

        $(this).text('').append('<i class="fa fa-paper-plane"></i> Enviando...').attr('disabled', true);
    });

    $("#customer_id").change(function () {

        get_info_org(this.value);

        $("#form_customer_id").removeClass('has-error');

        $("#span_error_customer_id").css('display', 'none');
    });

    $("#add_item").click(function () {

        var title = $('#title');
        var price = $("#price");
        var description = $("#description");
        var qtde = $("#qtde");

        if(title.val() == "")
        {
            $("#div_title").addClass(' has-error');
            title.attr('placeholder', 'Preencha este campo para adicionar o item');
        }

        if(price.val() == "")
        {
            $("#div_price").addClass(' has-error');
            price.attr('placeholder', 'Preencha este campo para adicionar o item');
        }

        if(price.val() != "" && title.val() != "")
        {
            var iteration = localStorage.getItem('iteration') ? localStorage.getItem('iteration') : 0;

            iteration++;

            localStorage.setItem('iteration', iteration);

            $("#div_title").removeClass('has-error');
            $("#div_price").removeClass('has-error');

            $("#panel-itens").css('display', 'block');

            var prepend = '<tr id="tr_item_'+iteration+'">' +
                '<td id="td_title_'+iteration+'">'+title.val()+'</td>'+
                '<td id="td_price_'+iteration+'">'+price.val()+'</td>'+
                '<td id="td_qtde_'+iteration+'">'+qtde.val()+'</td>'+
                '<input type="hidden" value="'+description.val()+'" name="td_description_'+iteration+'" id="td_description_'+iteration+'">'+
                '<input type="hidden" value="'+price.val()+'" name="td_price_'+iteration+'" id="input_price_'+iteration+'">'+
                '<input type="hidden" value="'+title.val()+'" name="td_title_'+iteration+'" id="input_title_'+iteration+'">'+
                '<input type="hidden" value="'+qtde.val()+'" name="td_qtde_'+iteration+'" id="input_qtde_'+iteration+'">'+
                '<td>'+
                '<a href="javascript:" class="btn green-dark btn-sm btn-circle btn-item-list btn-edit-item" onclick="edit_item('+iteration+')"><i class="fa fa-pencil"></i></a>' +
                '<a href="javascript:" class="btn btn-danger btn-sm btn-circle btn-item-list btn-del-item" onclick="delete_item('+iteration+')"><i class="fa fa-trash"></i></a>'+
                '</td>'+
                '</tr>';

            $("#tbody_itens").prepend(prepend);

            title.val('');
            price.val('');
            description.val('');
            qtde.val('');
        }
    });

    $("#save_modal").click(function (e) {

        var id = $("#item_id").val();

        var title_modal = $("#title_modal").val();

        var price_modal = $("#price_modal").val();

        var qtde_modal = $("#qtde_modal").val();

        var description_modal = $("#description_modal").text();

        if(title_modal == "")
        {
            e.preventDefault();

            $("#div_title_modal").addClass(' has-error');
        }

        if(price_modal == "")
        {
            e.preventDefault();

            $("#div_price_modal").addClass(' has-error');
        }

        if(title_modal != "" && price_modal != "")
        {
            $("#div_title_modal").removeClass(' has-error');

            $("#div_price_modal").removeClass(' has-error');

            $("#td_title_"+id).text(title_modal);

            $("#td_price_"+id).text(price_modal);

            $("#td_qtde_"+id).text(qtde_modal);

            $("#td_description_"+id).val(description_modal);

            $("#input_price_"+id).val(price_modal);

            $("#input_title_"+id).val(title_modal);

            $("#input_qtde_"+id).val(qtde_modal);

            $("#modal_edit_item").modal('hide');
        }

    });

    $("#btn-print").click(function () {

        var append = '<input type="hidden" name="print">';

        $("#print_div").append(append);

        $("#form_create").submit();
    });


    $("#email").change(function () {
        is_valid(this.value);

        $("#email").val('');
    });

    $(document).keypress(function (e) {

        var $email = $("#email");

        if(e.which === 13 && $email.is(':focus'))
        {
            e.preventDefault();

            return is_valid($email.val());
        }

    });

    $("#event_id").change(function () {

        $(".chargeback").removeClass('col-md-6').addClass('col-md-4');

        $("#check-chargeback").css('display', 'block');
    });



});

function is_valid($email)
{
    var org = $("#customer_id").val();

    if(org)
    {
        $("#form_customer_id").removeClass('has-error');

        $("#span_error_customer_id").css('display', 'none');

        if(validateEmail($email))
        {
            $("#f_email").removeClass('has-error');

            $("#f_span").css('display', 'none');

            $("#f_span_use").css('display', 'none');

            var emails = $(".selected-email");
            var stop = false;

            for(var i = 0; i < emails.length; i++)
            {
                if(emails[i].innerText == $email)
                {
                    stop = true;
                    break;
                }
            }

            if(!stop)
            {
                $("#email").val('');

                email($email);
            }
            else{
                $("#f_span_use").css('display', 'block');
            }

        }
        else{
            $("#f_email").addClass('has-error');

            $("#f_span").css('display', 'block');
        }

        return true;
    }
    else{
        $("#form_customer_id").addClass('has-error');

        $("#span_error_customer_id").css('display', 'block');

        return false;
    }
}

//Usado para formatar o campo email
//com varios emails que receberão o invoice
function email(email)
{
    var email_iteration = localStorage.getItem('email_iteration') ? localStorage.getItem('email_iteration') : 0;

    email_iteration++;

    localStorage.setItem('email_iteration', email_iteration);

    var append = ''+
    '<div class="col-md-3" id="col_email_'+email_iteration+'">' +
        '<div class="form-group">' +
            '<div class="input-group input-icon right">' +
                '<span class="input-group-addon">' +
                    '<span class="selected-email">'+email+'</span> <span class="x-del-email" onclick="remove_column('+email_iteration+')">x</span>' +
                    '<input type="hidden" name="email_'+email_iteration+'" value="'+email+'">'+
                '</span>' +
            '</div>' +
        '</div>' +
    '</div>';

    $("#row_email").append(append);
}

function remove_column(id)
{
    $("#col_email_"+id).remove();
}

function delete_invoice(id)
{
    var url = '/invoice/';

    var method = 'DELETE';

    var data = null;

    var static_page = true;

    var msg = 'O invoice foi excluido';

    swal({
        title: "Você tem certeza?",
        text: 'Quer Excluir o invoice selecionado?',
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Sim, Excluir!",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false

    },function (isConfirm) {

        if(isConfirm)
        {
            Request(url, data, id, method, static_page, msg);

            $('#btn-delete-invoice-'+id).text('').append('<i class="fa fa-trash"></i> Excluindo...').attr('disabled', true);

            setTimeout(function () {
                $("#tr_"+id).remove();
            }, 2000);

            setTimeout(function () {
                $(".confirm").trigger('click');
            }, 4000);
        }

    });



}

function delete_item(id)
{
    $("#tr_item_"+id).remove();

}

function edit_item(id)
{
    var td_title = $("#td_title_" + id).text();
    var td_price = $("#td_price_"+ id).text();
    var td_qtde = $("#td_qtde_"+ id).text();
    var td_desc = $("#td_description_" + id).val();

    $("#title_modal").val(td_title);
    $("#price_modal").val(td_price);
    $("#qtde_modal").val(td_qtde);
    $("#description_modal").text(td_desc);

    $("#item_id").val(id);

    $("#modal_edit_item").modal('show');
}

/*
 * Recupera os dados da org selecionada
 * e preenche o campo email e evento
*/
function get_info_org(id)
{
    $("#event_id option").remove();

    var request = $.ajax({
        url: '/get_info_org/' + id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {

        if(e.status)
        {
            var append = '<option value="" selected>Selecione</option>';

            for(var i = 0; i < e.events.length; i++)
            {
                append += '<option value="'+e.events[i].id+'">'+e.events[i].name+'</option>';
            }

            $("#event_id").append(append);

            if(e.org.email)
            {
                var email = $("#email");

                email.val(e.org.email);

                email.trigger('change');

            }


        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);
    });
}

//Usado para pegar os itens no invoice, somente no edit invoice
function get_itens()
{

    if(isEdit())
    {
        var invoice_id = $("#invoice_id").val();

        var request = $.ajax({
            url: '/get_itens_invoice/' + invoice_id,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {
            if(e.status)
            {
                for(var i = 0; i < e.itens.length; i++)
                {
                    var iteration = localStorage.getItem('iteration') ? localStorage.getItem('iteration') : 0;

                    iteration++;

                    localStorage.setItem('iteration', iteration);


                    $("#panel-itens").css('display', 'block');

                    var prepend = '<tr id="tr_item_'+iteration+'">' +
                        '<td id="td_title_'+iteration+'">'+e.itens[i].title+'</td>'+
                        '<td id="td_price_'+iteration+'">'+e.itens[i].price+'</td>'+
                        '<td id="td_qtde_'+iteration+'">'+e.itens[i].qtde+'</td>'+
                        '<input type="hidden" value="'+e.itens[i].description+'" name="td_description_'+iteration+'" id="td_description_'+iteration+'">'+
                        '<input type="hidden" value="'+e.itens[i].price+'" name="td_price_'+iteration+'" id="input_price_'+iteration+'">'+
                        '<input type="hidden" value="'+e.itens[i].title+'" name="td_title_'+iteration+'" id="input_title_'+iteration+'">'+
                        '<input type="hidden" value="'+e.itens[i].qtde+'" name="td_qtde_'+iteration+'" id="input_qtde_'+iteration+'">'+
                        '<td>'+
                        '<a href="javascript:" class="btn green-dark btn-sm btn-circle btn-item-list btn-edit-item" onclick="edit_item('+iteration+')"><i class="fa fa-pencil"></i></a>' +
                        '<a href="javascript:" class="btn btn-danger btn-sm btn-circle btn-item-list btn-del-item" onclick="delete_item('+iteration+')"><i class="fa fa-trash"></i></a>'+
                        '</td>'+
                        '</tr>';

                    $("#tbody_itens").prepend(prepend);
                }

            }
        });

        request.fail(function (e) {
            console.log('fail');
            console.log(e);
        })
    }
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function get_emails()
{

    if(isEdit())
    {
        var invoice_id = $("#invoice_id").val();

        var request = $.ajax({
            url: '/get_emails_invoice/' + invoice_id,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {
            if(e.status)
            {
                var $email = $("#email");

                for (var i = 0; i < e.emails.length; i++)
                {
                    $email.val(e.emails[i].email);
                    $email.trigger('change');
                }
            }
        });

        request.fail(function (e) {
            console.log('fail');
            console.log(e);
        });
    }
}

//Usado para verificar se a pagina de edição está aberta
function isEdit()
{
    return location.href.search('edit') != -1 ? true : false;
}

function verifyEvent()
{
    if(isEdit() && $("#event_id").val() != "")
    {
        $(".chargeback").removeClass('col-md-6').addClass('col-md-4');

        $("#check-chargeback").css('display', 'block');

        $("#chargeback").trigger('click');
    }
}

get_itens();
get_emails();
verifyEvent();

