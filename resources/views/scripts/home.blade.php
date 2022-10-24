<script>
    $('.count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 2000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    var options = {
        series: [
            @foreach ($employee_position as $data)
                {{ $data->position_total }},
            @endforeach
        ],
        labels: [
            @foreach ($employee_position as $data)
                "{{ $data->position_desc }}",
            @endforeach
        ],
        chart: {
            type: 'donut',
            height: 200
        },
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart_"), options);
    chart.render();
</script>

<script>
    var chart_A1 = {
        series: [
            @foreach ($dead_wood as $val)
                {
                    name: "{{ strtoupper($val->employee_name) }}",
                    data: [
                        [
                            {{ $val->performance_total }}, {{ $val->competency_total }}
                        ]
                    ]
                },
            @endforeach
        ],
        chart: {
            height: 125,
            type: 'scatter',
            toolbar: {
                show: false
            },
        },
        grid: {
            show: false
        },
        xaxis: {
            min: 0,
            max: 85,
            tickAmount: 5,
            tickPlacement: 'on',
            position: 'bottom',
            labels: {
                show: true
            },
            axisBorder: {
                show: false
            },
        },
        yaxis: {
            show: false,
            min: 0,
            max: 75
        },
        legend: {
            show: false
        }
    };
    
    var chart_A2 = {
        series: [
            @foreach ($adequate_performer as $val)
                {
                    name: "{{ strtoupper($val->employee_name) }}",
                    data: [
                        [
                            {{ $val->performance_total }}, {{ $val->competency_total }}
                        ]
                    ]
                },
            @endforeach
        ],
        chart: {
            height: 125,
            type: 'scatter',
            toolbar: {
                show: false
            },
        },
        grid: {
            show: false
        },
        xaxis: {
            min: 86,
            max: 100,
            tickAmount: 5,
            tickPlacement: 'on',
            position: 'bottom',
            labels: {
                show: true
            },
            axisBorder: {
                show: false
            },
        },
        yaxis: {
            show: false,
            min: 0,
            max: 75
        },
        legend: {
            show: false
        }
    };

    var chart_A3 = {
        series: [
            @foreach ($reliable_performer as $val)
                {
                    name: "{{ strtoupper($val->employee_name) }}",
                    data: [
                        [
                            {{ $val->performance_total }}, {{ $val->competency_total }}
                        ]
                    ]
                },
            @endforeach
        ],
        chart: {
            height: 125,
            type: 'scatter',
            toolbar: {
                show: false
            },
        },
        grid: {
            show: false
        },
        xaxis: {
            min: 101,
            max: 150,
            tickAmount: 5,
            tickPlacement: 'on',
            position: 'bottom',
            labels: {
                show: true
            },
            axisBorder: {
                show: false
            },
        },
        yaxis: {
            show: false,
            min: 0,
            max: 75
        },
        legend: {
            show: false
        }
    };

    var chart_B1 = {
        series: [
            @foreach ($under_performer as $val)
                {
                    name: "{{ strtoupper($val->employee_name) }}",
                    data: [
                        [
                            {{ $val->performance_total }}, {{ $val->competency_total }}
                        ]
                    ]
                },
            @endforeach
        ],
        chart: {
            height: 125,
            type: 'scatter',
            toolbar: {
                show: false
            },
        },
        grid: {
            show: false
        },
        xaxis: {
            min: 0,
            max: 85,
            tickAmount: 5,
            tickPlacement: 'on',
            position: 'bottom',
            labels: {
                show: true
            },
            axisBorder: {
                show: false
            },
        },
        yaxis: {
            show: false,
            min: 76,
            max: 85
        },
        legend: {
            show: false
        }
    };

    var chart_B2 = {
        series: [
            @foreach ($expected_performer as $val)
                {
                    name: "{{ strtoupper($val->employee_name) }}",
                    data: [
                        [
                            {{ $val->performance_total }}, {{ $val->competency_total }}
                        ]
                    ]
                },
            @endforeach
        ],
        chart: {
            height: 125,
            type: 'scatter',
            toolbar: {
                show: false
            },
        },
        grid: {
            show: false
        },
        xaxis: {
            min: 86,
            max: 100,
            tickAmount: 5,
            tickPlacement: 'on',
            position: 'bottom',
            labels: {
                show: true
            },
            axisBorder: {
                show: false
            },
        },
        yaxis: {
            show: false,
            min: 75,
            max: 86
        },
        legend: {
            show: false
        }
    };

    var chart_B3 = {
        series: [
            @foreach ($key_contributor as $val)
                {
                    name: "{{ strtoupper($val->employee_name) }}",
                    data: [
                        [
                            {{ $val->performance_total }}, {{ $val->competency_total }}
                        ]
                    ]
                },
            @endforeach
        ],
        chart: {
            height: 125,
            type: 'scatter',
            toolbar: {
                show: false
            },
        },
        grid: {
            show: false
        },
        xaxis: {
            min: 101,
            max: 150,
            tickAmount: 5,
            tickPlacement: 'on',
            position: 'bottom',
            labels: {
                show: true
            },
            axisBorder: {
                show: false
            },
        },
        yaxis: {
            show: false,
            min: 76,
            max: 85
        },
        legend: {
            show: false
        }
    };

    var chart_C1 = {
        series: [
            @foreach ($possible_potential_star as $val)
                {
                    name: "{{ strtoupper($val->employee_name) }}",
                    data: [
                        [
                            {{ $val->performance_total }}, {{ $val->competency_total }}
                        ]
                    ]
                },
            @endforeach
        ],
        chart: {
            height: 125,
            type: 'scatter',
            toolbar: {
                show: false
            },
        },
        grid: {
            show: false
        },
        xaxis: {
            min: 0,
            max: 85,
            tickAmount: 5,
            tickPlacement: 'on',
            position: 'bottom',
            labels: {
                show: true
            },
            axisBorder: {
                show: false
            },
        },
        yaxis: {
            show: false,
            min: 86
        },
        legend: {
            show: false
        }
    };

    var chart_C2 = {
        series: [
            @foreach ($possible_future_star as $val)
                {
                    name: "{{ strtoupper($val->employee_name) }}",
                    data: [
                        [
                            {{ $val->performance_total }}, {{ $val->competency_total }}
                        ]
                    ]
                },
            @endforeach
        ],
        chart: {
            height: 125,
            type: 'scatter',
            toolbar: {
                show: false
            },
        },
        grid: {
            show: false
        },
        xaxis: {
            min: 86,
            max: 100,
            tickAmount: 5,
            tickPlacement: 'on',
            position: 'bottom',
            labels: {
                show: true
            },
            axisBorder: {
                show: false
            },
        },
        yaxis: {
            show: false,
            min: 86
        },
        legend: {
            show: false
        }
    };

    var chart_C3 = {
        series: [
            @foreach ($star as $val)
                {
                    name: "{{ strtoupper($val->employee_name) }}",
                    data: [
                        [
                            {{ $val->performance_total }}, {{ $val->competency_total }}
                        ]
                    ]
                },
            @endforeach
        ],
        chart: {
            height: 125,
            type: 'scatter',
            toolbar: {
                show: false
            },
        },
        grid: {
            show: false
        },
        xaxis: {
            min: 101,
            max: 150,
            tickAmount: 5,
            tickPlacement: 'on',
            position: 'bottom',
            labels: {
                show: true
            },
            axisBorder: {
                show: false
            },
        },
        yaxis: {
            show: false,
            min: 86
        },
        legend: {
            show: false
        }
    };

    var chart_A1 = new ApexCharts(document.querySelector("#chart_A1"), chart_A1).render();
    var chart_A2 = new ApexCharts(document.querySelector("#chart_A2"), chart_A2).render();
    var chart_A3 = new ApexCharts(document.querySelector("#chart_A3"), chart_A3).render();
    var chart_B1 = new ApexCharts(document.querySelector("#chart_B1"), chart_B1).render();
    var chart_B2 = new ApexCharts(document.querySelector("#chart_B2"), chart_B2).render();
    var chart_B3 = new ApexCharts(document.querySelector("#chart_B3"), chart_B3).render();
    var chart_C1 = new ApexCharts(document.querySelector("#chart_C1"), chart_C1).render();
    var chart_C2 = new ApexCharts(document.querySelector("#chart_C2"), chart_C2).render();
    var chart_C3 = new ApexCharts(document.querySelector("#chart_C3"), chart_C3).render();
</script>