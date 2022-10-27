<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProspectoAsignacionTarea extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    } 

	//Mass Assignment
	protected $fillable = ['prospecto_id','empleado_id','prospecto_tarea_id','prospecto_asunto_id','prospecto_st_tarea_id','obs','detalle','usu_alta_id','usu_mod_id'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end

	public function prospectoTarea() {
		return $this->belongsTo('App\ProspectoTarea');
	}

	public function prospectoAsunto() {
		return $this->belongsTo('App\ProspectoAsunto');
	}

	public function prospectoStTarea() {
		return $this->belongsTo('App\ProspectoStTarea');
	}

	public function empleado() {
		return $this->belongsTo('App\Empleado');
	}

    protected $dates = ['deleted_at'];
}