@extends('layouts.app')

@section('content')

<div class="container-fluid" data-aos="fade-in">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #b0ecff">
            <li class="breadcrumb-item"><i class="bi-house-door-fill"></i>&nbsp;<a href="{{ route('home') }}"> Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Master Pegawai</li>
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
                <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#modalEmployee">
                    Tambah Pegawai
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="data_tables" class="table table-striped" width="100%">
                <thead class="bg-app-table">
                    <tr>
                        <th width="20">No.</th>
                        <th width="50">Kode Pegawai</th>
                        <th width="100">Nama Pegawai</th>
                        <th width="100">Jabatan</th>
                        <th width="100">Unit Kerja</th>
                        <th width="50">Pilihan</th>
                    </tr>
                </thead>
                @foreach ($employee as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $data->employee_code }}</td>
                        <td>{{ strtoupper($data->employee_name) }}</td>
                        <td>{{ strtoupper($data->position->position_desc) }}</td>
                        <td>{{ strtoupper($data->employee_work_location) }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" onclick="editRow('{{ $data->employee_id }}')">
                                <i class="bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteRow('{{ $data->employee_id }}')">
                                <i class="bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
	</div>

    <div class="modal fade" id="modalEmployee" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel">Pegawai</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form id="form_data">
                    @csrf

                    <div class="modal-body">
                        <input id="employee_id" type="hidden" name="employee_id">
                        <div class="row mb-2">
                            <h5 class="text-primary"><i class="bi-check-circle"></i>&nbsp;&nbsp;<b>INFORMASI PEGAWAI</b></h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Kode Pegawai</label>
                                    <div class="col-md-6">
                                        <input id="employee_code" name="employee_code" class="form-control">
                                        <span class="form-text">Diisi dengan NIK / NIP Pegawai</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input id="employee_name" name="employee_name" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Tanggal Lahir</label>
                                    <div class="col-md-6">
                                        <input type="date" id="employee_birthdate" name="employee_birthdate" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Tanggal Join Perusahaan</label>
                                    <div class="col-md-6">
                                        <input type="date" id="employee_join_date" name="employee_join_date" class="form-control">
                                    </div>
                                </div>                                
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Job Family</label>
                                    <div class="col-md-6">
                                        <input id="employee_job_family" name="employee_job_family" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label">Divisi / Departemen <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <select id="department_id" name="department_id" class="form-select">
                                                <option disabled selected>-</option>
                                                @foreach ($department as $value)
                                                    <option value="{{ $value->department_id }}">{{ $value->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label">Jabatan Saat Ini<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <select id="position_id" name="position_id" class="form-select">
                                                <option disabled selected>-</option>
                                                @foreach ($position as $value)
                                                    <option value="{{ $value->position_id }}">{{ $value->position_desc }}</option>
                                                @endforeach
                                            </select>
                                            <a href="{{ route('position') }}" class="btn btn-info" target="_blank"><i class="bi-plus-lg"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label">Unit Kerja</label>
                                    <div class="col-md-6">
                                        <input id="employee_work_location" name="employee_work_location" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label">Tanggal SK Jabatan Terakhir</label>
                                    <div class="col-md-6">
                                        <input type="date" id="employee_experience_sk_date" name="employee_experience_sk_date" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label">Person Grade</label>
                                    <div class="col-md-6">
                                        <input id="employee_person_grade" name="employee_person_grade" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label">Job Grade</label>
                                    <div class="col-md-6">
                                        <input id="employee_job_grade" name="employee_job_grade" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2 mt-3">
                            <h5 class="text-primary"><i class="bi-check-circle"></i>&nbsp;&nbsp;<b>RIWAYAT PENDIDIKAN & PEKERJAAN</b></h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Nama Perguruan Tinggi</label>
                                    <div class="col-md-6">
                                        <input id="employee_education_campus" name="employee_education_campus" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Nama Jurusan</label>
                                    <div class="col-md-6">
                                        <input id="employee_education_major" name="employee_education_major" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Tahun Kelulusan</label>
                                    <div class="col-md-6">
                                        <input type="number" id="employee_education_graduation_year" name="employee_education_graduation_year" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label">Nama Perusahaan</label>
                                    <div class="col-md-6">
                                        <input id="employee_experience_company" name="employee_experience_company" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label">Nama Jabatan</label>
                                    <div class="col-md-6">
                                        <input id="employee_experience_position" name="employee_experience_position" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label">Periode </label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <select id="employee_experience_month" name="employee_experience_month" class="form-select">
                                                <option disabled selected>-</option>
                                                <option value="Januari">Januari</option>
                                                <option value="Februari">Februari</option>
                                                <option value="Maret">Maret</option>
                                                <option value="April">April</option>
                                                <option value="Mei">Mei</option>
                                                <option value="Juni">Juni</option>
                                                <option value="Juli">Juli</option>
                                                <option value="Agustus">Agustus</option>
                                                <option value="September">September</option>
                                                <option value="Oktober">Oktober</option>
                                                <option value="November">November</option>
                                                <option value="Desember">Desember</option>
                                            </select>
                                            <input type="number" id="employee_experience_year" name="employee_experience_year" class="form-control">
                                        </div>
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
/* Konfigurasi Autocomplete
/* ======================================================== */



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
        order           : [1, 'asc'],
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
    let url         = "{{ route('save-employee') }}";
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
                    window.location = "{{ url('employee') }}";
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

function editRow(employee_id)
{
    var myModal = new bootstrap.Modal(document.getElementById('modalEmployee'), { keyboard: false });
    myModal.show();

    var url = "{{ url('employee') }}" + "/" + employee_id;

    axios.get(url)
        .then((response) => {
            if (response.data.success == true)
            {
                document.getElementById('employee_id').value = employee_id;
                document.getElementById('employee_code').value = response.data.employee.employee_code;
                document.getElementById('employee_name').value = response.data.employee.employee_name;
                document.getElementById('department_id').value = response.data.employee.department_id;
                document.getElementById('position_id').value = response.data.employee.position_id;
                document.getElementById('employee_work_location').value = response.data.employee.employee_work_location;
                document.getElementById('employee_join_date').value = response.data.employee.employee_join_date;
                document.getElementById('employee_birthdate').value = response.data.employee.employee_birthdate;
                document.getElementById('employee_experience_sk_date').value = response.data.employee.employee_experience_sk_date;
                document.getElementById('employee_experience_company').value = response.data.employee.employee_experience_company;
                document.getElementById('employee_experience_position').value = response.data.employee.employee_experience_position;
                document.getElementById('employee_experience_month').value = response.data.employee.employee_experience_month;
                document.getElementById('employee_experience_year').value = response.data.employee.employee_experience_year;
                document.getElementById('employee_education_campus').value = response.data.employee.employee_education_campus;
                document.getElementById('employee_education_major').value = response.data.employee.employee_education_major;
                document.getElementById('employee_education_graduation_year').value = response.data.employee.employee_education_graduation_year;
                document.getElementById('employee_job_family').value = response.data.employee.employee_job_family;
                document.getElementById('employee_job_grade').value = response.data.employee.employee_job_grade;
                document.getElementById('employee_person_grade').value = response.data.employee.employee_person_grade;
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

function deleteRow(employee_id)
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
            let url = "{{ url('employee/delete') }}" + "/" + employee_id;

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
                            window.location = "{{ url('employee') }}";
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
