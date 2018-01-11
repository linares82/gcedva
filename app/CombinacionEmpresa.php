<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class CombinacionEmpresa extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    } 

	//Mass Assignment
	protected $fillable = ['empresa_id','plantel_id','especialidad_id','nivel_id','grado_id','usu_alta_id','usu_mod_id'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end
        
        public function especialidad() {
		return $this->belongsTo('App\Especialidad');
	}// end
        
        public function nivel() {
		return $this->belongsTo('App\Nivel');
	}// end
	public function grado() {
		return $this->belongsTo('App\Grado');
	}// end


    protected $dates = ['deleted_at'];
}