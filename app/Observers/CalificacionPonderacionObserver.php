<?php

namespace App\Observers;

use App\CalificacionPonderacion;
use App\HCalifPonderacion;

class CalificacionPonderacionObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public $asistencia;
    public function created(CalificacionPonderacion $calificacionPonderacion)
    {
        $input['calificacion_ponderacion_id'] = $calificacionPonderacion->id;
        $input['calificacion_id'] = $calificacionPonderacion->calificacion_id;
        $input['carga_ponderacion_id'] = $calificacionPonderacion->carga_ponderacion_id;
        $input['calificacion_parcial'] = $calificacionPonderacion->calificacion_parcial;
        $input['calificacion_parcial_calculada'] = $calificacionPonderacion->calificacion_parcial_calculada;
        $input['ponderacion'] = $calificacionPonderacion->ponderacion;
        $input['tiene_detalle'] = $calificacionPonderacion->tiene_detalle;
        $input['padre_id'] = $calificacionPonderacion->padre_id;
        $input['usu_alta_id'] = $calificacionPonderacion->usu_alta_id;
        $input['usu_mod_id'] = $calificacionPonderacion->usu_mod_id;
        //dd($input);
        HCalifPonderacion::create($input);
    }

    public function updating(CalificacionPonderacion $calificacionPonderacion)
    {
        $input['calificacion_ponderacion_id'] = $calificacionPonderacion->id;
        $input['calificacion_id'] = $calificacionPonderacion->calificacion_id;
        $input['carga_ponderacion_id'] = $calificacionPonderacion->carga_ponderacion_id;
        $input['calificacion_parcial'] = $calificacionPonderacion->calificacion_parcial;
        $input['calificacion_parcial_calculada'] = $calificacionPonderacion->calificacion_parcial_calculada;
        $input['ponderacion'] = $calificacionPonderacion->ponderacion;
        $input['tiene_detalle'] = $calificacionPonderacion->tiene_detalle;
        $input['padre_id'] = $calificacionPonderacion->padre_id;
        $input['usu_alta_id'] = $calificacionPonderacion->usu_alta_id;
        $input['usu_mod_id'] = $calificacionPonderacion->usu_mod_id;
        //dd($input);
        HCalifPonderacion::create($input);
    }
}
