<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prebeca extends Model
{
	use RelationManagerTrait, GetAllDataTrait;
	use SoftDeletes;

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = ['cliente_id', 'motivo_beca_id', 'obs_prebeca', 'porcentaje_beca_id', 'usu_alta_id', 'usu_mod_id'];

	public function usu_alta()
	{
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	} // end

	public function usu_mod()
	{
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	} // end

	public function motivoBeca()
	{
		return $this->hasOne('App\MotivoBeca', 'id', 'motivo_beca_id');
	} // end

	public function porcentajeBeca()
	{
		return $this->hasOne('App\PorcentajeBeca', 'id', 'porcentaje_beca_id');
	} // end

	protected $dates = ['deleted_at'];
}
