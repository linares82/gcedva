<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateInventario extends FormRequest
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
            'video1' => 'max:6144',
            'video2' => 'max:6144',
            'img1' => 'max:100',
            'img2' => 'max:100',
            'img3' => 'max:100',
            'img4' => 'max:100',
            'img5' => 'max:100',
            'img6' => 'max:100'
        ];
    }

    public function messages()
    {
        return [
            'video1.max' => 'Pesod de archivo maximo permitido 6 Mb',
            'img1.max' => 'Peso de archivo maximo permitido 75 Kb',
        ];
    }
}
