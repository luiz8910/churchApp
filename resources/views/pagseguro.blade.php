<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pagseguro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<br>
<h1 class="text-center">Nova Assinatura</h1>
<br><br>
<div class="container">
    <form action="{{ route('new.transaction') }}" method="post">

        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="luiz.sanches8910@gmail.com">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="token">Token</label>
                    <input type="text" id="token" name="token" value="{{ $token }}" class="form-control">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="paymentMode">PaymentMode</label>
                    <input type="text" id="paymentMode" name="paymentMode" class="form-control" placeholder="paymentMode" value="default">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="paymentMethod">PaymentMethod</label>
                    <input type="text" id="paymentMethod" class="form-control" name="paymentMethod" value="creditCard">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="receiverEmail">receiverEmail</label>
                    <input type="text" id="receiverEmail" class="form-control" name="receiverEmail" value="luiz.sanches8910@gmail.com">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="currency">Currency</label>
                    <input type="text" id="currency" name="currency" value="BRL" class="form-control">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="extraAmount">Extra Amount</label>
                    <input type="text" id="extraAmount" name="extraAmount" value="0.00" class="form-control">
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="itemId1">Item Id 1</label>
                    <input type="text" id="itemId1" name="itemId1" value="1" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="itemDescription1">itemDescription1</label>
                    <input type="text" id="itemDescription1" name="itemDescription1" value="Produto 1" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="itemAmount1">itemAmount1</label>
                    <input type="text" id="itemAmount1" name="itemAmount1" value="100.00" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="itemQuantity1">itemQuantity1</label>
                    <input type="text" id="itemQuantity1" name="itemQuantity1" value="1" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="notificationURL">notificationURL</label>
                    <input type="text" id="notificationURL" name="notificationURL" value="" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="reference">reference</label>
                    <input type="text" id="reference" name="reference" value="REF1234" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="senderName">senderName</label>
                    <input type="text" id="senderName" name="senderName" value="Comprador de Teste" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="senderCPF">senderCPF</label>
                    <input type="text" id="senderCPF" name="senderCPF" value="11475714734" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="senderAreaCode">senderAreaCode</label>
                    <input type="text" id="senderAreaCode" name="senderAreaCode" value="15" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="senderPhone">senderPhone</label>
                    <input type="text" id="senderPhone" name="senderPhone" value="997454531" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="senderEmail">senderEmail</label>
                    <input type="text" id="senderEmail" name="senderEmail" value="tc69821028518327567787@sandbox.pagseguro.com.br" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="senderHash">senderHash</label>
                    <input type="text" id="senderHash" name="senderHash" value="" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shippingAddressStreet">shippingAddressStreet</label>
                    <input type="text" id="shippingAddressStreet" name="shippingAddressStreet" value="Avenida Londres"
                           class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shippingAddressNumber">shippingAddressNumber</label>
                    <input type="text" id="shippingAddressNumber" name="shippingAddressNumber" value="375"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shippingAddressComplement">shippingAddressComplement</label>
                    <input type="text" id="shippingAddressComplement" name="shippingAddressComplement" value=""
                           class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shippingAddressDistrict">shippingAddressDistrict</label>
                    <input type="text" id="shippingAddressDistrict" name="shippingAddressDistrict" value="Jardim Europa"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shippingAddressPostalCode">shippingAddressPostalCode</label>
                    <input type="text" id="shippingAddressPostalCode" name="shippingAddressPostalCode" value="18045330"
                           class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shippingAddressCity">shippingAddressCity</label>
                    <input type="text" id="shippingAddressCity" name="shippingAddressCity" value="Sorocaba"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shippingAddressState">shippingAddressState</label>
                    <input type="text" id="shippingAddressState" name="shippingAddressState" value="SP" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shippingAddressCountry">shippingAddressCountry</label>
                    <input type="text" id="shippingAddressCountry" name="shippingAddressCountry" value="BR"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shippingType">shippingType</label>
                    <input type="text" id="shippingType" name="shippingType" value="1" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="shippingCost">shippingCost</label>
                    <input type="text" id="shippingCost" name="shippingCost" value="0.00" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="creditCardToken">creditCardToken</label>
                    <input type="text" id="creditCardToken" name="creditCardToken" value="" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="installmentQuantity">installmentQuantity</label>
                    <input type="text" id="installmentQuantity" name="installmentQuantity" value="1"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="installmentValue">installmentValue</label>
                    <input type="text" id="installmentValue" name="installmentValue" value="100.00" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="noInterestInstallmentQuantity">noInterestInstallmentQuantity</label>
                    <input type="text" id="noInterestInstallmentQuantity" name="" value="1"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="creditCardHolderName">creditCardHolderName</label>
                    <input type="text" id="creditCardHolderName" name="creditCardHolderName" value="Comprador Teste"
                           class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="creditCardHolderCPF">creditCardHolderCPF</label>
                    <input type="text" id="creditCardHolderCPF" name="creditCardHolderCPF" value="38418189860"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="creditCardHolderBirthDate">creditCardHolderBirthDate</label>
                    <input type="text" id="creditCardHolderBirthDate" name="creditCardHolderBirthDate" value="26/05/1989"
                           class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="creditCardHolderAreaCode">creditCardHolderAreaCode</label>
                    <input type="text" id="creditCardHolderAreaCode" name="creditCardHolderAreaCode" value="15"
                           class="form-control">
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="creditCardHolderPhone">creditCardHolderPhone</label>
                    <input type="text" id="creditCardHolderPhone" name="creditCardHolderPhone" value="997454531"
                           class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="billingAddressStreet">billingAddressStreet</label>
                    <input type="text" id="billingAddressStreet" name="billingAddressStreet" value="Avenida Londres"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="billingAddressNumber">billingAddressNumber</label>
                    <input type="text" id="billingAddressNumber" name="billingAddressNumber" value="375"
                           class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="billingAddressComplement">billingAddressComplement</label>
                    <input type="text" id="billingAddressComplement" name="" value=""
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="billingAddressDistrict">billingAddressDistrict</label>
                    <input type="text" id="billingAddressDistrict" name="billingAddressDistrict" value="Jardim Europa"
                           class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="billingAddressPostalCode">billingAddressPostalCode</label>
                    <input type="text" id="billingAddressPostalCode" name="billingAddressPostalCode" value="18045330"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="billingAddressCity">billingAddressCity</label>
                    <input type="text" id="billingAddressCity" name="billingAddressCity" value="Sorocaba"
                           class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="billingAddressState">billingAddressState</label>
                    <input type="text" id="billingAddressState" name="billingAddressState" value="SP"
                           class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="billingAddressCountry">billingAddressCountry</label>
                    <input type="text" id="billingAddressCountry" name="billingAddressCountry" value="BR"
                           class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i>
                        Enviar
                    </button>
                </div>
            </div>
        </div>
    </form>

    <input type="hidden" id="creditCardNumber" value="4556906344188147">
    <input type="hidden" id="cvv" value="123">
    <input type="hidden" id="expirationMonth" value="08">
    <input type="hidden" id="expirationYear" value="2018">


</div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript" src=
"https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js">
</script>

<script src="../js/pagseguro.js"></script>

<script>
    /*const paymentData = {
        brand: '',
        amount:  $amount ,
    }*/


    PagSeguroDirectPayment.setSessionId('{!! $session !!}');



    /*pagSeguro.getPaymentMethods(paymentData.amount)
            .then(function (urls) {
                let html = '';

                urls.forEach(function(url){
                    html += '<img src="' +url+ '"class="credit_card"'
                });

                $("#payment_methods").html(html);
            });*/

</script>

</body>
</html>