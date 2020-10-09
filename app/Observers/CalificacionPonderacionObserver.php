<?php

namespace App\Observers;

use App\CalificacionPonderacion;
use App\HCalifPonderacion;
use App\HCalificacion;
use Auth;

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
        if (!is_null($calificacionPonderacion->calificacion_parcial_calculada)) {
            $input['calificacion_parcial_calculada'] = $calificacionPonderacion->calificacion_parcial_calculada;
        } else {
            $input['calificacion_parcial_calculada'] = 0;
        }

        $input['ponderacion'] = $calificacionPonderacion->ponderacion;
        if (!is_null($calificacionPonderacion->tiene_detalle)) {
            $input['tiene_detalle'] = $calificacionPonderacion->tiene_detalle;
        } else {
            $input['tiene_detalle'] = 0;
        }
        if (!is_null($calificacionPonderacion->padre_id)) {
            $input['padre_id'] = $calificacionPonderacion->padre_id;
        } else {
            $input['padre_id'] = 0;
        }

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
        if (!is_null($calificacionPonderacion->calificacion_parcial_calculada <> "")) {
            $input['calificacion_parcial_calculada'] = $calificacionPonderacion->calificacion_parcial_calculada;
        } else {
            $input['calificacion_parcial_calculada'] = 0;
        }
        $input['ponderacion'] = $calificacionPonderacion->ponderacion;
        if (!is_null($calificacionPonderacion->tiene_detalle)) {
            $input['tiene_detalle'] = $calificacionPonderacion->tiene_detalle;
        } else {
            $input['tiene_detalle'] = 0;
        }
        if (!is_null($calificacionPonderacion->padre_id)) {
            $input['padre_id'] = $calificacionPonderacion->padre_id;
        } else {
            $input['padre_id'] = 0;
        }
        $input['usu_alta_id'] = $calificacionPonderacion->usu_alta_id;
        $input['usu_mod_id'] = $calificacionPonderacion->usu_mod_id;
        //dd($input);
        HCalifPonderacion::create($input);
        $anterior = CalificacionPonderacion::find($calificacionPonderacion->id);

        //llena historial

        $this->hCalificacions($anterior, $calificacionPonderacion);
    }

    public function hCalificacions($anterior, $nuevo)
    {
        //dd($anterior->id);
        if ($nuevo->calificacion_parcial <> $anterior->calificacion_parcial) {
            $input['cliente_id'] = $anterior->calificacion->hacademica->cliente_id;
            $input['calificacion_id'] = $anterior->calificacion_id;
            $input['calificacion_ponderacion_id'] = $anterior->id;
            $input['carga_ponderacion_id'] = $anterior->carga_ponderacion_id;
            $input['calificacion_parcial_anterior'] = $anterior->calificacion_parcial;
            $input['calificacion_parcial_actual'] = $nuevo->calificacion_parcial;
            $input['usu_alta_id'] = $nuevo->usu_alta_id;
            $input['usu_mod_id'] = Auth::user()->id;
            HCalificacion::create($input);
        }
    }
}
