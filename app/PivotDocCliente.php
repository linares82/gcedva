<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class PivotDocCliente extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
		$this->addRelationApp( new \App\Cliente, 'nombre' );  // generated by relation command - Area,Empleado
		$this->addRelationApp( new \App\DocAlumno, 'name' );  // generated by relation command - Area,Empleado
        parent::__construct($attributes);
    } 

	//Mass Assignment
	protected $fillable = ['cliente_id','doc_alumno_id','archivo','usu_alta_id','usu_mod_id','doc_entregado'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end

	public function cliente() {
		return $this->belongsTo('App\Cliente');
	}// end
	public function docAlumno() {
		return $this->belongsTo('App\DocAlumno');
	}// end


    protected $dates = ['deleted_at'];
}