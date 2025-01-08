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
            'plantel_id'=>"required"
        ];
    }

    public function messages(){
        return [
            'plantel_id.required'=>"Campo requerido"
        ];
    }    
}
