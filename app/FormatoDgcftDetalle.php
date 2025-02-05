<?php

namespace App;

use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormatoDgcftDetalle extends Model
{
    use RelationManagerTrait, GetAllDataTrait;
	use SoftDeletes;

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

    protected $fillable = ['formato_dgcft_id','num','control','cliente_id','nombre','curp','edad','fec_sexo',
    'beca','resultado','final', 'escolaridad','usu_alta_id', 'usu_mod_id','bnd_satisfactorio'];

	public function usu_alta()
	{
		return $this->hasOne('App\User', 'id', 'usu_alta_id');
	} // end

	public function usu_mod()
	{
		return $this->hasOne('App\User', 'id', 'usu_mod_id');
	} // end


    public function formatoDgcftMatCalifs()
	{
		return $this->hasMany('App\FormatoDgcftMatCalif');
	} // end
	protected $dates = ['deleted_at'];

}
