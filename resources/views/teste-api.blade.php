<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>


        <div class="" style="margin-left: 40%; margin-top: 10%;">

            <a href="javascript:;" class="btn btn-primary btn-lg" onclick="event_list_sub()">Event-List-Sub</a>
            <a href="javascript:;" class="btn btn-success btn-lg" onclick="check_in()">Check-in List</a>

        </div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



<script>



        function church_list()
        {
            var request = $.ajax({
                url: 'https://beconnect.com.br/api/church-list',
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

        function event_list_sub()
        {

            var request = $.ajax({
                url: 'https://beconnect.com.br/api/event-list-sub/49',
                method: 'GET',
                dataType: 'json'
            });

            request.done(function(e)
            {
                console.log('done');
                console.log(e);
            });

            request.fail(function(e){
                console.log('fail');
                console.log(e);
            });

        }

    function check_in()
    {
        var request = $.ajax({
            url: 'https://beconnect.com.br/api/getCheckinList/49',
            method: 'GET',
            dataType: 'json'
        });

        request.done(function(e)
        {
            console.log('done');
            console.log(e);
        });

        request.fail(function(e){
            console.log('fail');
            console.log(e);
        });
    }




</script>
</body>
</html>