<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class CcuestionarioPreguntum extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;
    //protected $table = 'ccuestionario_preguntas';

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
	$this->addRelationApp( new \App\Ccuestionario, 'name' );  // generated by relation command - Ccuestionario,CcuestionarioPreguntum
    } 

	//Mass Assignment
	protected $fillable = ['ccuestionario_id','numero','name','usu_mod_id','usu_alta_id'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end

        protected $dates = ['deleted_at'];

	// generated by relation command - Ccuestionario,CcuestionarioPreguntum - start
	public function cuestionario() {
		return $this->belongsTo('App\Ccuestionario');
	}// end
        
	// generated by relation command - CcuestionarioPreguntum,CcuestionarioRespuestum - start
	public function ccuestionarioRespuestum() {
		return $this->hasMany('App\CcuestionarioRespuestum');
	}// end

	// generated by relation command - CcuestionarioPreguntum,CcuestionarioRespuestum - start
	public function ccuestionarioRespuesta() {
		return $this->hasMany('App\CcuestionarioRespuestum');
	}// end
        
}