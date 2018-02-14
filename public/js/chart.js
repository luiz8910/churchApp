/**
 * Created by Luiz on 06/06/2017.
 */

    //Funções abaixo localizam-se no arquivo ajax.js
    dataChart();

    eventChartReport();

    eventChartAgeRange();

    eventChartMemberVisitor();

    function simpleChart(data)
    {

        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Relatórios'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: 'Quant.',
                colorByPoint: true,
                data: [{
                    name: 'Mães solteiras',
                    y: data[0]
                }, {
                    name: 'Pais solteiros',
                    y: data[1]
                    //sliced: true,
                    //selected: true
                }, {
                    name: 'Mulheres solteiras',
                    y: data[2]
                }, {
                    name: 'Homens solteiros',
                    y: data[3]
                }, {
                    name: 'Mulheres casadas sem filhos',
                    y: data[4]
                }, {
                    name: 'Homens casados sem filhos',
                    y: data[5]
                }, {
                    name: 'Mulher casada fora da igreja',
                    y: data[6]
                }, {
                    name: 'Homem casado fora da igreja',
                    y: data[7]
                },]
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 400
                    },
                    chartOptions: {
                        series: [{
                            id: 'versions',
                            dataLabels: {
                                enabled: false
                            }
                        }]
                    }
                }]
            }
        });
    }


    function chart()
    {
        var colors = Highcharts.getOptions().colors,
            categories = ['MSIE', 'Firefox', 'Chrome', 'Safari', 'Opera'],
            data = [{
                y: 56.33,
                color: colors[0],
                drilldown: {
                    name: 'MSIE versions',
                    categories: ['MSIE 6.0', 'MSIE 7.0', 'MSIE 8.0', 'MSIE 9.0',
                        'MSIE 10.0', 'MSIE 11.0'],
                    data: [1.06, 0.5, 17.2, 8.11, 5.33, 24.13],
                    color: colors[0]
                }
            }, {
                y: 10.38,
                color: colors[1],
                drilldown: {
                    name: 'Firefox versions',
                    categories: ['Firefox v31', 'Firefox v32', 'Firefox v33',
                        'Firefox v35', 'Firefox v36', 'Firefox v37', 'Firefox v38'],
                    data: [0.33, 0.15, 0.22, 1.27, 2.76, 2.32, 2.31, 1.02],
                    color: colors[1]
                }
            }, {
                y: 24.03,
                color: colors[2],
                drilldown: {
                    name: 'Chrome versions',
                    categories: ['Chrome v30.0', 'Chrome v31.0', 'Chrome v32.0',
                        'Chrome v33.0', 'Chrome v34.0',
                        'Chrome v35.0', 'Chrome v36.0', 'Chrome v37.0', 'Chrome v38.0',
                        'Chrome v39.0', 'Chrome v40.0', 'Chrome v41.0', 'Chrome v42.0',
                        'Chrome v43.0'],
                    data: [0.14, 1.24, 0.55, 0.19, 0.14, 0.85, 2.53, 0.38, 0.6, 2.96,
                        5, 4.32, 3.68, 1.45],
                    color: colors[2]
                }
            }, {
                y: 4.77,
                color: colors[3],
                drilldown: {
                    name: 'Safari versions',
                    categories: ['Safari v5.0', 'Safari v5.1', 'Safari v6.1',
                        'Safari v6.2', 'Safari v7.0', 'Safari v7.1', 'Safari v8.0'],
                    data: [0.3, 0.42, 0.29, 0.17, 0.26, 0.77, 2.56],
                    color: colors[3]
                }
            }, {
                y: 0.91,
                color: colors[4],
                drilldown: {
                    name: 'Opera versions',
                    categories: ['Opera v12.x', 'Opera v27', 'Opera v28', 'Opera v29'],
                    data: [0.34, 0.17, 0.24, 0.16],
                    color: colors[4]
                }
            }, {
                y: 0.2,
                color: colors[5],
                drilldown: {
                    name: 'Proprietary or Undetectable',
                    categories: [],
                    data: [],
                    color: colors[5]
                }
            }],
            browserData = [],
            versionsData = [],
            i,
            j,
            dataLen = data.length,
            drillDataLen,
            brightness;


        // Build the data arrays
        for (i = 0; i < dataLen; i += 1) {

            // add browser data
            browserData.push({
                name: categories[i],
                y: data[i].y,
                color: data[i].color
            });

            // add version data
            drillDataLen = data[i].drilldown.data.length;
            for (j = 0; j < drillDataLen; j += 1) {
                brightness = 0.2 - (j / drillDataLen) / 5;
                versionsData.push({
                    name: data[i].drilldown.categories[j],
                    y: data[i].drilldown.data[j],
                    color: Highcharts.Color(data[i].color).brighten(brightness).get()
                });
            }
        }

        // Create the chart
        Highcharts.chart('container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Browser market share, January, 2015 to May, 2015'
            },
            subtitle: {
                text: 'Source: <a href="http://netmarketshare.com/">netmarketshare.com</a>'
            },
            yAxis: {
                title: {
                    text: 'Total percent market share'
                }
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            tooltip: {
                valueSuffix: '%'
            },
            series: [{
                name: 'Browsers',
                data: browserData,
                size: '60%',
                dataLabels: {
                    formatter: function () {
                        return this.y > 5 ? this.point.name : null;
                    },
                    color: '#ffffff',
                    distance: -30
                }
            }, {
                name: 'Versions',
                data: versionsData,
                size: '80%',
                innerSize: '60%',
                dataLabels: {
                    formatter: function () {
                        // display only if larger than 1
                        return this.y > 1 ? '<b>' + this.point.name + ':</b> ' +
                        this.y + '%' : null;
                    }
                },
                id: 'versions'
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 400
                    },
                    chartOptions: {
                        series: [{
                            id: 'versions',
                            dataLabels: {
                                enabled: false
                            }
                        }]
                    }
                }]
            }
        });
    }

    function eventReport(days, qtdePeople, frequency, name)
    {
        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'column'
            },
            title: {
                text: 'Presença no evento: ' + name
            },
            subtitle:{
                text: 'Total de Inscritos: ' + qtdePeople
            },
            xAxis: {
                categories: days,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Membros Presentes'
                }
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: 'Frequência',
                colorByPoint: true,
                data: [{
                    name: days[0],
                    y: frequency[0]
                }, {
                    name: days[1],
                    y: frequency[1]
                    //sliced: true,
                    //selected: true
                }, {
                    name: days[2],
                    y: frequency[2]
                }, {
                    name: days[3],
                    y: frequency[3]
                }, {
                    name: days[4],
                    y: frequency[4]

                },]
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 400
                    },
                    chartOptions: {
                        series: [{
                            id: 'versions',
                            dataLabels: {
                                enabled: false
                            }
                        }]
                    }
                }]
            }
        });

        eventReportApp(days, qtdePeople, frequency, name);
    }

function eventReportApp(days, qtdePeople, frequency, name)
{
    Highcharts.chart('container-app', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'column'
        },
        title: {
            text: 'Presença no evento: ' + name
        },
        subtitle:{
            text: 'Total de Inscritos: ' + qtdePeople
        },
        xAxis: {
            categories: days,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Membros Presentes'
            }
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Frequência',
            colorByPoint: true,
            data: [{
                name: days[0],
                y: frequency[0]
            }, {
                name: days[1],
                y: frequency[1]
                //sliced: true,
                //selected: true
            }, {
                name: days[2],
                y: frequency[2]
            }, {
                name: days[3],
                y: frequency[3]
            }, {
                name: days[4],
                y: frequency[4]

            },]
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 400
                },
                chartOptions: {
                    series: [{
                        id: 'versions',
                        dataLabels: {
                            enabled: false
                        }
                    }]
                }
            }]
        }
    });
}

function eventAgeRange(data)
{
    Highcharts.chart('container-age-range', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'column'
        },
        title: {
            text: 'Faixa etária do evento: ' + data.name
        },
        subtitle:{
            text: 'Total de Inscritos: ' + data.qtdePeople
        },
        xAxis: {
            categories: ['0 á 10 anos', '11 á 17 anos', '18 á 120 anos'],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Qtde. Pessoas'
            }
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Quantidade',
            colorByPoint: true,
            data: [{
                name: '0 á 10 anos',
                y: data.kids
            }, {
                name: '11 á 17 anos',
                y: data.teens
                //sliced: true,
                //selected: true
            }, {
                name: '18 á 120 anos',
                y: data.adults
            },]
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 400
                },
                chartOptions: {
                    series: [{
                        id: 'versions',
                        dataLabels: {
                            enabled: false
                        }
                    }]
                }
            }]
        }
    });

    eventAgeRangeApp(data);
}

function eventAgeRangeApp(data)
{
    Highcharts.chart('container-age-range-app', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'column'
        },
        title: {
            text: 'Faixa etária do evento: ' + data.name
        },
        subtitle:{
            text: 'Total de Inscritos: ' + data.qtdePeople
        },
        xAxis: {
            categories: ['0 á 10 anos', '11 á 17 anos', '18 á 120 anos'],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Qtde. Pessoas'
            }
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Quantidade',
            colorByPoint: true,
            data: [{
                name: '0 á 10 anos',
                y: data.kids
            }, {
                name: '11 á 17 anos',
                y: data.teens
                //sliced: true,
                //selected: true
            }, {
                name: '18 á 120 anos',
                y: data.adults
            },]
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 400
                },
                chartOptions: {
                    series: [{
                        id: 'versions',
                        dataLabels: {
                            enabled: false
                        }
                    }]
                }
            }]
        }
    });

}

function eventMemberVisitor(data)
{
    Highcharts.chart('container-member_visitor', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'column'
        },
        title: {
            text: 'Tipo de Pessoas no evento: ' + data.name
        },
        subtitle:{
            text: 'Total de Inscritos: ' + data.qtdePeople
        },
        xAxis: {
            categories: ['Membros', 'Visitantes'],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Qtde. Pessoas'
            }
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Quantidade',
            colorByPoint: true,
            data: [{
                name: 'Membros',
                y: data.members
            }, {
                name: 'Visitantes',
                y: data.visitors
                //sliced: true,
                //selected: true
            },]
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 400
                },
                chartOptions: {
                    series: [{
                        id: 'versions',
                        dataLabels: {
                            enabled: false
                        }
                    }]
                }
            }]
        }
    });

    eventMemberVisitorApp(data);
}

function eventMemberVisitorApp(data)
{
    Highcharts.chart('container-member_visitor-app', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'column'
        },
        title: {
            text: 'Tipo de Pessoas no evento: ' + data.name
        },
        subtitle:{
            text: 'Total de Inscritos: ' + data.qtdePeople
        },
        xAxis: {
            categories: ['Membros', 'Visitantes'],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Classificação'
            }
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Classificação',
            colorByPoint: true,
            data: [{
                name: 'Membros',
                y: data.members
            }, {
                name: 'Visitantes',
                y: data.visitors
                //sliced: true,
                //selected: true
            },]
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 400
                },
                chartOptions: {
                    series: [{
                        id: 'versions',
                        dataLabels: {
                            enabled: false
                        }
                    }]
                }
            }]
        }
    });
}

function eventMemberFrequency(data)
{

    var y = [];

    for(var i = 0; i < data.names.length; i++)
    {
        var x = {
            name: data.names[i],
            y: data.qtdePresence[i]
        };

        y.push(x);
    }

    var chart = '';

    if(data.type = 'person')
    {
        chart = 'container-member-frequency';
    }
    else{
        chart = 'container-visitor-frequency';
    }

    Highcharts.chart(chart, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'column'
        },
        title: {
            text: 'Inscrições do usuário: ' + data.personName
        },
        subtitle:{
            text: 'Total de Eventos: ' + data.qtdeEvents
        },
        xAxis: {
            categories: data.names,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Presenças em Eventos'
            }
        },
        tooltip: {
            pointFormat: 'Quantidade: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Média de Presença: ' + data.average + '%',
            colorByPoint: true,
            data: y,

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 400
                },
                chartOptions: {
                    series: [{
                        id: 'versions',
                        dataLabels: {
                            enabled: false
                        }
                    }]
                }
            }]
        }

        }]

    });

    eventMemberFrequencyApp(data);
}

function eventMemberFrequencyApp(data)
{

    var y = [];

    for(var i = 0; i < data.names.length; i++)
    {
        var x = {
            name: data.names[i],
            y: data.qtdePresence[i]
        };

        y.push(x);
    }

    if(data.type = 'person')
    {
        chart = 'container-member-frequency-app';
    }
    else{
        chart = 'container-visitor-frequency-app';
    }

    Highcharts.chart(chart, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'column'
        },
        title: {
            text: 'Inscrições do usuário: ' + data.personName
        },
        subtitle:{
            text: 'Total de Eventos: ' + data.qtdeEvents
        },
        xAxis: {
            categories: data.names,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Presenças em Eventos'
            }
        },
        tooltip: {
            pointFormat: 'Quantidade: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Média de Presença: ' + data.average + '%',
            colorByPoint: true,
            data: y,

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 400
                    },
                    chartOptions: {
                        series: [{
                            id: 'versions',
                            dataLabels: {
                                enabled: false
                            }
                        }]
                    }
                }]
            }

        }]

    });
}