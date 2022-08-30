<?php

namespace App\Observers;

use App\ComenMueble;
use App\Mueble;
use Auth;
use Carbon\Carbon;

class MuebleObserver
{
    public $mueble;

    public function created(Mueble $mueble)
    {
        $this->mueble = $mueble;
        $datos['mueble_id'] = $this->mueble->id;
        $datos['st_mueble_id'] = $this->mueble->st_mueble_id;
        $datos['obs'] = $this->mueble->observaciones;
        $datos['usu_alta_id'] = Auth::user()->id;
        $datos['usu_mod_id'] = Auth::user()->id;
        ComenMueble::create($datos);
    }

    public function updating(Mueble $mueble)
    {
        $mueble_antes = Mueble::find($mueble->id);
        $this->mueble = $mueble;

        if ($mueble_antes->st_mueble_id <> $this->mueble->st_mueble_id) {
            $datos['mueble_id'] = $this->mueble->id;
            $datos['st_mueble_id'] = $this->mueble->st_mueble_id;
            $datos['obs'] = $this->mueble->observaciones;
            $datos['usu_alta_id'] = Auth::user()->id;
            $datos['usu_mod_id'] = Auth::user()->id;
            ComenMueble::create($datos);
        }
    }
}
