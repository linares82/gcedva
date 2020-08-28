<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createCuentaP extends FormRequest
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
            'name' => 'unique:cuenta_ps,name',
            'clave' => 'unique:cuenta_ps,clave'
        ];
    }
}
