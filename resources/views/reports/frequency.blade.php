

    {{--<input type="hidden" id="event_id" value="{{ $event_id }}">

    <input type="hidden" id="event_name" value="{{ $event_name }}">

    <input type="hidden" id="qtde_sub" value="{{ $qtde_sub }}">--}}

    <div id="container_frequency" style="width: 100% !important; height: 500px !important;"></div>


    <script>

        chart();

        function chart()
        {

            var subs = $.ajax({
                url: '/getFrequency/' + $('#event_id').val(),
                method: 'GET',
                dataType: 'json'
            });

            subs.done(function (e) {

                Highcharts.chart('container_frequency', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Relação Inscritos x Presentes'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Quantidade',
                        colorByPoint: true,
                        data: [{
                            name: 'Inscritos',
                            y: e.sub,
                            sliced: true,
                            selected: true
                        }, {
                            name: 'Presentes',
                            y: e.presence
                        }]
                    }]
                });

            })
        }

    </script>

