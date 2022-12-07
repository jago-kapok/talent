@extends('layouts.app')

@section('content')

<style>
    .rotate {
        /*writing-mode: vertical-rl;*/
        /*transform: rotate(180deg);*/
        transform: rotate(90deg);
        margin-bottom: -0.3em !important;
    }
    .matrix-primary {
        border-bottom: .5em solid #1e70f8 !important; background-color: rgb(40 114 243 / 10%);
    }
    .matrix-secondary {
        border-bottom: .5em solid #6c757d !important; background-color: rgb(108 117 125 / 10%);
    }
    .matrix-info {
        border-bottom: .5em solid #2ccbee !important; background-color: rgb(60 204 236 / 10%);
    }
    .matrix-warning {
        border-bottom: .5em solid #fdc032 !important; background-color: rgb(251 191 69 / 10%);
    }
    .matrix-danger {
        border-bottom: .5em solid #d93348 !important; background-color: rgb(214 49 74 / 10%);
    }
    .matrix-success {
        border-bottom: .5em solid #238757 !important; background-color: rgb(43 135 89 / 10%);
    }
</style>

<div class="container-fluid">
    <div class="row gx-3" data-aos="zoom-in">
        <div class="col-md-3 mb-2">
            <div class="card p-3 mb-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-black-50 mb-2"><strong>Total Pegawai</strong></h6>
                        <h1 class="my-0 fw-bold" style="font-size: 2.5rem">{{ count($employee) }}</h1>
                    </div>

                    <div class="btn card-icon-score" style="background-color: #d0e1fd">
                        <i class="bi-people text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="card p-3 mb-3">
                <h6 class="text-black-50 mb-2 fw-bold">Pegawai Berdasarkan Jabatan</h6>
                <div class="row">
                    <div class="m-0">
                        <div id="chart_"></div>
                    </div>
                </div>
            </div>

            <div class="card p-3 mb-3">
                <h6 class="text-black-50 mb-3 fw-bold">Pegawai Berdasarkan Jabatan</h6>

                @foreach ($employee_position as $data)
                    <div class="form-text">{{ strtoupper($data->position_desc) }} <span style="float:right"><b>{{ $data->position_total }}</b></span></div>
                    <div class="progress mb-2" style="height:.5rem">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $data->position_total / count($employee) * 100 }}%"
                            aria-valuenow="{{ $data->position_total }}"
                            aria-valuemin="0"
                            aria-valuemax="{{ count($employee) }}"
                        ></div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-9 mb-2">
            <div class="card" data-aos="zoom-in">
                <div class="row justify-content-center">
                    <div class="col-md-12 mb-lg-0">
                        <div class="container-fluid">
                            <p class="text-smart fst-italic text-center mt-3">9-BOX TALENT MANAGEMENT</p>
                        </div>
                    </div>
                    
                    <div class="row gx-3">
                        <div class="col-md-1 border-end border-4 border-default d-none d-lg-block ps-sm-0 ps-lg-5 me-2">
                            <!-- <h6 class="fw-bold fst-italic rotate"><i class="bi-arrow-up"></i>&nbsp; COMPETENCY</h6> -->

                            <h6 class="fw-bold rotate">C</h6>
                            <h6 class="fw-bold rotate">O</h6>
                            <h6 class="fw-bold rotate">M</h6>
                            <h6 class="fw-bold rotate">P</h6>
                            <h6 class="fw-bold rotate">E</h6>
                            <h6 class="fw-bold rotate">T</h6>
                            <h6 class="fw-bold rotate">E</h6>
                            <h6 class="fw-bold rotate">N</h6>
                            <h6 class="fw-bold rotate">C</h6>
                            <h6 class="fw-bold rotate">Y</h6>
                        </div>

                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card border border-success matrix-success">
                                        <h5 class="text-black">Possible Potential Star
                                            <div class="btn-group float-right">
                                                <a href="javascript:void(0)" class="text-primary" data-bs-toggle="dropdown"><i class="bi-person-lines-fill"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @foreach ($possible_potential_star as $value)
                                                        <li>
                                                            <button class="dropdown-item" type="button">
                                                                {{ strtoupper($value->employee_name) }}
                                                                (P: {{ $value->performance_total }}, K: {{ $value->competency_total }})
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </h5>
                                        <div class="chart-container" style="position: relative; height:100px">
                                            <canvas id="chart_C1"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card border border-secondary matrix-secondary">
                                        <h5 class="text-black">Possible Future Star
                                            <div class="btn-group float-right">
                                                <a href="javascript:void(0)" class="text-primary" data-bs-toggle="dropdown"><i class="bi-person-lines-fill"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @foreach ($possible_future_star as $value)
                                                        <li>
                                                            <button class="dropdown-item" type="button">
                                                                {{ strtoupper($value->employee_name) }}
                                                                (P: {{ $value->performance_total }}, K: {{ $value->competency_total }})
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </h5>
                                        <div class="chart-container" style="position: relative; height:100px">
                                            <canvas id="chart_C2"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card border border-warning matrix-warning">
                                        <h5 class="text-black">Star
                                            <div class="btn-group float-right">
                                                <a href="javascript:void(0)" class="text-primary" data-bs-toggle="dropdown"><i class="bi-person-lines-fill"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @foreach ($star as $value)
                                                        <li>
                                                            <button class="dropdown-item" type="button">
                                                                {{ strtoupper($value->employee_name) }}
                                                                (P: {{ $value->performance_total }}, K: {{ $value->competency_total }})
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </h5>
                                        <div class="chart-container" style="position: relative; height:100px">
                                            <canvas id="chart_C3"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row gx-3">
                        <div class="col-md-1 border-end border-4 border-default d-none d-lg-block me-2">
                            <h6 class="fw-bold float-right">> 100</h6>
                        </div>

                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card border border-success matrix-success">
                                        <h5 class="text-black">Under Performer
                                            <div class="btn-group float-right">
                                                <a href="javascript:void(0)" class="text-primary" data-bs-toggle="dropdown"><i class="bi-person-lines-fill"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @foreach ($under_performer as $value)
                                                        <li>
                                                            <button class="dropdown-item" type="button">
                                                                {{ strtoupper($value->employee_name) }}
                                                                (P: {{ $value->performance_total }}, K: {{ $value->competency_total }})
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </h5>
                                        <div class="chart-container" style="position: relative; height:100px">
                                            <canvas id="chart_B1"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card border border-primary matrix-primary">
                                        <h5 class="text-black">Expected Performer
                                            <div class="btn-group float-right">
                                                <a href="javascript:void(0)" class="text-primary" data-bs-toggle="dropdown"><i class="bi-person-lines-fill"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @foreach ($expected_performer as $value)
                                                        <li>
                                                            <button class="dropdown-item" type="button">
                                                                {{ strtoupper($value->employee_name) }}
                                                                (P: {{ $value->performance_total }}, K: {{ $value->competency_total }})
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </h5>
                                        <div class="chart-container" style="position: relative; height:100px">
                                            <canvas id="chart_B2"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card border border-secondary matrix-secondary">
                                        <h5 class="text-black">Key Contributor
                                            <div class="btn-group float-right">
                                                <a href="javascript:void(0)" class="text-primary" data-bs-toggle="dropdown"><i class="bi-person-lines-fill"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @foreach ($key_contributor as $value)
                                                        <li>
                                                            <button class="dropdown-item" type="button">
                                                                {{ strtoupper($value->employee_name) }}
                                                                (P: {{ $value->performance_total }}, K: {{ $value->competency_total }})
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </h5>
                                        <div class="chart-container" style="position: relative; height:100px">
                                            <canvas id="chart_B3"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row gx-3">
                        <div class="col-md-1 border-end border-4 border-default d-none d-lg-block me-2">
                            <h6 class="fw-bold float-right">< 100</h6>
                        </div>

                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card border border-danger matrix-danger">
                                        <h5 class="text-black">Dead Wood
                                            <div class="btn-group float-right">
                                                <a href="javascript:void(0)" class="text-primary" data-bs-toggle="dropdown"><i class="bi-person-lines-fill"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @foreach ($dead_wood as $value)
                                                        <li>
                                                            <button class="dropdown-item" type="button">
                                                                {{ strtoupper($value->employee_name) }}
                                                                (P: {{ $value->performance_total }}, K: {{ $value->competency_total }})
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </h5>
                                        <div class="chart-container" style="position: relative; height:100px">
                                            <canvas id="chart_A1"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card border border-info matrix-info">
                                        <h5 class="text-black">Adequate Performer
                                            <div class="btn-group float-right">
                                                <a href="javascript:void(0)" class="text-primary" data-bs-toggle="dropdown"><i class="bi-person-lines-fill"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @foreach ($adequate_performer as $value)
                                                        <li>
                                                            <button class="dropdown-item" type="button">
                                                                {{ strtoupper($value->employee_name) }}
                                                                (P: {{ $value->performance_total }}, K: {{ $value->competency_total }})
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </h5>
                                        <div class="chart-container" style="position: relative; height:100px">
                                            <canvas id="chart_A2"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card border border-info matrix-info">
                                        <h5 class="text-black">Reliable Performer
                                            <div class="btn-group float-right">
                                                <a href="javascript:void(0)" class="text-primary" data-bs-toggle="dropdown"><i class="bi-person-lines-fill"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @foreach ($reliable_performer as $value)
                                                        <li>
                                                            <button class="dropdown-item" type="button">
                                                                {{ strtoupper($value->employee_name) }}
                                                                (P: {{ $value->performance_total }}, K: {{ $value->competency_total }})
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </h5>
                                        <div class="chart-container" style="position: relative; height:100px">
                                            <canvas id="chart_A3"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row gx-3">
                        <div class="col-md-1 d-none d-lg-block">&nbsp;</div>

                        <div class="col-md-10 d-none d-lg-block">
                            <div class="border-top border-4 border-default">
                                <div class="row mt-2">
                                    <div class="col-md-4 mb-3">
                                        <h6 class="fw-bold fst-italic">PERFORMANCE &nbsp;<i class="bi-arrow-right"></i></h6>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h6 class="fw-bold">95</h6>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h6 class="fw-bold">100</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer-script')
    @include('scripts.home')
@endsection