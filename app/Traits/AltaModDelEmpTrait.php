<?php

namespace App\Traits;

use App\Empleado;

trait AltaModDelEmpTrait
{
    public static function bootAltaModDelEmpTrait()
    {
        static::creating(function ($model) {
            $model->emp_alta_id = Empleado::where('user_id', auth()->id())->value('id');
            $model->emp_mod_id = Empleado::where('user_id', auth()->id())->value('id');
        });
        static::updating(function ($model) {
            $model->emp_mod_id = Empleado::where('user_id', auth()->id())->value('id');
        });
        static::deleting(function ($model) {
            $model->emp_delete_id = Empleado::where('user_id', auth()->id())->value('id');
            $model->save();
        });
    }
}
