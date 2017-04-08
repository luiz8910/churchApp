/**
 * Created by Luiz on 03/04/2017.
 */

$(function() {

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#street").val("");
        $("#neighborhood").val("");
        $("#city").val("");
    }

    function overlayOn() {
        document.getElementById("overlay").style.display = "block";
    }

    function overlayOff() {
        document.getElementById("overlay").style.display = "none";
    }



    //Quando o campo cep perde o foco.
    $("#zipCode").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                $(".loader").css("display", "block");
                //Preenche os campos com "..." enquanto consulta webservice.
                $("#street").val("...");
                $("#neighborhood").val("...");
                $("#city").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#street").val(dados.logradouro);
                        $("#neighborhood").val(dados.bairro);
                        $("#city").val(dados.localidade);
                        $("#state").val(dados.uf);
                        $(".loader").css("display", "none");
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        $(".loader").css("display", "none");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                $(".loader").css("display", "none");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            $(".loader").css("display", "none");
            limpa_formulário_cep();
        }
    });
});