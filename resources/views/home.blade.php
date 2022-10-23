@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row" data-aos="zoom-in">
        @if ($password_match == 1)
            <div class="col-md-12">
                <div class="alert alert-danger mx-1" role="alert">
                    1. Mohon segera melakukan penggantian password.<br>
                    2. Segala bentuk kebocoran data yang diakibatkan karena belum mengganti password, menjadi tanggungjawab pemilik akun.
                </div>
            </div>
        @endif

        <div class="col-md-3 mb-2">
            <div class="card p-4 mb-4">
                <div class="d-flex justify-content-between mb-1">
                    <div class="w-100">
                        <h5 class="fw-bold text-black-50">Total Survey</h5>
                        <h1 class="mb-4"><strong><span class="count">{{ $total_survey[0]->terisi_lengkap + $total_survey[0]->tidak_terisi_lengkap }}</span></strong> <span style="font-size: 1rem"></span></h1>
                        
                        <span class="badge" style="background-color: #2be39a; height: 16px; width: 16px; border-radius: 0;">&nbsp;</span>&nbsp; <span style="vertical-align:middle">
                            Lengkap : {{ $total_survey[0]->terisi_lengkap }}
                        </span>
                        <br>
                        <span class="badge" style="background-color: #f7b41d; height: 16px; width: 16px; border-radius: 0;">&nbsp;</span>&nbsp; <span style="vertical-align:middle">
                            Tidak Lengkap : {{ $total_survey[0]->tidak_terisi_lengkap }}
                        </span>
                    </div>

                    <div class="flex-shrink-1">
                        <div id="chart_"></div>
                    </div>
                </div>

                <div class="row px-2 mt-3">
                    <a href="{{ route('responden') }}" class="btn btn-sm bg-app"><i class="bi-pencil-square"></i>&nbsp; Klik ! Untuk Mengisi Survey</a>
                </div>
            </div>

            <div class="card p-4">
                <h5 class="fw-bold">Statistik Alasan Belum Menikah</h5>

                @foreach ($total_by_alasan as $alasan)
                    <div class="form-text">{{ $alasan->deskripsi }} <span style="float:right"><b>{{ $alasan->total }}</b></span></div>
                    <div class="progress mb-2" style="height:.5rem">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ ($alasan->total / count($responden)) * 100 }}%"
                            aria-valuenow="{{ $alasan->total }}"
                            aria-valuemin="0"
                            aria-valuemax="{{ count($responden) }}"
                        ></div>
                    </div>
                @endforeach

                <div id="chart32"></div>
            </div>
        </div>

        <div class="col-md-9 mb-2">
            <div class="card p-4" data-aos="fade-up">
                <div class="">
                    <h5 class="fw-bold">Statistik Hasil Pendataan di {{ $hasil_survey }}</h5>
                    @if (Auth::user()->level == 4)
                        <div style="float: right">
                            <div class="dropdown col-md-5">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Urutkan berdasarkan
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="orderData('kecamatan', 'asc')">Kecamatan (A-Z)</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="orderData('kecamatan', 'desc')">Kecamatan (Z-A)</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="orderData('total', 'asc')">Data Paling Sedikit</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="orderData('total', 'desc')">Data Terbanyak</a></li>
                            </ul>
                            </div>
                        </div>
                    @endif
                </div>
                <div id="chart" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

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
</script>

<script>
    var options = {
        series: [
            {
                name: 'Lengkap',
                data: [
                    @foreach ($total_chart as $total)
                        '{{ $total->terisi_lengkap }}',
                    @endforeach
                ]
            },
            {
                name: 'Tidak Terisi Lengkap',
                color: '#f15a5e',
                data: [
                    @foreach ($total_chart as $total)
                        '{{ $total->tidak_terisi_lengkap }}',
                    @endforeach
                ]
            }
	    ],
        chart: {
            type: 'bar',
            height: 500,
            stacked: true,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                fontSize: "15px",
                fontWeight: "bold"
            }
        },
        legend: {
            position: 'bottom'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom'
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 0
            },
        },
        xaxis: {
            categories: [
                @foreach ($total_chart as $total)
                    '{{ $total->category }}',
                @endforeach
            ],
        },
        fill: {
            opacity: 1
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

<script>
    var options = {
        series: [{{ $total_survey[0]->terisi_lengkap }}, {{ $total_survey[0]->tidak_terisi_lengkap }}],
        labels: ['Terisi Lengkap', 'Tidak Lengkap'],
        colors:['#2be39a', '#f7b41d'],
        chart: {
            type: 'donut',
            height: 170
        },
        legend: {
            show: false,
            position: 'bottom'
        },
        dataLabels: {
            enabled: false
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart_"), options);
    chart.render();
</script>

@endsection