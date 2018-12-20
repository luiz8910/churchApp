<html>
    <head></head>


    <body>

        <div class="text-center">
            <h3>Aguarde o seu download começar...</h3>
        </div>

        <form id="form-download" action="{{ route('documents.download', ['id' => $id]) }}"></form>

        @include('includes.core-scripts')

        <script>

            submit();

            function submit()
            {
                $("#form-download").submit();

                setTimeout(function () {
                    window.close();
                }, 5000)
            }
        </script>
    </body>
</html>