@extends('layouts.app')

@section('content')

<div class="container-fluid" data-aos="fade-in">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #b0ecff">
            <li class="breadcrumb-item"><i class="bi-house-door-fill"></i>&nbsp;<a href="{{ route('home') }}"> Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Master Jabatan</li>
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
                <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#modalPosition">
                    Tambah Jabatan
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="data_tables" class="table table-striped" width="100%">
                <thead class="bg-app-table">
                    <tr>
                        <th width="20">No.</th>
                        <th width="100">Departemen</th>
                        <th width="100">Nama Jabatan</th>
                        <th width="100">Skor Kompetensi</th>
                        <th width="50">Pilihan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($position as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ isset($data->department) ? strtoupper($data->department->department_name) : '-' }}</td>
                            <td>{{ strtoupper($data->position_desc) }}</td>
                            <td>{{ $data->position_score }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" onclick="editRow('{{ $data->position_id }}')">
                                    <i class="bi-pencil"></i>
                                </button>
                                <a href="{{ url('position/detail').'/'.$data->position_id }}" class="btn btn-sm btn-warning">
                                    <i class="bi-list"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteRow('{{ $data->position_id }}')">
                                    <i class="bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
	</div>

    <div class="modal fade" id="modalPosition" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel">Jabatan</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form id="form_data">
                    @csrf

                    <div class="modal-body">
                        <input id="position_id" type="hidden" name="position_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label">Nama Jabatan (Posisi) <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input id="position_desc" name="position_desc" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-6 col-form-label">Departemen <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <select id="department_id" name="department_id" class="form-select">
                                            <option value="" selected>-</option>
                                            @foreach ($department as $value)
                                                <option value="{{ $value->department_id }}">{{ strtoupper($value->department_name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="submitForm()">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
/* Reset Modal Form
/* ======================================================== */

$('#modalPosition').on('hidden.bs.modal', function () {
    $('#modalPosition form')[0].reset();
    $('#position_id').val("");
});

/* Konfigurasi DataTables
/* ======================================================== */

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
    });

    $('#searching').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('select#pagelength').on('change', function() {
        table.page.len(this.value).draw();
    });
});

/* Simpan ke Database
/* ======================================================== */

function submitForm() {
    let form        = document.querySelector('#form_data');
    let data        = new FormData(form);
    let url         = "{{ route('save-position') }}";
    let csrf_token  = document.getElementsByTagName("META")[2].content;

    const options = {
        headers: {'X-CSRF-TOKEN': csrf_token}
    };

    axios.post(url, data, options)
        .then((response) => {
            if (response.data.success == true)
            {
                Swal.fire({
                    icon    : 'success',
                    title   : 'SUCCESS !',
                    text    : 'Data berhasil disimpan',
                    showConfirmButton: true
                }).then((result) => {
                    window.location = "{{ url('position') }}";
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

/* Edit dari Database
/* ======================================================== */

function editRow(position_id)
{
    var myModal = new bootstrap.Modal(document.getElementById('modalPosition'), { keyboard: false });
    myModal.show();

    var url = "{{ url('position') }}" + "/" + position_id;

    axios.get(url)
        .then((response) => {
            if (response.data.success == true)
            {
                document.getElementById('position_id').value = position_id;
                document.getElementById('position_desc').value = response.data.position.position_desc;
                document.getElementById('department_id').value = response.data.position.department_id;
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

/* Hapus dari Database
/* ======================================================== */

function deleteRow(position_id)
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
            let url = "{{ url('position/delete') }}" + "/" + position_id;

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
                            window.location = "{{ url('position') }}";
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
    })
}
</script>

@endsection
