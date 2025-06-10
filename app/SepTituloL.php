<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;


class SepTituloL extends Model
{
	use RelationManagerTrait, GetAllDataTrait;

	protected $table = "sep_titulo_ls";

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = ['sep_titulo_id', 'cliente_id', 'bnd_descargar', 'usu_mod_id', 'usu_alta_id'];

	public function usu_alta()
	{
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	} // end

	public function usu_mod()
	{
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	} // end

	public function sepTitulo()
	{
		return $this->hasOne('App\SepTitulo', 'id', 'sep_titulo_id');
	} // end

	public function cliente()
	{
		return $this->hasOne('App\Cliente', 'id', 'cliente_id');
	} // end
}
