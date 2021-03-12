<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createProspecto extends FormRequest
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
            'plantel_id'=>"min:1|not_in:0",
            'nivel_id'=>"min:1|not_in:0",
            'especialidad_id'=>"min:1|not_in:0",
        ];
    }
}
