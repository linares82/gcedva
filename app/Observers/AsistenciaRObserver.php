<?php

namespace App\Observers;

use App\AsistenciaR;
use App\HAsistenciaR;

class AsistenciaRObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public $asistencia;
    public function created(AsistenciaR $asistenciaR)
    {
        $input['asistencia_r_id'] = $asistenciaR->id;
        $input['asignacion_academica_id'] = $asistenciaR->asignacion_academica_id;
        $input['fecha'] = $asistenciaR->fecha;
        $input['cliente_id'] = $asistenciaR->cliente_id;
        $input['est_asistencia_id'] = $asistenciaR->est_asistencia_id;
        $input['usu_alta_id'] = $asistenciaR->usu_alta_id;
        $input['usu_mod_id'] = $asistenciaR->usu_mod_id;
        HAsistenciaR::create($input);
    }

    public function updating(AsistenciaR $asistenciaR)
    {
        $input['asistencia_r_id'] = $asistenciaR->id;
        $input['asignacion_academica_id'] = $asistenciaR->asignacion_academica_id;
        $input['fecha'] = $asistenciaR->fecha;
        $input['cliente_id'] = $asistenciaR->cliente_id;
        $input['est_asistencia_id'] = $asistenciaR->est_asistencia_id;
        $input['usu_alta_id'] = $asistenciaR->usu_alta_id;
        $input['usu_mod_id'] = $asistenciaR->usu_mod_id;
        HAsistenciaR::create($input);
    }
}
