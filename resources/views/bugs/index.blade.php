<html>
    <head>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="js/bug.js"></script>

        <style>
            .row{
                margin-top:40px;
                padding: 0 10px;
            }
            .clickable{
                cursor: pointer;
            }

            .panel-heading div {
                margin-top: -18px;
                font-size: 15px;
            }
            .panel-heading div span{
                margin-left:5px;
            }
            .panel-body{
                display: none;
            }
        </style>
    </head>

    <body>

        @if(count($desk) > 0 || count($app) > 0)

            <div class="container">
                <h1>Click no ícone de filtro <small>(<i class="glyphicon glyphicon-filter"></i>)</small></h1>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Desktop</h3>
                                <div class="pull-right">
                                    <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                        <i class="glyphicon glyphicon-filter"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Filtrar Bugs" />
                            </div>
                            <table class="table table-hover" id="dev-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Descrição</th>
                                    <th>Local</th>
                                    <th>Model</th>
                                    <th>Igreja</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($desk) > 0)
                                        @foreach($desk as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td style="cursor: pointer;"
                                                    onclick="textarea('{{ $item->description }}');">

                                                    {{ substr($item->description, 0, 10) }}...
                                                </td>
                                                <td>{{$item->location}}</td>
                                                <td>{{$item->model}}</td>
                                                <td>{{$item->church_id}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">App</h3>
                                <div class="pull-right">
                                    <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                        <i class="glyphicon glyphicon-filter"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <input type="text" class="form-control" id="task-table-filter" data-action="filter" data-filters="#task-table" placeholder="Filtrar Bugs" />
                            </div>
                            <table class="table table-hover" id="task-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Descrição</th>
                                    <th>Local</th>
                                    <th>Model</th>
                                    <th>Igreja</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($app) > 0)
                                        @foreach($app as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td style="cursor: pointer;"
                                                    onclick="textarea('{{ $item->description }}')">
                                                    {{ substr($item->description, 0, 10) }}...
                                                </td>
                                                <td>{{$item->location}}</td>
                                                <td>{{$item->model}}</td>
                                                <td>{{$item->church_id}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h3 class="text-center">Detalhes</h3>

                            <div class="form-group">
                                <textarea name="" id="textarea" cols="30" rows="20" class="form-control"></textarea>
                            </div>
                        </div>


                    </div>
                </div>
            </div>




        @else

            <h3 class="text-center">Não há Bugs</h3>

        @endif
    </body>
</html>

<!------ Include the above in your HEAD tag ---------->

