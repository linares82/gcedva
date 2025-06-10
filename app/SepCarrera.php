<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;


class SepCarrera extends Model
{
	use RelationManagerTrait, GetAllDataTrait;


	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = ['cve_carrera', 'descripcion', 'id_area', 'area', 'cve_subarea', 'subarea', 'id_nivel_sirep', 'nivel_educativo', 'num_rvoe'];

	public function usu_alta()
	{
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	} // end

	public function usu_mod()
	{
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	} // end


}
