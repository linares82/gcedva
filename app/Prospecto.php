<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prospecto extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
		$this->addRelationApp( new \App\StProspecto, 'name' );  // generated by relation command - StProspecto,Prospecto
		$this->addRelationApp( new \App\Plantel, 'razon' );  // generated by relation command - Plantel,Prospecto
		$this->addRelationApp( new \App\Nivel, 'name' );  // generated by relation command - Nivel,Prospecto
		$this->addRelationApp( new \App\Especialidad, 'name' );  // generated by relation command - Especialidad,Prospecto
		$this->addRelationApp( new \App\Medio, 'name' );  // generated by relation command - Medio,Prospecto
    } 

	//Mass Assignment
	protected $fillable = ['nombre','nombre2','ape_paterno','ape_materno','tel_fijo','tel_cel','mail','plantel_id','especialidad_id','nivel_id','medio_id','st_prospecto_id','usu_alta_id','usu_mod_id','cliente_id','fecha','bnd_liga_enviada'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end


    protected $dates = ['deleted_at'];

	// generated by relation command - StProspecto,Prospecto - start
	public function stProspecto() {
		return $this->belongsTo('App\StProspecto');
	}// end

	// generated by relation command - Plantel,Prospecto - start
	public function plantel() {
		return $this->belongsTo('App\Plantel');
	}// end

	// generated by relation command - Nivel,Prospecto - start
	public function nivel() {
		return $this->belongsTo('App\Nivel');
	}// end

	// generated by relation command - Especialidad,Prospecto - start
	public function especialidad() {
		return $this->belongsTo('App\Especialidad');
	}// end

	// generated by relation command - Medio,Prospecto - start
	public function medio() {
		return $this->belongsTo('App\Medio');
	}// end
}