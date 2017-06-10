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
                $(".input-address").css('display', 'none');
                $(".div-loading").css('display', 'block');
                //Preenche os campos com "..." enquanto consulta webservice.

                /*$("#street").val("...");
                $("#neighborhood").val("...");
                $("#city").val("...");*/

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        setTimeout(function () {
                            $(".div-loading").css('display', 'none');
                            $(".input-address").css('display', 'block');
                            $("#street").val(dados.logradouro).focus();
                            $("#neighborhood").val(dados.bairro);
                            $("#city").val(dados.localidade);
                            $("#state").val(dados.uf);
                        }, 2000);


                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        $(".div-loading").css('display', 'none');
                        $(".input-address").css('display', 'block');
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                $(".div-loading").css('display', 'none');
                $(".input-address").css('display', 'block');
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            $(".div-loading").css('display', 'none');
            $(".input-address").css('display', 'block');
            limpa_formulário_cep();
        }
    });
});