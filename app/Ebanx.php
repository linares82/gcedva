<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ebanx extends Model
{
    use RelationManagerTrait,GetAllDataTrait;
    use SoftDeletes;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    } 

	//Mass Assignment
	protected $fillable = ['nombre','nombre2','ape_paterno','ape_materno','fel_fijo','mail','plantel_id','medio_id','empleado_id','observaciones',
            'estado_id','municipio_id','st_cliente_id','especialidad_id','especialidad_id','especialidad2_id','especialidad3_id','especialidad4_id',
            'nivel_id','diplomado_id','curso_id','otro_id','grado_id','subdiplomado_id','subotro_id','turno_id','turno2_id','turno3_id','turno4_id',
            'ofertum_id','matricula','ciclo_id','empresa_id','cve_cliente','tel_cel','paise_id','usu_alta_id','usu_mod_id'];

	public function usu_alta() {
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	}// end

	public function usu_mod() {
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	}// end

        public function pais() {
		return $this->hasOne('App\Paise', 'id', 'paise_id');
	}
        
        public function grado() {
		return $this->hasOne('App\Grado', 'id', 'grado_id');
	}
        
    protected $dates = ['deleted_at'];
}