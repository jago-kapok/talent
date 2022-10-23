@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" data-aos="zoom-in">
        <div class="col-md-8">
            <div class="card border-top border-3 border-success p-2">
                <div class="card-body">
                    <form id="form_data">
                        <div class="row gx-5">
                            <div class="col-md-12">
                                <h5 class="mb-3"><i class="bi-person-plus"></i> <strong>Tambah Akun Pengguna</strong></h5>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Nama Lengkap <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-7">
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Username <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-7">
                                        <input name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Password <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-7">
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Konfirmasi Password <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-7">
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Kecamatan <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-7">
                                        <select id="kecamatan_id" name="kecamatan_id" class="form-select">
                                            <option value="" disabled selected>--- Pilih Kecamatan ---</option>
                                            @foreach ($ref_kecamatan as $kecamatan)
                                                <option value="{{ $kecamatan->id }}">{{ $kecamatan->kecamatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Desa / Kelurahan <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-7">
                                        <select id="desa_id" name="desa_id" class="form-select">
                                            <option value="" disabled selected>--- Pilih Desa / Kelurahan ---</option>
                                            @foreach ($ref_desa as $desa)
                                                <option value="{{ $desa->id }}" data-chained="{{ $desa->id_kecamatan }}">{{ $desa->desa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Hak Akses <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-7">
                                        <select name="level" class="form-select">
                                            <option value="1">Desa</option>
                                            <option value="2">Kecamatan</option>
                                            <option value="3">Kabupaten</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-5 col-form-label">Jadikan sebagai verifikator ?</label>
                                    <div class="col-md-7 mt-2">
                                        <input id="checkboxNoLabel" type="checkbox" name="access" class="form-check-input" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row gx-5">
                            <div class="col-md-12">
                                <hr>
                                <button id="btnSubmitForm" type="button" class="btn btn-primary float-end" onclick="return submitForm()">
                                    <i class="bi-clipboard-check">&nbsp;&nbsp;</i>Simpan Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#desa_id").chained("#kecamatan_id");

    /*
     *   Fungsi simpan ke database
     */

    function submitForm() {
        let form        = document.querySelector('#form_data');
        let data        = new FormData(form);
        let url         = "{{ route('store-pengguna') }}";
        let csrf_token  = document.getElementsByTagName("META")[2].content;

        const options = {
            headers: {'X-CSRF-TOKEN': csrf_token}
        };

        axios.post(url, data, options)
            .then((response) => {
                console.log(response);
                if (response.data.success == true)
                {
                    document.getElementById("btnSubmitForm").disabled = true;

                    Swal.fire({
                        icon: 'success',
                        text: 'Pengguna baru berhasil ditambahkan !',
                        showConfirmButton: true
                    }).then((result) => {
                        window.location = "{{ url('admin/pengguna') }}"
                    });
                }
                else {
                    $.each(response.data.message, function(index, value) {
                        $.notify(value, "error");
                    });
                }
            }, (error) => {
                console.log(error.response.data.errors);
                $.each(error.response.data.errors, function(index, value) {
                    $.notify(value, "error");
                });
            });
    }
</script>

@endsection
