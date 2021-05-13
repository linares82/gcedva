<?php

namespace App\Observers;

use App\HStProspecto;
use App\Prospecto;
use Auth;
use Carbon\Carbon;

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
    }
}
