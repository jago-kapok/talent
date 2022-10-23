<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RespondenPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'res_nik'               => 'min:16|unique:App\Models\Responden,res_nik,'.\Request::instance()->res_id,
            'res_nama_lengkap'      => 'required',
            'res_no_kk'             => 'min:16',
            'res_jenis_kelamin'     => 'required',
            'res_tempat_lahir'      => 'required',
            'res_tanggal_lahir'     => 'required',
            'res_agama_id'          => 'required',
            'res_status_kawin'      => 'required',
            'res_pendidikan_id'     => 'required',
            'res_pekerjaan_id'      => 'required',
            'res_penghasilan_id'    => 'required',
            'res_desa_id'           => 'required',
            'res_rt'                => 'min:3',
            'res_rw'                => 'min:3',
            'res_alasan_id'         => 'required'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'res_nik.min'                   => 'NIK harus berisi 16 digit angka',
            'res_nik.unique'                => 'NIK sudah digunakan',
            'res_nama_lengkap.required'     => 'Nama lengkap harus diisi',
            'res_no_kk.min'                 => 'No. KK harus berisi 16 digit angka',
            'res_jenis_kelamin.required'    => 'Jenis kelamin harus dipilih',
            'res_tempat_lahir.required'     => 'Tempat lahir harus diisi',
            'res_tanggal_lahir.required'    => 'Tanggal lahir harus diisi',
            'res_agama_id.required'         => 'Agama harus dipilih',
            'res_status_kawin.required'     => 'Status perkawinan harus dipilih',
            'res_pendidikan_id.required'    => 'Pendidikan harus dipilih',
            'res_pekerjaan_id.required'     => 'Pekerjaan harus dipilih',
            'res_penghasilan_id.required'   => 'Penghasilan harus dipilih',
            'res_desa_id.required'          => 'Silakan pilih Desa / Kelurahan',
            'res_rw.min'                    => 'RW harus berisi 3 digit angka',
            'res_rt.min'                    => 'RT harus berisi 3 digit angka',
            'res_alasan_id.required'        => 'Alasan belum menikah harus dipilih'
        ];
    }
}
