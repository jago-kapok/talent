<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetugasPostRequest extends FormRequest
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
            'tanggal_pendataan'   => 'required',
            'nama_pendata'        => 'required',
            'tanggal_pemeriksaan' => 'required',
            'nama_pemeriksa'      => 'required',
            'hasil_pendataan'     => 'required'
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
            'tanggal_pendataan.required'    => 'Tanggal pendataan harus diisi',
            'nama_pendata.required'         => 'Nama pendata harus diisi',
            'tanggal_pemeriksaan.required'  => 'Tanggal pemeriksaan harus diisi',
            'nama_pemeriksa.required'       => 'Nama pemeriksa harus diisi',
            'hasil_pendataan.required'      => 'Hasil pendataan harus diisi'
        ];
    }
}
