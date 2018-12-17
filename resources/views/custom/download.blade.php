<html>
    <head></head>


    <body>

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