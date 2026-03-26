<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarioAsignacionPonderacion extends Model
{
	use RelationManagerTrait, GetAllDataTrait;
	use SoftDeletes;

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = ['asignacion_id', 'carga_ponderacion_id', 'fec_inicio', 'fec_fin', 'usu_alta_id', 'usu_mod_id'];

	public function usu_alta()
	{
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	} // end

	public function usu_mod()
	{
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	} // end

	public function cargaPonderacion()
	{
		return $this->hasOne('App\CargaPonderacion', 'id', 'carga_ponderacion_id');
	} // end

	public function asignacion()
	{
		return $this->belongsTo('App\AsignacionAcademica', 'asignacion_id', 'id');
	} // end


	protected $dates = ['deleted_at'];
}
