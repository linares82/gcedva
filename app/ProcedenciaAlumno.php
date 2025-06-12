<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcedenciaAlumno extends Model
{
	use RelationManagerTrait, GetAllDataTrait;
	use SoftDeletes;

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = ['cliente_id', 'institucion_procedencia', 'sep_t_estudio_antecedente_id', 'estado_id', 'fecha_inicio', 'fecha_terminacion', 'numero_cedula', 'usu_alta_id', 'usu_mod_id'];

	public function usu_alta()
	{
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	} // end

	public function usu_mod()
	{
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	} // end

	public function sepTEstudioAntecedente()
	{
		return $this->hasOne('App\SepTEstudioAntecedente', 'id', 'sep_t_estudio_antecedente_id');
	} // end

	public function cliente()
	{
		return $this->hasOne('App\Cliente', 'id', 'cliente_id');
	} // end

	public function estado()
	{
		return $this->hasOne('App\Estado', 'id', 'estado_id');
	} // end

	protected $dates = ['deleted_at'];
}
