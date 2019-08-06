<html>
    <head>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

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
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Desktop (Back-end)</h3>
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
                                    <th>Organização</th>
                                    <th>Data</th>
                                    <th>Opções</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($desk) > 0)
                                        @foreach($desk as $item)
                                            <tr id="tr-{{ $item->id }}" style="cursor: pointer;">
                                                <td class="tr">{{ $item->id }}</td>
                                                <td class="tr" id="description-{{ $item->id }}">
                                                    {{ substr($item->description, 0, 10) }}...
                                                </td>
                                                <td class="tr">{{$item->location}}</td>
                                                <td class="tr">{{$item->church_id}}</td>
                                                <td class="tr">{{date_format(date_create($item->created_at), 'd/m/Y H:i')}}</td>
                                                <td>
                                                    <a href="javascript:" class="btn btn-success btn-outline btn-ok" id="btn-ok-{{ $item->id }}">
                                                        <i class="fa fa-check"></i>
                                                    </a>

                                                </td>
                                                <input type="hidden" value="{{ $item->description }}" id="input-{{ $item->id }}">
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
                                    <th>Organização</th>
                                    <th>Data</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($app) > 0)
                                        @foreach($app as $item)
                                            <tr id="tr-{{ $item->id }}" style="cursor: pointer;">
                                                <td class="tr">{{ $item->id }}</td>
                                                <td class="tr" id="description-{{ $item->id }}">
                                                    {{ substr($item->description, 0, 10) }}...
                                                </td>
                                                <td class="tr">{{$item->location}}</td>
                                                <td class="tr">{{$item->church_id}}</td>
                                                <td class="tr">{{date_format(date_create($item->created_at), 'd/m/Y H:i')}}</td>
                                                <input type="hidden" value="{{ $item->description }}" id="input-{{ $item->id }}">
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
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="js/bug.js"></script>
</html>

<!------ Include the above in your HEAD tag ---------->

