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
    const chart_A1 = document.getElementById('chart_A1');

    new Chart(chart_A1, {
        type: 'scatter',
        data: {
            datasets: [
                @foreach ($dead_wood as $val)
                    {
                        label: "{{ strtoupper($val->employee_name) }}",
                        data: [
                            [
                                {{ $val->performance_total }}, {{ $val->competency_total }}
                            ]
                        ],
                        borderWidth: 5
                    },
                @endforeach
            ]
        },
        options: {
            events: ['click'],
            scales: {
                x: {
                    display: false,
                    min: 0,
                    max: 95,
                },
                y: {
                    display: false,
                    min: 0,
                    max: 99
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 10,
                    titleFont: { size: 15 },
                    bodyFont: { size: 15 },
                    boxPadding: 10,
                    boxWidth: 10,
                    boxHeight: 10,
                    callbacks: {
                        title: function(context) {
                            return context[0].dataset.label;
                        },
                        label: function(context) {
                            return "P: " + context.parsed.x + ", K: " + context.parsed.y;
                        }
                    }
                }
            }
        }
    });

    const chart_A2 = document.getElementById('chart_A2');

    new Chart(chart_A2, {
        type: 'scatter',
        data: {
            datasets: [
                @foreach ($adequate_performer as $val)
                    {
                        label: "{{ strtoupper($val->employee_name) }}",
                        data: [
                            [
                                {{ $val->performance_total }}, {{ $val->competency_total }}
                            ]
                        ],
                        borderWidth: 5
                    },
                @endforeach
            ]
        },
        options: {
            events: ['click'],
            scales: {
                x: {
                    display: false,
                    min: 96,
                    max: 110,
                },
                y: {
                    display: false,
                    min: 0,
                    max: 110
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 10,
                    titleFont: { size: 15 },
                    bodyFont: { size: 15 },
                    boxPadding: 10,
                    boxWidth: 10,
                    boxHeight: 10,
                    callbacks: {
                        title: function(context) {
                            return context[0].dataset.label;
                        },
                        label: function(context) {
                            return "P: " + context.parsed.x + ", K: " + context.parsed.y;
                        }
                    }
                }
            }
        }
    });

    const chart_A3 = document.getElementById('chart_A3');

    new Chart(chart_A3, {
        type: 'scatter',
        data: {
            datasets: [
                @foreach ($reliable_performer as $val)
                    {
                        label: "{{ strtoupper($val->employee_name) }}",
                        data: [
                            [
                                {{ $val->performance_total }}, {{ $val->competency_total }}
                            ]
                        ],
                        borderWidth: 5
                    },
                @endforeach
            ]
        },
        options: {
            events: ['click'],
            scales: {
                x: {
                    display: false,
                    min: 100.1,
                },
                y: {
                    display: false,
                    min: 0,
                    max: 110
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 10,
                    titleFont: { size: 15 },
                    bodyFont: { size: 15 },
                    boxPadding: 10,
                    boxWidth: 10,
                    boxHeight: 10,
                    callbacks: {
                        title: function(context) {
                            return context[0].dataset.label;
                        },
                        label: function(context) {
                            return "P: " + context.parsed.x + ", K: " + context.parsed.y;
                        }
                    }
                }
            }
        }
    });

    const chart_B1 = document.getElementById('chart_B1');

    new Chart(chart_B1, {
        type: 'scatter',
        data: {
            datasets: [
                @foreach ($under_performer as $val)
                    {
                        label: "{{ strtoupper($val->employee_name) }}",
                        data: [
                            [
                                {{ $val->performance_total }}, {{ $val->competency_total }}
                            ]
                        ],
                        borderWidth: 5
                    },
                @endforeach
            ]
        },
        options: {
            events: ['click'],
            scales: {
                x: {
                    display: false,
                    min: 0,
                    max: 110,
                },
                y: {
                    display: false,
                    min: 110,
                    max: 110
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 10,
                    titleFont: { size: 15 },
                    bodyFont: { size: 15 },
                    boxPadding: 10,
                    boxWidth: 10,
                    boxHeight: 10,
                    callbacks: {
                        title: function(context) {
                            return context[0].dataset.label;
                        },
                        label: function(context) {
                            return "P: " + context.parsed.x + ", K: " + context.parsed.y;
                        }
                    }
                }
            }
        }
    });

    const chart_B2 = document.getElementById('chart_B2');

    new Chart(chart_B2, {
        type: 'scatter',
        data: {
            datasets: [
                @foreach ($expected_performer as $val)
                    {
                        label: "{{ strtoupper($val->employee_name) }}",
                        data: [
                            [
                                {{ $val->performance_total }}, {{ $val->competency_total }}
                            ]
                        ],
                        borderWidth: 5
                    },
                @endforeach
            ]
        },
        options: {
            events: ['click'],
            scales: {
                x: {
                    display: false,
                    min: 96,
                    max: 110,
                },
                y: {
                    display: false,
                    min: 110,
                    max: 110
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 10,
                    titleFont: { size: 15 },
                    bodyFont: { size: 15 },
                    boxPadding: 10,
                    boxWidth: 10,
                    boxHeight: 10,
                    callbacks: {
                        title: function(context) {
                            return context[0].dataset.label;
                        },
                        label: function(context) {
                            return "P: " + context.parsed.x + ", K: " + context.parsed.y;
                        }
                    }
                }
            }
        }
    });

    const chart_B3 = document.getElementById('chart_B3');

    new Chart(chart_B3, {
        type: 'scatter',
        data: {
            datasets: [
                @foreach ($key_contributor as $val)
                    {
                        label: "{{ strtoupper($val->employee_name) }}",
                        data: [
                            [
                                {{ $val->performance_total }}, {{ $val->competency_total }}
                            ]
                        ],
                        borderWidth: 5
                    },
                @endforeach
            ]
        },
        options: {
            events: ['click'],
            scales: {
                x: {
                    display: false,
                    min: 100.1
                },
                y: {
                    display: false,
                    min: 110,
                    max: 110
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 10,
                    titleFont: { size: 15 },
                    bodyFont: { size: 15 },
                    boxPadding: 10,
                    boxWidth: 10,
                    boxHeight: 10,
                    callbacks: {
                        title: function(context) {
                            return context[0].dataset.label;
                        },
                        label: function(context) {
                            return "P: " + context.parsed.x + ", K: " + context.parsed.y;
                        }
                    }
                }
            }
        }
    });

    const chart_C1 = document.getElementById('chart_C1');

    new Chart(chart_C1, {
        type: 'scatter',
        data: {
            datasets: [
                @foreach ($possible_potential_star as $val)
                    {
                        label: "{{ strtoupper($val->employee_name) }}",
                        data: [
                            [
                                {{ $val->performance_total }}, {{ $val->competency_total }}
                            ]
                        ],
                        borderWidth: 5
                    },
                @endforeach
            ]
        },
        options: {
            events: ['click'],
            scales: {
                x: {
                    display: false,
                    min: 0,
                    max: 110,
                },
                y: {
                    display: false,
                    min: 100.1
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 10,
                    titleFont: { size: 15 },
                    bodyFont: { size: 15 },
                    boxPadding: 10,
                    boxWidth: 10,
                    boxHeight: 10,
                    callbacks: {
                        title: function(context) {
                            return context[0].dataset.label;
                        },
                        label: function(context) {
                            return "P: " + context.parsed.x + ", K: " + context.parsed.y;
                        }
                    }
                }
            }
        }
    });

    const chart_C2 = document.getElementById('chart_C2');

    new Chart(chart_C2, {
        type: 'scatter',
        data: {
            datasets: [
                @foreach ($possible_future_star as $val)
                    {
                        label: "{{ strtoupper($val->employee_name) }}",
                        data: [
                            [
                                {{ $val->performance_total }}, {{ $val->competency_total }}
                            ]
                        ],
                        borderWidth: 5
                    },
                @endforeach
            ]
        },
        options: {
            events: ['click'],
            scales: {
                x: {
                    display: false,
                    min: 90,
                    max: 110,
                },
                y: {
                    display: false,
                    min: 100.1
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 10,
                    titleFont: { size: 15 },
                    bodyFont: { size: 15 },
                    boxPadding: 10,
                    boxWidth: 10,
                    boxHeight: 10,
                    callbacks: {
                        title: function(context) {
                            return context[0].dataset.label;
                        },
                        label: function(context) {
                            return "P: " + context.parsed.x + ", K: " + context.parsed.y;
                        }
                    }
                }
            }
        }
    });

    const chart_C3 = document.getElementById('chart_C3');

    new Chart(chart_C3, {
        type: 'scatter',
        data: {
            datasets: [
                @foreach ($star as $val)
                    {
                        label: "{{ strtoupper($val->employee_name) }}",
                        data: [
                            [
                                {{ $val->performance_total }}, {{ $val->competency_total }}
                            ]
                        ],
                        borderWidth: 5
                    },
                @endforeach
            ]
        },
        options: {
            events: ['click'],
            scales: {
                x: {
                    display: false,
                    min: 100.1,
                },
                y: {
                    display: false,
                    min: 100.1
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 10,
                    titleFont: { size: 15 },
                    bodyFont: { size: 15 },
                    boxPadding: 10,
                    boxWidth: 10,
                    boxHeight: 10,
                    callbacks: {
                        title: function(context) {
                            return context[0].dataset.label;
                        },
                        label: function(context) {
                            return "P: " + context.parsed.x + ", K: " + context.parsed.y;
                        }
                    }
                }
            }
        }
    });
</script>