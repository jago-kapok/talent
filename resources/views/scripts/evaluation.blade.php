<script>
    /*
     *   Fungsi simpan ke database
     */

    function submitEvaluation() {
        let form        = document.querySelector('#form_evaluation');
        let data        = new FormData(form);
        let url         = "{{ url('evaluation') }}";
        let csrf_token  = document.getElementsByTagName("META")[2].content;

        const options = {
            headers: {'X-CSRF-TOKEN': csrf_token}
        };

        axios.post(url, data, options)
            .then((response) => {
            	console.log(response);
                if (response.data.success == true)
                {
                    document.getElementById("btnSubmit").disabled = true;
                    
                    Swal.fire({
                        icon    : 'success',
                        title   : 'SUCCESS !',
                        text    : 'Penilaian kompetensi dan performa berhasil disimpan',
                        showConfirmButton: true
                    }).then((result) => {
                        window.location = "{{ url('evaluation') }}";
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