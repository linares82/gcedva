<?php

namespace App;

use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormatoDgcft extends Model
{
    use RelationManagerTrait, GetAllDataTrait;
	use SoftDeletes;

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

    protected $fillable = ['name', 'enlace_operativo','plantel','direccion','cct','especialidad',
    'grupo','fec_elaboracion','fec_inicio','fec_fin','ciclo_escolar','fec_edad','duracion',
	'duracion_materias','horario','horario_inicio','horario_fin','cantidad_clientes',
    'clientes','control','escolaridad','beca','grados','materias','calificaciones','resultados','final',
	'directora_nombre','sceo_nombre','usu_alta_id', 'usu_mod_id'];

	public function usu_alta()
	{
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	} // end

	public function usu_mod()
	{
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	} // end

    public function formatoDgcftDetalles()
	{
		return $this->hasMany('App\FormatoDgcftDetalle');
	} // end


	protected $dates = ['deleted_at'];

}
