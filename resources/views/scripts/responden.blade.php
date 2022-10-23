<script>
    $("#desa_id").chained("#kecamatan_id");

    /*
     *   Checkbox alasan belum menikah
     */

    @if (!in_array(1, $responden_alasan))
        $("#res_alasan_biaya").hide();
    @endif

    $('#alasan_1').on('click', function() {
        if ($(this).is(":checked")) {
            $(".cb_alasan").nextAll().find('input').attr("disabled", true);
            $(".cb_alasan").nextAll().find('input').prop("checked", false);
            $("#res_alasan_biaya").show();
        } else {
            $(".cb_alasan").nextAll().find('input').attr("disabled", false);
            $("#res_alasan_biaya").hide();
        }
    });
    

    /*
     *   Fungsi simpan ke database
     */

    function submitForm() {
        let form        = document.querySelector('#form_data');
        let data        = new FormData(form);
        let url         = "{{ route('responden') }}";
        let csrf_token  = document.getElementsByTagName("META")[2].content;

        const options = {
            headers: {'X-CSRF-TOKEN': csrf_token}
        };

        axios.post(url, data, options)
            .then((response) => {
                if (response.data.success == true)
                {
                    document.getElementById("btnSubmitForm").disabled = true;
                    $.notify(response.data.message, "success");

                    setInterval(() => {
                        window.location = "{{ url('admin/orangtua') }}" + "/" + response.data.main_id
                    }, 1000);
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