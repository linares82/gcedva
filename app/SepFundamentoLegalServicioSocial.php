<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;


class SepFundamentoLegalServicioSocial extends Model
{
	use RelationManagerTrait, GetAllDataTrait;


	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = ['id_fundamento_legal_servicio_social', 'fundamento_legal_servicio_social'];
}
