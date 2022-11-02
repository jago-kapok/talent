@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row gx-3" data-aos="zoom-in">
        <div class="col-md-3 mb-2">
            <div class="card border-top border-2 border-info p-3 mb-3">
                <h6 class="text-black-50 mb-2 fw-bold">Data Pegawai</h6>
                <div class="row">
                    <div class="text-center">
                        <img src="https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_1280.png" class="img-fluid rounded-circle mb-2" width="150">
                        <br><span class="text-black fw-bold mb-3">{{ strtoupper($employee->employee_name) }}</span>
                        <br><span class="text-secondary fst-italic mb-3">{{ $employee->employee_code }}</span>
                        <br><span class="text-secondary mb-3">{{ $employee->position->position_desc }}</span>
                    </div>
                </div>
            </div>

            <div class="card border-top border-2 border-info p-3 mb-3">
                <h6 class="text-black-50 mb-3 fw-bold">Nilai Kompetensi Terakhir</h6>

                @foreach ($last_competency as $value)
                    <div class="form-text">{{ $value->competency_desc }} <span style="float:right"><b>{{ $value->competency_result }}</b></span></div>
                    <div class="progress mb-2" style="height:.5rem">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $value->competency_result / 5 * 100 }}%"
                            aria-valuenow="{{ $value->competency_result }}"
                            aria-valuemin="0"
                            aria-valuemax="5"
                        ></div>
                    </div>
                @endforeach
            </div>

            <div class="card border-top border-2 border-info p-3 mb-3">
                <h6 class="text-black-50 mb-3 fw-bold">Nilai Performa Terakhir</h6>

                @foreach ($last_performance as $value)
                    <div class="form-text">Tahun {{ $value->performance_year }} <span style="float:right"><b>{{ $value->performance_result }}</b></span></div>
                    <div class="progress mb-2" style="height:.5rem">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $value->performance_result / 200 * 100 }}%"
                            aria-valuenow="{{ $value->performance_result }}"
                            aria-valuemin="0"
                            aria-valuemax="200"
                        ></div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-9 mb-2">
            <div class="card border-top border-2 border-info p-3 mb-3">
            <form id="form_evaluation">
                @csrf
                <input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
                <h6 class="text-black-50 mb-3 fw-bold">Hasil Penilaian Terakhir</h6>
                <div class="row">
                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="card flex-fill p-1" style="background-color: #b0ecff">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <h1 class="fw-bold my-1">
                                            @if ($competency_value)
                                                {{ $competency_value->competency_total }} / {{ $employee->position->position_score }}
                                            @endif
                                        </h1>
                                        <p class="text-secondary fw-bold my-0">K O M P E T E N S I</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h1 class="fw-bold my-1">{{ $performance_value->performance_total }}</h1>
                                        <p class="text-secondary fw-bold my-0">P E R F O R M A</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h1 class="fw-bold my-1">
                                            @if ($competency_value)
                                                {{ round($competency_value->competency_percent, 0) }}%
                                            @endif
                                        </h1>
                                        <p class="text-secondary fw-bold my-0">J O B &nbsp;F I T</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 d-flex align-items-stretch">
                        <div class="card flex-fill p-0" style="background-color: #b0ecff">
                            <div class="card-body">
                                <div class="row text-center">
                                    <h1 class="text-black-50 fw-bold my-1">-</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mt-0">
                <div class="row">
                    <h6 class="text-black-50 mb-3 fw-bold">Input Penilaian Kompetensi :</h6>

                    <div class="row ge-5">
                        @foreach ($competency as $row)
                            <div class="col-md-4 border-end border-2">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="col-form-label">{{ $row->competency_desc }}</label>
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <input type="hidden" name="competency_id[]" class="form-control" value="{{ $row->competency_id }}">
                                        <input type="number" name="competency_result[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="row">
                    <h6 class="text-black-50 fw-bold">Input Penilaian Performa :</h6>

                    <div class="row ge-5">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="col-form-label">Tahun Penilaian</label>
                                    <select name="performance_year" class="form-select">
                                        @for ($i = date('Y'); $i >= date('Y') - 5 ; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="col-form-label">&nbsp;</label>
                                    <input type="number" name="performance_result" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <button id="btnSubmit" type="button" class="btn btn-primary float-right" onclick="submitEvaluation()"><i class="bi-save"></i>&nbsp; Submit Penilaian</button>
                        <a href="{{ route('evaluation') }}" class="btn btn-outline-danger"><i class="bi-x-square"></i>&nbsp; Kembali</a>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer-script')
    @include('scripts.evaluation')
@endsection