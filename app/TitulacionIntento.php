<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class TitulacionIntento extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
		$this->addRelationApp( new \App\Titulacion, 'id' );  // generated by relation command - Titulacion,TitulacionIntento
    } 

	//Mass Assignment
	protected $fillable = ['titulacion_id','intento','fec_examen','opcion_titulacion_id','usu_alta_id','usu_mod_id', 'bnd_titulado'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end


    protected $dates = ['deleted_at'];

	// generated by relation command - Titulacion,TitulacionIntento - start
	public function titulacion() {
		return $this->belongsTo('App\Titulacion');
	}// end

	// generated by relation command - TitulacionIntento,TitulacionPago - start
	public function titulacionPagos() {
		return $this->hasMany('App\TitulacionPago');
	}// end
}