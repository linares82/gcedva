<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createAutorizacionBeca extends FormRequest
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
            'archivo_file' => "required",
            'cliente_id'=> "required",
            'monto_mensualidad'=> "required",
            'lectivo_id'=> "required_if:bnd_tiene_vigencia-field,1",
            'tipo_beca_id'=> "required",
            'motivo_beca_id'=> "required",
            'mensualidad_sep'=> "required",

        ];
    }

    public function messages()
    {
        return [
            'archivo_file.required' =>  'Necesita cargar un archivo'
        ];
    }
}
