<?php

namespace App\Http\Requests;

use App\Rules\UserMailUnique;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            //'email'=>[new UserMailUnique]
        ];
    }

    public function messages(){
        return [
            'email.unique'=>"El correo electronico ya esta en uso con otro usuario."
        ];
    }
}
