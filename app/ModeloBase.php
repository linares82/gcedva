<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;

class ModeloBase extends Model
{
    use RelationManagerTrait, GetAllDataTrait;
    

    public function getTotalRelacionesAttribute(){
		return count($this->relationApps);
	}
}