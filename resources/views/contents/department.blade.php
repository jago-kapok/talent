@extends('layouts.app')

@section('content')

<div class="container-fluid" data-aos="fade-in">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #b0ecff">
            <li class="breadcrumb-item"><i class="bi-house-door-fill"></i>&nbsp;<a href="{{ route('home') }}"> Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Master Departemen</li>
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
                <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#modalDepartment">
                    Tambah Jabatan
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="data_tables" class="table table-striped" width="100%">
                <thead class="bg-app-table">
                    <tr>
                        <th width="20">No.</th>
                        <th width="100">Kode Departemen</th>
                        <th width="100">Nama Departemen</th>
                        <th width="100">Departemen Head</th>
                        <th width="50">Pilihan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($department as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data->department_code }}</td>
                            <td>{{ strtoupper($data->department_name) }}</td>
                            <td>{{ strtoupper($data->department_head_name) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" onclick="editRow('{{ $data->department_id }}')">
                                    <i class="bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteRow('{{ $data->department_id }}')">
                                    <i class="bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
	</div>

    <div class="modal fade" id="modalDepartment" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel">Departemen</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form id="form_data">
                    @csrf

                    <div class="modal-body">
                        <input id="department_id" type="hidden" name="department_id">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label">Kode Departemen <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input id="department_code" name="department_code" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label">Nama Departemen <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input id="department_name" name="department_name" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-6 col-form-label">Departemen Head</label>
                                    <div class="col-md-6">
                                        <select id="department_head" name="department_head" class="form-select">
                                            <option value="" selected>-</option>
                                            @foreach ($department_head as $value)
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

$('#modalDepartment').on('hidden.bs.modal', function () {
    $('#modalDepartment form')[0].reset();
    $('#department_id').val("");
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
    let url         = "{{ route('save-department') }}";
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
                    window.location = "{{ url('department') }}";
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

function editRow(department_id)
{
    var myModal = new bootstrap.Modal(document.getElementById('modalDepartment'), { keyboard: false });
    myModal.show();

    var url = "{{ url('department') }}" + "/" + department_id;

    axios.get(url)
        .then((response) => {
            if (response.data.success == true)
            {
                document.getElementById('department_id').value = department_id;
                document.getElementById('department_code').value = response.data.department.department_code;
                document.getElementById('department_name').value = response.data.department.department_name;
                document.getElementById('department_head').value = response.data.department.department_head;
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

function deleteRow(department_id)
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
            let url = "{{ url('department/delete') }}" + "/" + department_id;

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
                            window.location = "{{ url('department') }}";
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
