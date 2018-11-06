<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createHistorial extends FormRequest
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
            'archivo_file' => 'max:100',
        ];
    }
    
    public function messages(){
        return [
        'archivo_file.max' => 'Archivo no debe exceder 100 kb',
        'archivo_file.mimes' => 'Archivo invalido, usar formato jpeg, jpg o png',
        ];
    }
}
