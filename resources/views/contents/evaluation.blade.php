@extends('layouts.app')

@section('content')

<div class="container-fluid" data-aos="fade-in">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #b0ecff">
            <li class="breadcrumb-item"><i class="bi-house-door-fill"></i>&nbsp;<a href="{{ route('home') }}"> Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Penilaian Pegawai</li>
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
            
            <div class="col-md-6 mb-2">
                <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#addCompetency">Lakukan Penilaian</button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="data_tables" class="table table-striped" width="100%">
                <thead class="bg-app-table">
                    <tr>
                        <th width="20">No.</th>
                        <th width="100">Nama Lengkap</th>
                        <th width="100">Jabatan</th>
                        <th width="100">Performa (AVG)</th>
                        <th width="100">Job Fit (%)</th>
                        <th width="100">Keterangan</th>
                        <th width="50">Pilihan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluation as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ strtoupper($data->employee_name) }}</td>
                            <td>{{ strtoupper($data->position_desc) }}</td>
                            <td>{{ $data->performance_total }}</td>
                            <td>{{ round($data->competency_total, 0) }}%</td>
                            <td>
                                @if ($data->performance_total < 95)
                                    @if ($data->competency_total < 100)
                                        <span class="badge bg-danger">Dead Wood</span>
                                    @elseif ($data->competency_total > 100)
                                        <span class="badge bg-success">Possible Potential Star</span>
                                    @else
                                        <span class="badge bg-success">Under Performer</span>
                                    @endif
                                @elseif ($data->performance_total >= 95 && $data->performance_total < 100)
                                    @if ($data->competency_total < 100)
                                        <span class="badge bg-info">Adequate Performer</span>
                                    @elseif ($data->competency_total > 100)
                                        <span class="badge bg-secondary">Possible Future Star</span>
                                    @else
                                        <span class="badge bg-primary">Expected Performer</span>
                                    @endif
                                @else
                                    @if ($data->competency_total < 100)
                                        <span class="badge bg-info">Reliable Performer</span>
                                    @elseif ($data->competency_total > 100)
                                        <span class="badge bg-warning">Star</span>
                                    @else
                                        <span class="badge bg-secondary">Key Contributor</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('evaluation-edit', ['id'=>$data->employee_id]) }}" class="btn btn-sm btn-primary">
                                    <i class="bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteData('{{ $data->employee_id }}')">
                                    <i class="bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
	</div>
</div>

<div class="modal fade" id="addCompetency" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="staticBackdropLabel">Penilaian Pegawai</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form id="form_data">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Pilih Nama Pegawai <span class="text-danger">*</span></label>
            <select id="employee_id" name="employee_id" class="form-select" required>
              <option selected>-</option>
                @foreach ($employee as $data)
                  <option value="{{ $data->employee_id }}">{{ strtoupper($data->employee_name) }}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" onclick="startEvaluation()">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
/* Konfigurasi DataTables
/* ======================================================== */

$(document).ready(function() {
    var table = $('#data_tables').DataTable({
        processing : true,
        language : {
            lengthMenu      : "_MENU_",
            infoFiltered    : "",
            zeroRecords     : "<center>Tidak Ada Data</center>",
            processing      : "<center>Silakan Tunggu</center>",
            paginate        : {
                previous: "<<",
                next: ">>"
            },
        },
        bInfo           : true,
        bLengthChange   : false,
        // serverSide      : true,
        scrollX         : true,
        // ajax : {
        //     method: "GET",
        //     // url: "{{ url('/evaluation/data') }}"
        //     url: "{{ action('EvaluationController@getData') }}",
        // },
        columnDefs: [
            { orderable: false, targets: 0 },
            { orderable: false, targets: 5 }
        ],
        order: [0, 'asc'],
    });

    $('#searching').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('select#pagelength').on('change', function() {
        table.page.len(this.value).draw();
    });
});

/* Create Penilaian
/* ======================================================== */

function startEvaluation() {
    let employee_id = document.getElementById("employee_id").value;
    
    window.location = "{{ url('evaluation/create') }}" + "/" + employee_id;
}

/* Delete Penilaian
/* ======================================================== */
function deleteData(employee_id)
{
    Swal.fire({
        title: 'WARNING !',
        text: "Anda yakin ingin menghapus data ini ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            let url = "{{ url('evaluation') }}" + "/" + employee_id;

            axios.delete(url)
                .then((response) => {
                    if (response.data.success == true)
                    {
                        Swal.fire({
                            icon    : 'success',
                            title   : 'SUCCESS !',
                            text    : 'Data berhasil dihapus !',
                            showConfirmButton: true
                        }).then((result) => {
                            location.reload();
                        });
                    }
                }, (error) => {
                    console.log(error.response.data.errors);
                    Swal.fire({
                        icon    : 'error',
                        title   : 'ERROR !',
                        text    : 'Terjadi kesalahan saat koneksi ke server',
                        showConfirmButton: true
                    });
                });
        }
    });
}
</script>

@endsection
