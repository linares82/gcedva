<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class SepGrupo extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    } 

	//Mass Assignment
	protected $fillable = ['name','secciones','plantel_id','cantidad_materias_para_aprobar','usu_alta_id','usu_mod_id'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end

	public function plantel() {
		return $this->hasOne('App\Plantel', 'id', 'plantel_id');
	}

	public function sepMateriasRels() {
		return $this->hasMany('App\SepGrupoSepMateria', 'sep_grupo_id', 'id');
	}


    protected $dates = ['deleted_at'];
}