<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createIncidenciasCalificacion extends FormRequest
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
            'imagen' => "required_if:tpo_examen_id,4",
        ];
    }

    public function messages()
    {
        return [
            'imagen.required' => "Se re quiere evidencia",
        ];
    }
}
