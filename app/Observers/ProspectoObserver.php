<?php

namespace App\Observers;

use Auth;
use App\Prospecto;
use Carbon\Carbon;
use App\StProspecto;
use App\HStProspecto;
use App\ProspectoHEstatuse;

class ProspectoObserver
{ 
    public $prospecto;
    
    public function updating(Prospecto $prospecto)
    {
        $prospecto_antes = Prospecto::find($prospecto->id);
        $this->prospecto = $prospecto;

        if ($prospecto_antes->st_prospecto_id <> $this->prospecto->st_prospecto_id) {
            $datos['prospecto_id'] = $prospecto_antes->id;
            $datos['st_prospecto_id'] = $this->prospecto->st_prospecto_id;
            $datos['st_anterior_id'] = $prospecto_antes->st_prospecto_id;
            $datos['usu_alta_id'] = $prospecto->usu_alta_id;
            $datos['usu_mod_id'] = $prospecto->usu_mod_id;
            HStProspecto::create($datos);
        }

        if ($prospecto_antes->st_prospecto_id <> $this->prospecto->st_prospecto_id) {
            $st_prospecto = StProspecto::find($this->prospecto->st_prospecto_id);
            $input['tabla'] = 'prospectos';
            $input['cliente_id'] = $prospecto_antes->id;
            $input['seguimiento_id'] = 0;
            $input['estatus'] = $st_prospecto->name;
            $input['estatus_id'] = $st_prospecto->id;
            $input['fecha'] = Date('Y-m-d');
            $input['usu_alta_id'] = isset(Auth::user()->id) ? Auth::user()->id : 1;
            $input['usu_mod_id'] = isset(Auth::user()->id) ? Auth::user()->id : 1;
            ProspectoHEstatuse::create($input);
        }
    }
}
