<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class createCalendarioExaExtra extends FormRequest
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
            'lectivo_id' => Rule::unique('calendario_exa_extras')->whereNull('deleted_at'),
        ];
    }

    public function messages()
    {
        return [
            'lectivo_id.unique' => 'El lectivo ya tiene un calendario.',
        ];
    }
}
