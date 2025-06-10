<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;


class SepInstitucionEducativa extends Model
{
	use RelationManagerTrait, GetAllDataTrait;


	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
	}

	//Mass Assignment
	protected $fillable = ['cve_institucion', 'descripcion'];
}
