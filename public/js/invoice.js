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

        var value = this.value;

        get_info_org(value);
    });

    $("#add_item").click(function () {

        var title = $('#title');
        var price = $("#price");
        var description = $("#description");

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
                '<input type="hidden" value="'+description.val()+'" name="td_description_'+iteration+'" id="td_description_'+iteration+'">'+
                '<input type="hidden" value="'+price.val()+'" name="td_price_'+iteration+'" id="input_price_'+iteration+'">'+
                '<input type="hidden" value="'+title.val()+'" name="td_title_'+iteration+'" id="input_title_'+iteration+'">'+
                '<td>'+
                '<a href="javascript:" class="btn blue btn-sm btn-circle btn-item-list btn-edit-item" onclick="edit_item('+iteration+')"><i class="fa fa-pencil"></i></a>' +
                '<a href="javascript:" class="btn btn-danger btn-sm btn-circle btn-item-list btn-del-item" onclick="delete_item('+iteration+')"><i class="fa fa-trash"></i></a>'+
                '</td>'+
                '</tr>';

            $("#tbody_itens").prepend(prepend);

            title.val('');
            price.val('');
            description.val('');
        }
    });

    $("#save_modal").click(function (e) {

        var id = $("#item_id").val();
        var title_modal = $("#title_modal").val();
        var price_modal = $("#price_modal").val();
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

            $("#td_description_"+id).val(description_modal);

            $("#input-price_"+id).val(price_modal);

            $("#input-title_"+id).val(title_modal);

            $("#modal_edit_item").modal('hide');
        }

    });

    $("#btn-print").click(function () {

        var append = '<input type="hidden" name="print">';

        $("#print_div").append(append);

        $("#form_create").submit();
    })

});

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
    var td_desc = $("#td_description_" + id).val();

    $("#title_modal").val(td_title);
    $("#price_modal").val(td_price);
    $("#description_modal").text(td_desc);

    $("#item_id").val(id);

    $("#modal_edit_item").modal('show');
}

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
                $("#email").val(e.org.email);
            }


        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);
    });
}
