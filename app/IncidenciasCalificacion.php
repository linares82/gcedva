<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncidenciasCalificacion extends Model
{
	use RelationManagerTrait, GetAllDataTrait;
	use SoftDeletes;

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = [
		'calificacion_id',
		'calificacion_ponderacion_id',
		'cliente_id',
		'calificacion_nueva',
		'justificacion',
		'respuesta',
		'bnd_autorizada',
		'bnd_rechazada',
		'fecha_ar',
		'usu_alta_id',
		'usu_mod_id',
		'hacademica_id',
		'materium_id',
		'observacion',
		'imagen'
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

	public function calificacion()
	{
		return $this->hasOne('App\Calificacion', 'id', 'calificacion_id');
	} // end

	public function calificacionPonderacion()
	{
		return $this->hasOne('App\CalificacionPonderacion', 'id', 'calificacion_ponderacion_id');
	} // end

	public function hacademica()
	{
		return $this->hasOne('App\Hacademica', 'id', 'hacademica_id');
	} // end

	public function materium()
	{
		return $this->hasOne('App\Materium', 'id', 'materium_id');
	} // end
	protected $dates = ['deleted_at'];
}
