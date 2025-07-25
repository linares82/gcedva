<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultaCalificacion extends Model
{
	use RelationManagerTrait, GetAllDataTrait;
	use SoftDeletes;

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = [
		'matricula',
		'periodo_escolar',
		'materia',
		'codigo',
		'creditos',
		'lectivo',
		'calificacion',
		'tipo_examen',
		'grupo',
		'usu_alta_id',
		'usu_mod_id',
		'grupo',
		'nombre_oficial',
		'bnd_oficial',
		'id_asignatura',
		'nombre_asignatura',
		'ciclo',
		'id_observaciones',
		'observaciones'
	];

	public function usu_alta()
	{
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	} // end

	public function usu_mod()
	{
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	} // end


	protected $dates = ['deleted_at'];
}
