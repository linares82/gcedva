<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImpresionComprobanteE extends Model
{
	use RelationManagerTrait, GetAllDataTrait;
	use SoftDeletes;

	protected $table = 'impresion_comprobante_es';

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = ['inscripcion_id', 'cliente_id', 'plantel_id', 'especialidad_id', 'nivel_id', 'turno_id', 'lectivo_id', 'periodo_estudio_id', 'grado_id', 'grupo_id', 'token', 'usu_alta_id', 'usu_mod_id'];

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
