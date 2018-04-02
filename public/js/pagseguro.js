/*
const pagSeguro = {
    creditCards: {},
    getBrand: function (bin) {
        return new Promise(function(resolve, reject) {
            PagSeguroDirectPayment.getBrand({
                cardBin: bin,
                success: function(res) {
                    //let brand = pagSeguro.creditCards[res.brand.name.toUpperCase()];
                    //let url = brand.images.MEDIUM.path;
                    resolve({
                        result: res,
                        url: 'https://stc.pagseguro.uol.com.br/'
                        //url: 'https://stc.pagseguro.uol.com.br/' + url
                    });
                }
            });
        });
    },

    getPaymentMethods : function(amount)
    {
        return new Promise(function(resolve, reject){

            PagSeguroDirectPayment.getPaymentMethods({
                amount: amount,
                success: function (res) {
                    var creditCards = pagSeguro.creditCards = res.paymentMethods.CREDIT_CARD.options;
                    var brandsUrls = [];
/!**!/

                    Object.keys(creditCards).forEach(function(key){
                        var url = creditCards[key].images.MEDIUM.PATH;

                        brands.push('https://stc.pagseguro.uol.com.br/' + url);
                    });

                    resolve(brands);
                }
            })
        });
    }

}*/


$(function(){

    var senderHash = PagSeguroDirectPayment.getSenderHash();

    $("#senderHash").val(senderHash);

    var param = {
        cardNumber: $("#creditCardNumber").val(),
        cvv: $("#cvv").val(),
        expirationMonth: $("#expirationMonth").val(),
        expirationYear: $("#expirationYear").val(),
        success: function(response) {
            //token gerado, esse deve ser usado na chamada da API do Checkout Transparente
            $("#creditCardToken").val(response.card.token)
        },
        error: function(response) {
            //tratamento do erro
            console.log(response);
        },
        complete: function(response) {
            //tratamento comum para todas chamadas
        }
    };

    PagSeguroDirectPayment.createCardToken(param);

    var payment = {
        amount: 100.00,
        success:function(response){
            console.log(response);
        },
        error: function (error) {
            console.log(error);
        }
    };

    PagSeguroDirectPayment.getPaymentMethods(payment);

    var installments = {
        amount: 100.00,
        //brand: $("input#bandeira").val(),
        maxInstallmentNoInterest: 1,
        success: function(response) {
            //opções de parcelamento disponível
        },
        error: function(response) {
            //tratamento do erro
        },
        complete: function(response) {
            //tratamento comum para todas chamadas
        }
    };

    PagSeguroDirectPayment.getInstallments(installments);


});
