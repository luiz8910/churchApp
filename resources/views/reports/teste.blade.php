<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        {{--<script src="https://code.highcharts.com/highcharts.js"></script>--}}


    </head>
    <body>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <div id="container_sub_day" style="width: 100% !important; height: 500px !important;"></div>
    </body>

    <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>

    <script>

        chart();

        function chart()
        {
            // Create the chart
            Highcharts.chart('container_sub_day', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Quantidade de Inscritos por dia'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: [
                        '01', '02', '03',
                        '04', '05', '06',
                        '07', '08', '09',
                        '10', '11', '12',
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Inscrições'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px"></span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">Inscritos: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Dias',
                    data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
                    /*data: [{
                        x: 1,
                        y: 9,
                        name: "Quantidade de Inscritos",
                        color: "#00FF00"
                    }, {
                        x: 2,
                        y: 6,
                        name: "Quantidade de Inscritos",
                        color: "#FF00FF"
                    }]*/
                }]
            });
        }

    </script>
</html>
