<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProspectoInforme extends Model
{
	use RelationManagerTrait, GetAllDataTrait;
	use SoftDeletes;

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = [
		'prospecto_parte_informe_id',
		'prospecto_etiqueta_id',
		'detalle',
		'usu_alta_id',
		'usu_mod_id',
		'prospecto_id'
	];

	public function usu_alta()
	{
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	} // end

	public function usu_mod()
	{
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	} // end

	public function parteInforme()
	{
		return $this->hasOne('App\ProspectoParteInforme', 'id', 'prospecto_parte_informe_id');
	} // end

	public function etiqueta()
	{
		return $this->hasOne('App\ProspectoEtiquetum', 'id', 'prospecto_etiqueta_id');
	} // end


	protected $dates = ['deleted_at'];
}
