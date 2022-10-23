@extends('layouts.app')

@section('content')

<div class="container-fluid" data-aos="zoom-in">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #b0ecff">
            <li class="breadcrumb-item"><i class="bi-house-door-fill"></i>&nbsp;<a href="{{ route('home') }}"> Beranda</a></li>
            <li class="breadcrumb-item">&nbsp;<a href="{{ route('position') }}">Master Jabatan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kompetensi</li>
        </ol>
    </nav>

    <div class="card border-top border-3 border-info p-4">
        <form id="form_data">
            @csrf

            <div class="row">
                <input type="hidden" name="position_id" value="{{ $position->position_id }}">
                <h4 class="fw-bold">{{ $position->position_desc }}</h4>
                
                <label class="col-form-label">Pilih item penilaian (kompetensi) :</label>
                <div class="row">
                    @foreach ($competency as $value)
                        <div class="col-md-3">
                            <div class="form-check form-check-inline mb-2">
                                <input type="hidden" name="competency_score[]" value="{{ $value->competency_score }}">
                                <input id="com_{{ $value->competency_id }}" type="checkbox" name="competency_id[]" class="form-check-input" 
                                    value="{{ $value->competency_id }}"
                                    {{ in_array($value->competency_id, $competency_roles) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="com_{{ $value->competency_id }}">
                                    {{ $value->competency_desc }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary float-right" onclick="submitForm()"><i class="bi-save"></i>
                        &nbsp; Simpan
                    </button>
                    <a href="{{ route('position') }}" class="btn btn-outline-danger"><i class="bi-x-square"></i>
                        &nbsp; Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
/* Simpan ke Database
/* ======================================================== */

function submitForm() {
    let form        = document.querySelector('#form_data');
    let data        = new FormData(form);
    let url         = "{{ url('position/detail') }}";
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
                    // location.reload();
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
</script>

@endsection

@section('footer-script')
    @include('scripts.competency')
@endsection