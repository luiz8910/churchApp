<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>



<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>

    $(function(){

        function request()
        {
            var request = $.ajax({
                url: 'https://beconnect.com.br/church-list',
                method: 'GET',
                dataType: 'json'
            });

            request.done(function (e) {
                console.log('done');
                console.log(e);
            });

            request.fail(function(e){
                console.log('fail');
                console.log(e);
            })
        }

        request();
    });



</script>
</body>
</html>