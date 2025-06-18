<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;


class SepCertificadoL extends Model
{
	use RelationManagerTrait, GetAllDataTrait;

	protected $table = "sep_certificado_ls";

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = [
		'sep_certificado_id',
		'cliente_id',
		'hacademica_id',
		'materium_id',
		'lectivo_id',
		'sep_cert_tipo_id',
		'fecha_expedicion',
		'id_carrera',
		'id_asignatura',
		'numero_asignaturas_cursadas',
		'promedio_general',
		'sep_cert_observacion_id',
		'calificacion_materia',
		'bnd_descargar',
		'usu_mod_id',
		'usu_alta_id',
		'materium_id',
		'lectivo_id',
		'consulta_calificacion_id'
	];

	public function usu_alta()
	{
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	} // end

	public function usu_mod()
	{
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	} // end

	public function cliente()
	{
		return $this->hasOne('App\Cliente', 'id', 'cliente_id');
	} // end

	public function sepCertTipo()
	{
		return $this->hasOne('App\SepCertTipo', 'id', 'sep_cert_tipo_id');
	} // end

	public function sepCertObservacion()
	{
		return $this->hasOne('App\SepCertObservacion', 'id', 'sep_cert_observacion_id');
	} // end

	public function hacademica()
	{
		return $this->hasOne('App\Hacademica', 'id', 'hacademica_id');
	} // end

	public function materia()
	{
		return $this->hasOne('App\Materium', 'id', 'materium_id');
	} // end

	public function lectivo()
	{
		return $this->hasOne('App\Lectivo', 'id', 'lectivo_id');
	} // end

	public function consultaCalificacion()
	{
		return $this->hasOne('App\ConsultaCalificacion', 'id', 'consulta_calificacion_id');
	} // end
}
