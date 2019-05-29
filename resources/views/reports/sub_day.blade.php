

    <input type="hidden" id="event_id" value="{{ $event_id }}">

    <input type="hidden" id="event_name" value="{{ $event_name }}">

    <div id="container_sub_day" style="width: 100% !important; height: 500px !important;"></div>


    <script>

        chart();

        function chart()
        {
            var subs = $.ajax({
                url: '/getSubDays/' + $('#event_id').val(),
                method: 'GET',
                dataType: 'json'
            });

            subs.done(function (e) {

                console.log('unique :' + e.unique_days);
                console.log('dates: ' + e.dates);

                // Create the chart
                Highcharts.chart('container_sub_day', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Quantidade de Inscritos por dia (' + $('#event_name').val() +')',
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories: e.unique_days,
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
                        data: e.dates
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

            })
        }

    </script>

