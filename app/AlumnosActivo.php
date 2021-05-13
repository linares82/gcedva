<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlumnosActivo extends Model
{
    //use SoftDeletes;

    protected $fillable = [
        'fec_proceso',
		'razon',
            'cliente_id',
            'matricula',
            'nombre',
            'nombre2',
            'ape_paterno',
            'ape_materno',
            'estatus_cliente',
            'concepto',
            'fec_nacimiento',
            'especialidad'
	];
}
