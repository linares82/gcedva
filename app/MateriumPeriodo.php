<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class MateriumPeriodo extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    } 

	//Mass Assignment
	protected $fillable = ['materium_id','periodo_estudio_id','usu_alta_id','usu_mod_id'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end

        public function pivotMaterias(){
            return belongsTo('App\Materium');
        }
        
        public function pivotPeriodoEstudio(){
            return belongsTo('App\PeriodoEstudio');
        }
        
        
    protected $dates = ['deleted_at'];
}