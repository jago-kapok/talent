<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPostRequest extends FormRequest
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
            'id'                    => 'nullable',
            'name'                  => 'nullable',
            'code'                  => 'nullable',
            'email'                 => 'required|unique:App\Models\User',
            'password'              => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
            'level'                 => 'nullable',
            'access'                => 'nullable',
            'manager'               => 'nullable',
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
            'email.required'                    => 'Username harus diisi !',
            'email.unique'                      => 'Username sudah digunakan !',
            'password.required'                 => 'Password harus diisi !',
            'password.min'                      => 'Password minimal harus 8 karakter',
            'password_confirmation.required'    => 'Konfirmasi kata sandi tidak cocok',
        ];
    }
}
