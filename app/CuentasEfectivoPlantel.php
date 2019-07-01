<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentasEfectivoPlantel extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    } 

	//Mass Assignment
	protected $fillable = ['cuentas_efectivo_id','plantel_id'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end
        
        public function plantel() {
		return $this->belongsTo('App\Plantel');
	}// end
        
        public function cuentasEfectivo() {
		return $this->belongsTo('App\CuentasEfectivo');
	}// end


    protected $dates = ['deleted_at'];
}