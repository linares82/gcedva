<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createCliente extends FormRequest
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
        //dd($this->request);
        return [
            //'cve_cliente',
            'nombre' => 'required',
            'ape_paterno' => 'required',
            'ape_materno' => 'required',
            //'fec_registro',
            'tel_fijo' => 'required',
            'tel_cel' => 'required',
            'mail' => 'required',
            'plantel_id' => 'between:1,1000',
            'especialidad_id' => 'required|integer|between:1,1000',
            'nivel_id' => 'required|integer|between:1,1000',
            'grado_id' => 'required|integer|between:1,1000',
            'medio_id' => 'required|integer|between:1,1000',
            //'turno_id'=>'required|integer|between:1,1000',
            //'mail'=>'email',
            //'calle',
            //'no_exterior',
            //'no_interior',
            //'colonia',
            //'cp',
            //'municipio_id',
            //'estado_id',
            //'st_cliente_id' => 'required',
            //'oferta_id',
            //'medio_id',
            //'expo',
            //'otro_medio',
            'empleado_id' => 'required',
            //'promociones',
            //'promo_cel',
            //'promo_correo'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El campo es requerido!',
            'ape_paterno.required' => 'El campo es requerido!',
            'ape_materno.required' => 'El campo es requerido!',
            'tel_fijo.required' => 'El campo es requerido!',
            'tel_cel.required' => 'El campo es requerido!',
            'mail.required' => 'El campo es requerido!',
            'plantel_id.between' => 'El campo es requerido!',
            'especialidad_id.between' => 'El campo es requerido!',
            'nivel_id.between' => 'El campo es requerido!',
            'grado_id.between' => 'El campo es requerido!',
            'medio_id.between' => 'El campo es requerido!',
            'turno_id.between' => 'El campo es requerido!',
            'st_cliente_id.required' => 'El campo es requerido!',
            'empleado_id.required' => 'El campo es requerido!',
            'tel_cel.unique' => 'Valor ya existe en otro registro',
            'mail.email' => 'Formato de email incorrecto',
        ];
    }
}
