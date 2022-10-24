@extends('layouts.app')

@section('content')

<div class="container-fluid" data-aos="fade-in">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #b0ecff">
            <li class="breadcrumb-item"><i class="bi-house-door-fill"></i>&nbsp;<a href="{{ route('home') }}"> Beranda</a></li>
            <li class="breadcrumb-item" aria-current="page">Riwayat Penilaian</li>
            <li class="breadcrumb-item active" aria-current="page">Kompetensi</li>
        </ol>
    </nav>

    <div class="card border-top border-3 border-info p-4">
        <div class="row">
            <div class="col-md-6 mb-2">
                <div class="row gx-2">
                    <div class="col-md-2">
                        <select id="pagelength" class="form-select" readonly>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-10">
                        <input id="searching" type="text" class="form-control" placeholder="Pencarian ...">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="data_tables" class="table table-striped" width="100%">
                <thead class="bg-app-table">
                    <tr>
                        <th width="20">No.</th>
                        <th width="100">Tanggal Penilaian</th>
                        <th width="100">Nama Pegawai</th>
                        <th width="100">Jabatan</th>
                        <th width="50">Kompetensi Total</th>
                        <th width="50">Job Fit (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($competency as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ date('d-M-Y', strtotime($data->competency_date)) }}</td>
                            <td>{{ strtoupper($data->employee_name) }}</td>
                            <td>{{ $data->position_desc }}</td>
                            <td>{{ $data->competency_total }}</td>
                            <td>{{ round($data->competency_percent, 0) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
	</div>
</div>

<script>
$(document).ready(function() {
    var table = $('#data_tables').DataTable({
        processing : true,
        language : {
            lengthMenu    : "_MENU_",
            infoFiltered  : "",
            zeroRecords   : "<center>Tidak Ada Data</center>",
            processing    : "<center>Silakan Tunggu</center>",
            paginate      :
            {
                previous: "<<",
                next: ">>"
            },
        },
        bInfo           : true,
        bLengthChange   : false,
        order           : [1, 'desc'],
    });

    $('#searching').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('select#pagelength').on('change', function() {
        table.page.len(this.value).draw();
    });
});
</script>

@endsection
