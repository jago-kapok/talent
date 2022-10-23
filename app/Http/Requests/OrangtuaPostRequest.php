<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrangtuaPostRequest extends FormRequest
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
            'ortu_kategori'         => 'required',
            'ortu_nik'              => 'min:16|unique:App\Models\Orangtua,ortu_nik,'.$this->ortu_id,
            'ortu_nama_lengkap'     => 'required',
            'ortu_no_kk'            => 'min:16',
            'ortu_tempat_lahir'     => 'required',
            'ortu_tanggal_lahir'    => 'required',
            'ortu_agama_id'         => 'required',
            'ortu_pendidikan_id'    => 'required',
            'ortu_pekerjaan_id'     => 'required',
            'ortu_penghasilan_id'   => 'required',
            'ortu_desa_id'          => 'required',
            'ortu_rt'               => 'min:3',
            'ortu_rw'               => 'min:3'
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
            'ortu_kategori.required'        => 'Status orangtua / wali harus diisi',
            'ortu_nik.min'                  => 'NIK harus berisi 16 digit angka',
            'ortu_nik.unique'               => 'NIK sudah digunakan',
            'ortu_nama_lengkap.required'    => 'Nama lengkap harus diisi',
            'ortu_no_kk.min'                => 'No. KK harus berisi 16 digit angka',
            'ortu_tempat_lahir.required'    => 'Tempat lahir harus diisi',
            'ortu_tanggal_lahir.required'   => 'Tanggal lahir harus diisi',
            'ortu_agama_id.required'        => 'Agama harus dipilih',
            'ortu_pendidikan_id.required'   => 'Pendidikan harus dipilih',
            'ortu_pekerjaan_id.required'    => 'Pekerjaan harus dipilih',
            'ortu_penghasilan_id.required'  => 'Penghasilan harus dipilih',
            'ortu_desa_id.required'         => 'Silakan pilih Desa / Kelurahan',
            'ortu_rw.min'                   => 'RW harus berisi 3 digit angka',
            'ortu_rt.min'                   => 'RT harus berisi 3 digit angka'
        ];
    }
}
