<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class updateCliente extends FormRequest
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
            //'cve_cliente',
            'nombre'=>'required',
            //'fec_registro',
            //'tel_fijo',
            //'tel_cel',
            //'mail'=>'email',
            //'calle',
            //'no_exterior',
            //'no_interior',
            //'colonia',
            //'cp',
            //'municipio_id',
            //'estado_id',
            //'st_cliente_id'=>'required',
            //'oferta_id',
            //'medio_id',
            //'expo',
            //'otro_medio',
            //'empleado_id'=>'required',
            //'promociones',
            //'promo_cel',
            //'promo_correo'
            /*'especialidad_id'=>[
                'required',
                Rule::notIn([0]),
            ],
            'nivel_id'=>[
                'required',
                Rule::notIn([0]),
            ],
            'grado_id'=>[
                'required',
                Rule::notIn([0]),
            ],*/
            'archivo'=>'requiredif:doc_cliente_id,1,2,3,4,5,6,7,8,9',
            'obs_docs'=>'requiredif:bnd_doc_oblig_entregados,1'
        ];
    }

    public function messages(){
        return [
        'nombre.required' => 'El campo es requerido!',
        'st_cliente_id.required'=>'El campo es requerido!',
        'empleado_id.required'=>'El campo es requerido!',
        'mail.email'=>'Formato de email incorrecto',
        'obs_docs.requiredif'=>"Campo Obs. Docs. es requerido",
        'especialidad_id.required'=>'El campo es requerido!',
        'nivel_id.required'=>'El campo es requerido!',
        'grado_id.required'=>'El campo es requerido!',
        ];
    }
}
