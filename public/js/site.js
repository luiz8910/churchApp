/**
 * Created by luizfernandosanches on 22/02/18.
 */

$(function(){

    $("#form-site").submit(function(e){
        e.preventDefault();

        var data = $(this).serializeArray();

        //console.log(data);

        contactForm(data);
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

    $(".tel").maskbrphone({
        useDdd: true,
        useDddParenthesis: true,
        dddSeparator: ' ',
        numberSeparator:'-'
    });
});