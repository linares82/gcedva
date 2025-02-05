<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class SepGrupoSepMateria extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

	public $table="sep_grupo_sep_materia";

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    } 

	//Mass Assignment
	protected $fillable = ['sep_grupo_id','sep_materia_id','grado','duracion_horas','acuerdo','usu_alta_id','usu_mod_id'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end

	public function sepGrupo() {
		return $this->belongsTo('App\SepGrupo');
	}

	public function sepMateria() {
		return $this->belongsTo('App\SepMaterium');
	}


    protected $dates = ['deleted_at'];
}