<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Plantel extends Model
{
	use RelationManagerTrait, GetAllDataTrait;
	use SoftDeletes;
	use RevisionableTrait;

	protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
	protected $historyLimit = 1000;

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->addRelationApp(new \App\Lectivo, 'name');  // generated by relation command - Lectivo,Plantel
		$this->addRelationApp(new \App\TpoPlantel, 'name');  // generated by relation command - Lectivo,Plantel
		$this->addRelationApp(new \App\StPlantel, 'name');  // generated by relation command - Lectivo,Plantel
		$this->addRelationApp(new \App\Estado, 'name');  // generated by relation command - Lectivo,Plantel
		$this->addRelationApp(new \App\CuentaP, 'name');  // generated by relation command - CuentaP,Plantel


	}

	//Mass Assignment
	protected $fillable = [
		'razon',
		'rfc',
		'cve_incorporacion',
		'tel',
		'mail',
		'pag_web',
		'lectivo_id',
		'logo',
		'slogan',
		'membrete',
		'usu_alta_id',
		'usu_mod_id',
		'calle',
		'no_int',
		'no_ext',
		'colonia',
		'cp',
		'municipio',
		'estado',
		'rvoe',
		'cct',
		'tpo_plantel_id',
		'meta_venta',
		'cve_plantel',
		'cns_alumno',
		'cns_empleado',
		'meta_total',
		'st_plantel_id',
		'consecutivo',
		'estado_id',
		'csc_cotizacion',
		'clausulas_cotizacion',
		'director_id',
		'responsable_id',
		'enlace_lugar',
		'enlace',
		'cve_estatal',
		'cve_centro',
		'img_firma',
		'cve_vinculacion',
		'csc_vinculacion',
		'denominacion',
		'nombre_corto',
		'cuenta_contable',
		'cve_multipagos',
		'cuenta_p_id',
		'regimen_fiscal',
		'fcuenta',
		'fpassword',
		'fusuario',
		'serie_factura',
		'folio_facturados',
		'matriz_id',
		'fact_global_id_cuenta',
		'fact_global_pass_cuenta',
		'fact_global_id_usu',
		'fact_global_pass_usu',
		'bnd_excepcion_documentos',
		'calificacion_aprobatoria',
		'oid',
		'opublica',
		'oprivada',
		'bnd_multipagos_activo',
		'bnd_openpay_activo',
		'sep_institucion_educativa_id',
		'sep_cert_institucion_id',
		'bnd_paycode',
		'password_paycode',
		'api_key_paycode',
		'webhook_openpay_id'
	];

	protected $dates = ['deleted_at'];

	// generated by relation command - Lectivo,Plantel - start
	public function lectivo()
	{
		return $this->belongsTo('App\Lectivo');
	} // end
	public function tpo_plantel()
	{
		return $this->belongsTo('App\TpoPlantel');
	} // end

	public function usu_alta()
	{
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	} // end

	public function usu_mod()
	{
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	} // end

	// generated by relation command - Plantel,Alumno - start
	public function alumnos()
	{
		return $this->hasMany('App\Alumno');
	} // end

	// generated by relation command - Plantel,Salon - start
	public function salons()
	{
		return $this->hasMany('App\Salon');
	} // end

	public function stPlantel()
	{
		return $this->hasMany('App\StPlantel');
	} // end

	// generated by relation command - Plantel,PeriodoEstudio - start
	public function periodoEstudios()
	{
		return $this->hasMany('App\PeriodoEstudio');
	} // end

	// generated by relation command - Plantel,Materium - start
	public function materias()
	{
		return $this->hasMany('App\Materium');
	} // end

	// generated by relation command - Plantel,Grupo - start
	public function grupos()
	{
		return $this->hasMany('App\Grupo');
	} // end

	// generated by relation command - Plantel,Hacademica - start
	public function hacademicas()
	{
		return $this->hasMany('App\Hacademica');
	} // end

	// generated by relation command - Plantel,Empresa - start
	public function empresas()
	{
		return $this->hasMany('App\Empresa');
	} // end

	// generated by relation command - Plantel,CombinacionCliente - start
	public function combinacionClientes()
	{
		return $this->hasMany('App\CombinacionCliente');
	} // end

	// generated by relation command - Plantel,Caja - start
	public function cajas()
	{
		return $this->hasMany('App\Caja');
	} // end

	public function estadoCatalogo()
	{
		return $this->belongsTo('App\Estado', 'estado_id', 'id');
	} // end


	// generated by relation command - Plantel,Egreso - start
	public function egresos()
	{
		return $this->hasMany('App\Egreso');
	} // end

	public function cuentasEfectivo()
	{
		return $this->belongsToMany('App\CuentasEfectivo', 'cuentas_efectivo_plantels', 'plantel_id', 'cuentas_efectivo_id');
	} // end

	// generated by relation command - Plantel,Transference - start
	public function transferences()
	{
		return $this->hasMany('App\Transference');
	} // end

	// generated by relation command - Plantel,DocPlantelPlantel - start
	public function docPlantelPlantels()
	{
		return $this->hasMany('App\DocPlantelPlantel');
	} // end

	public function director()
	{
		return $this->hasOne('App\Empleado', 'id', 'director_id');
	}

	public function enlace()
	{
		return $this->hasOne('App\Empleado', 'id', 'enlace_id');
	}

	// generated by relation command - Plantel,Existencium - start
	public function existencia()
	{
		return $this->hasMany('App\Existencium');
	} // end

	// generated by relation command - Plantel,Movimiento - start
	public function movimientos()
	{
		return $this->hasMany('App\Movimiento');
	} // end

	// generated by relation command - Plantel,UbicacionArt - start
	public function ubicacionArts()
	{
		return $this->hasMany('App\UbicacionArt');
	} // end

	// generated by relation command - Plantel,Mueble - start
	public function muebles()
	{
		return $this->hasMany('App\Mueble');
	} // end

	public function conceptoMultipagos()
	{
		return $this->belongsToMany('App\ConceptoMultipago', 'concepto_multipago_plantel', 'plantel_id', 'concepto_multipago_id');
	} // end

	public function formaPagos()
	{
		return $this->belongsToMany('App\FormaPago', 'forma_pago_plantel', 'plantel_id', 'forma_pago_id');
	} // end

	// generated by relation command - CuentaP,Plantel - start
	public function cuentaP()
	{
		return $this->belongsTo('App\CuentaP');
	} // end

	public function matriz()
	{
		return $this->belongsTo('App\Plantel', 'id', 'matriz_id');
	} // end

	// generated by relation command - Plantel,FacturaGeneral - start
	public function facturaGenerals()
	{
		return $this->hasMany('App\FacturaGeneral');
	} // end

	// generated by relation command - Plantel,Prospecto - start
	public function prospectos()
	{
		return $this->hasMany('App\Prospecto');
	} // end

	// generated by relation command - Plantel,PlanPago - start
	public function planPagos()
	{
		return $this->hasMany('App\PlanPago');
	} // end

	// generated by relation command - Plantel,PlanEstudio - start
	public function planEstudios()
	{
		return $this->hasMany('App\PlanEstudio');
	} // end

	// generated by relation command - Plantel,FacturaG - start
	public function facturaGs()
	{
		return $this->hasMany('App\FacturaG');
	} // end

	// generated by relation command - Plantel,Inventario - start
	public function inventarios()
	{
		return $this->hasMany('App\Inventario');
	} // end

	// generated by relation command - Plantel,InventarioObservacion - start
	public function inventarioObservacions()
	{
		return $this->hasMany('App\InventarioObservacion');
	} // end

	public function sepInstitucionEducativa()
	{
		return $this->belongsTo('App\SepInstitucionEducativa');
	} // end

	public function sepCertInstitucion()
	{
		return $this->belongsTo('App\SepCertInstitucion');
	} // end

}
