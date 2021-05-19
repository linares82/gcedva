<?php namespace App;

use Esensi\Model\Contracts\ValidatingModelInterface;
use Esensi\Model\Traits\ValidatingModelTrait;
use Zizaco\Entrust\EntrustRole;
use App\Traits\GetAllDataTrait;
use App\Traits\RelationManagerTrait;

class Role extends EntrustRole
{
  
  use RelationManagerTrait,GetAllDataTrait;

  //protected $throwValidationExceptions = true;

  protected $fillable = [
    'name',
    'display_name',
    'description',
  ];

  protected $rules = [
    'name'      => 'required|unique:roles',
    'display_name'      => 'required|unique:roles',
  ];

  public function usuarios(){
    return $this->belongsToMany('App\User','role_user','role_id','user_id');
}

public function permisos(){
  return $this->belongsToMany('App\Permission','permission_role','role_id','permission_id');
}
}
