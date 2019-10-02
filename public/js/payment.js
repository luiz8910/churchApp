
//


$(function () {

    $("#value_money").change(function () {

        var append = '';

        if(this.value)
        {
            var value = this.value.replace('R$', '');

            value = value.replace('.', '');

            value = value.replace(',', '.');

            console.log(value);

            var array = [];

            for(var i = 2; i < 13; i++)
            {
                var val = value / i;

                array.push(val.toFixed(2));

            }

            $("#installments option").remove();

            append = '<option value="1">' + 'á vista R$' + value + '</option>'+
                    '<option value="2">' + 'Até 2x de  R$' +  array[0] + '</option>'+
                    '<option value="3">' + 'Até 3x de  R$' + array[1] + '</option>'+
                    '<option value="4">' + 'Até 4x de  R$' + array[2] + '</option>'+
                    '<option value="5">' + 'Até 5x de  R$' + array[3] + '</option>'+
                    '<option value="6">' + 'Até 6x de  R$' + array[4] + '</option>'+
                    '<option value="7">' + 'Até 7x de  R$' + array[5] + '</option>'+
                    '<option value="8">' + 'Até 8x de  R$' + array[6] + '</option>'+
                    '<option value="9">' + 'Até 9x de  R$' + array[7]+ '</option>'+
                    '<option value="10">' + 'Até 10x de  R$' + array[8] + '</option>'+
                    '<option value="11">' + 'Até 11x de  R$' + array[9] + '</option>'+
                    '<option value="12">' + 'Até 12x de  R$' + array[10] + '</option>'
            ;


            $("#credit_card").attr('checked', true);
        }
        else{
            $("#installments option").remove();

            append = '<option value="">Insira o valor do Evento</option>';

            $("#credit_card").attr('checked', null);

        }

        $("#installments").append(append);
    });


    $("#check_payment-slip").click(function () {
        if($("#check_payment-slip").is(':checked'))
        {
            $("#payment-slip").css('display', 'block');
        }
        else{
            $("#payment-slip").css('display', 'none');
        }
    });


    $(".course").click(function () {

        var id = this.id.replace('course-', '');

        var header = $("#header-value-money");

        var header_m = $("#header-value-money-mob");

        var input = $("#input-header-m").val();

        var value = 0;

        var price = $("#course-value-"+id).val();

        if($("#course-"+id).is(':checked'))
        {
            value = parseFloat(input);

            value += parseFloat(price);

            $("#input-header-m").val(value);

            header.text('R$' + value);
            header_m.text('R$' + value);

            $("#span-total").text('R$' + value);

            installments(value);

        }
        else{

            value = parseFloat(input);

            value -= parseFloat(price);

            $("#input-header-m").val(value);
            header_m.text('R$' + value);

            header.text('R$' + value);

            $("#span-total").text('R$' + value);

            installments(value);
        }


    });

    $("#form-sub-pay").submit(function (event) {

        var input = $("#input-header-m").val();

        if(parseInt(input) === 0)
        {
            event.preventDefault();

            $("#form-courses").css('border', '1px solid red');

            $("#select-course").css('display', 'block');

            $('html, body').animate({
                scrollTop: $("body").offset().top
            }, 2000);
        }
    });

});

function installments(value)
{
    $("#installments option").remove();

    var append = '';

    if(value == 0)
    {
        append = '<option value="" selected>Selecione um parcelamento</option>';
    }
    else{
        var max = $("#max_installments").val();

        value = parseFloat(value);

        if(max > 1)
        {

            for (var i = 1; i <= max; i++)
            {
                if(i === 1)
                {
                    append += '<option value="'+i+'" selected>1x de '+value.toFixed(2)+'</option>';
                }
                else{
                    append += '<option value="'+i+'">'+i+'x de '+(value / i).toFixed(2)+'</option>';
                }

            }
        }
        else{

            append = '<option value="1" selected>'+value+'</option>';
        }
    }

    $("#installments").append(append);
}
