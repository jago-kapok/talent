
<script>
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
            url: "{{ action('UsersController@userData') }}"
        },
        columnDefs: [
            { orderable: false, targets: 0 },
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

/* Deactivate User */

function deactivateUser(user_id)
{
    Swal.fire({
        title: 'PERHATIAN !',
        text: "Anda ingin menonaktifkan pengguna ini ?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            let url = "{{ url('admin/pengguna/deactivate') }}" + "/" + user_id;

            axios.post(url)
                .then((response) => {
                    if (response.data.success == true)
                    {
                        Swal.fire({
                            icon: 'success',
                            text: 'Pengguna berhasil dinon-aktifkan !',
                            showConfirmButton: true
                        }).then((result) => {
                            location.reload();
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

/* Activate User */

function activateUser(user_id)
{
    Swal.fire({
        title: 'PERHATIAN !',
        text: "Anda ingin mengaktifkan pengguna ini ?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            let url = "{{ url('admin/pengguna/activate') }}" + "/" + user_id;

            axios.post(url)
                .then((response) => {
                    if (response.data.success == true)
                    {
                        Swal.fire({
                            icon: 'success',
                            text: 'Pengguna berhasil diaktifkan !',
                            showConfirmButton: true
                        }).then((result) => {
                            location.reload();
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

/* Reset Password */

function resetPassword(user_id)
{
    Swal.fire({
        title: 'PERHATIAN !',
        text: "Anda ingin mereset ke password default ?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            let url = "{{ url('admin/pengguna/reset-password') }}" + "/" + user_id;

            axios.post(url)
                .then((response) => {
                    if (response.data.success == true)
                    {
                        Swal.fire({
                            icon: 'success',
                            text: 'Password berhasil diubah ke default : admin123',
                            showConfirmButton: true
                        }).then((result) => {
                            location.reload();
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