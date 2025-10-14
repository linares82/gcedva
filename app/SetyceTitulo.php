<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class SetyceTitulo extends Model
{
	use RelationManagerTrait, GetAllDataTrait;
	use SoftDeletes;

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = [
		'setyce_lote_id',
		'cliente_id',
		'carrera',
		'fecha_inicio',
		'fechat_terminacion',
		'folio',
		'curp',
		'nombre',
		'primer_apellido',
		'segundo_apellido',
		'correo_electronico',
		'fecha_expedicion',
		'sep_modalidad_titulacion_id',
		'fecha_examen_profesional',
		'cumplio_servicio_social',
		'sep_fundamento_legal_servicio_social_id',
		'sep_t_estudio_antecedente_id',
		'entidad_expedicion',
		'institucion_procedencia',
		'entidad_antecedente',
		'fecha_inicio_antecedente',
		'fecha_terminoa_antecedente',
		'no_cedula',
		'usu_alta_id',
		'usu_mod_id'
	];

	public function usu_alta()
	{
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	} // end

	public function usu_mod()
	{
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	} // end

	public function cliente()
	{
		return $this->hasOne('App\Cliente', 'id', 'cliente_id');
	} // end

	protected $dates = ['deleted_at'];
}
