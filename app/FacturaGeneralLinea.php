<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacturaGeneralLinea extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
		$this->addRelationApp( new \App\Pago, 'fecha' );  // generated by relation command - Pago,FacturaGeneralLinea
		$this->addRelationApp( new \App\Caja, 'fecha' );  // generated by relation command - Caja,FacturaGeneralLinea
		$this->addRelationApp( new \App\Cliente, 'nombre' );  // generated by relation command - Cliente,FacturaGeneralLinea
		$this->addRelationApp( new \App\FacturaGeneral, 'uuid' );  // generated by relation command - FacturaGeneral,FacturaGeneralLinea
    } 

	//Mass Assignment
	protected $fillable = ['factura_general_id','cliente_id','caja_id','pago_id','bnd_incluido','usu_alta_id','usu_mod_id','monto'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end


    protected $dates = ['deleted_at'];

	// generated by relation command - Pago,FacturaGeneralLinea - start
	public function pago() {
		return $this->belongsTo('App\Pago');
	}// end

	// generated by relation command - Caja,FacturaGeneralLinea - start
	public function caja() {
		return $this->belongsTo('App\Caja');
	}// end

	// generated by relation command - Cliente,FacturaGeneralLinea - start
	public function cliente() {
		return $this->belongsTo('App\Cliente');
	}// end

	// generated by relation command - FacturaGeneral,FacturaGeneralLinea - start
	public function facturaGeneral() {
		return $this->belongsTo('App\FacturaGeneral');
	}// end
}