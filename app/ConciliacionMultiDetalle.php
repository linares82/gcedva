<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConciliacionMultiDetalle extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    } 

	//Mass Assignment
	protected $fillable = ['conciliacion_multipago_id','fecha_pago','razon_social','mp_node','mp_concept',
	'mp_paymentmethod','mp_reference','mp_order','no_aprobacion','identificador_venta','ref_medio_pago',
	'importe','comision','iva_comision','fecha_dispersion','periodo_financiamiento','moneda','banco_emisor',
	'mp_customername','mail','tel_customername','usu_alta_id','usu_mod_id'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end


    protected $dates = ['deleted_at'];
}