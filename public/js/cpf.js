/**
 * Created by Luiz on 04/04/2017.
 */

function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g,'');
    if(cpf == '') return false;
    // Elimina CPFs invalidos conhecidos
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
    // Valida 1o digito
    add = 0;
    for (i=0; i < 9; i ++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    // Valida 2o digito
    add = 0;
    for (i = 0; i < 10; i ++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    return true;
}

$("#cpf").keypress(function (e) {
    if(e.which < 48 || e.which > 57){

        return false;

    }

}).keyup(function () {

    var cpf = $("#cpf").val();

    if(cpf.length == 11)
    {
        if(validarCPF(cpf)){
            $("#form-cpf")
                .removeClass('has-error')
                .addClass('has-success');

            $("#icon-error-cpf").css("display", "none");
            $("#icon-success-cpf").css("display", "block");
            $(".small-error").css("display", "none");

            checkCPF(cpf);
        } else{
            $("#form-cpf")
                .removeClass("has-success")
                .addClass("has-error");

            $("#icon-success-cpf").css("display", "none");
            $("#icon-error-cpf").css("display", "block");
            $(".small-error").css("display", "block");
        }
    }




});
