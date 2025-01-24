<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class SepMaterium extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;
	public $table="sep_materias";

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    } 

	//Mass Assignment
	protected $fillable = ['name','plantel_id','usu_alta_id','usu_mod_id'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end

	public function plantel() {
		return $this->hasOne('App\Plantel', 'id', 'plantel_id');
	}
    protected $dates = ['deleted_at'];
}