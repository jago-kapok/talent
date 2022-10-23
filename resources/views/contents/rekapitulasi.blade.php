@extends('layouts.app')

@section('content')

<div class="container-fluid" data-aos="fade-in">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #b0ecff">
            <li class="breadcrumb-item"><i class="bi-house-door-fill"></i>&nbsp;<a href="{{ route('home') }}"> Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rekapitulasi Data</li>
        </ol>
    </nav>

    <div class="card border-top border-3 border-success p-4">
        <div class="row">
            <div class="col-md-8 mb-2">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-text">Kecamatan</div>
                        <select id="kecamatan_id" class="form-select">
                            <option value="" selected>--- Semua Kecamatan ---</option>
                            @foreach ($ref_kecamatan as $val)
                                <option value="{{ $val->id }}">{{ $val->kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-text">Desa / Kelurahan</div>
                        <select id="desa_id" class="form-select">
                            <option value="" selected>--- Semua Desa / Kelurahan ---</option>
                            @foreach ($ref_desa as $val)
                                <option value="{{ $val->id }}" data-chained="{{ $val->id_kecamatan }}">{{ $val->desa }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4 pull-right mb-2">
                <div class="form-text">&nbsp;</div>
                <div class="input-group">
                    <input id="searching" type="text" class="form-control" placeholder="Pencarian berdasarkan NIK / Nama Responden ..." style="width:30rem" >
                    <select id="pagelength" class="form-select" readonly>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>

        <table id="table_data" class="table table-striped" width="100%">
            <thead class="bg-app-table">
                <tr>
                    <th width="20">No.</th>
                    <th width="100">Tanggal Pengisian</th>
                    <th width="100">Kecamatan</th>
                    <th width="100">Desa / Kelurahan</th>
                    <th width="100">N I K</th>
                    <th width="100">Nama Responden</th>
                    <th width="50">Usia</th>
                    <th width="100">Keterangan</th>
                    <th width="50">Status Verifikasi</th>
                    <th width="50">Pilihan</th>
                </tr>
            </thead>
        </table>
	</div>
</div>

<script>
$("#desa_id").chained("#kecamatan_id");

/* Datatables Rekapitulasi */

$(document).ready(function() {
    var table = $('#table_data').DataTable({
        processing : true,
        language : {
            lengthMenu	    : "_MENU_",
            infoFiltered    : "",
            zeroRecords	    : "<center>Tidak Ada Data</center>",
            processing	    : "<center>Silakan Tunggu</center>",
            paginate	    : {
                previous: "<<",
                next: ">>"
            },
        },
        bInfo 		    : true,
        bLengthChange   : false,
        serverSide	    : true,
        scrollX		    : true,
        serverSide      : true,
        ajax : {
            method: "GET",
            url: "{{ action('RekapitulasiController@respondenData') }}"
        },
        columnDefs: [
            { orderable: false, targets: 0 },
            { orderable: false, targets: 7 },
            { visible: true, targets: 8 }
        ],
        order: [1, 'desc'],
    });

    $('#searching').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('select#pagelength').on('change', function() {
        table.page.len(this.value).draw();
    });

    $('select#kecamatan_id').on('change', function() {
        table.columns(2).search(this.value).draw();
    });

    $('select#desa_id').on('change', function() {
        table.columns(3).search(this.value).draw();
    });
});

/* Hapus Data Survey */

function deleteData(res_id)
{
    Swal.fire({
        title: 'PERHATIAN !',
        text: "Anda yakin ingin menghapus data ini ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            let url = "{{ url('admin/responden') }}" + "/" + res_id;

            axios.delete(url)
                .then((response) => {
                    if (response.data.success == true)
                    {
                        Swal.fire({
                            icon: 'success',
                            text: 'Data berhasil dihapus !',
                            showConfirmButton: true
                        });

                        $('#table_data').DataTable().draw();
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
    })
}
</script>

@endsection
