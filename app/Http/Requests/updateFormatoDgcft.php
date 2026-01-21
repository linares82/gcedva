<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateFormatoDgcft extends FormRequest
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
            'plantel_id' => "required",
            'control_parte_fija' => 'required|max:8|min:8',
            //'control_inicio' => 'required|max:4|min:4',
        ];
    }

    public function messages()
    {
        return [
            'plantel_id.required' => "Campo requerido"
        ];
    }
}
