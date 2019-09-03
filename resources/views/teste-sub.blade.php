<!doctype html>
<html lang="pt-br">
    <head>
        @include('includes.head')
        <link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../css/event.css">
    </head>
<body>

    <div class="row">
        <div class="col-md-6">
            <div class="square-buttons">

            </div>
        </div>
    </div>



    @include('includes.footer')

    @include('includes.core-scripts')

    <script src="../assets/global/plugins/select2/js/select2.full.js" type="text/javascript"></script>
    <script src="../assets/pages/scripts/components-select2.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(".select2-allow-clear").select2();
    </script>

</body>
</html>
