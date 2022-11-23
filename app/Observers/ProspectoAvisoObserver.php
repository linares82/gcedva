<?php

namespace App\Observers;

use App\ProspectoSeguimiento;
use App\HsSeguimiento;
use App\ProspectoAviso;
use App\ProspectoHactividad;
use App\Prospecto;
use App\Plantel;
use Carbon\Carbon;

class ProspectoAvisoObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public $ProspectoAviso;
    public function created(ProspectoAviso $prospectoAviso)
    {
        $this->ProspectoAviso=$prospectoAviso;
        $prospectoSeguimiento=ProspectoSeguimiento::find($this->ProspectoAviso->prospecto_seguimiento_id);
        //dd($seguimiento->toArray());
        $h=new ProspectoHactividad();
        
        $h->prospecto_id=$prospectoSeguimiento->prospecto_id;  
        $h->prospecto_seguimiento_id=$this->ProspectoAviso->prospecto_seguimiento_id;
        $h->tarea='Aviso';
        $h->fecha=Carbon::now();
        $h->hora=Carbon::now();
        $h->asunto=$this->ProspectoAviso->prospectoAsunto->name;
        $h->detalle=$this->ProspectoAviso->detalle;
        $h->usu_alta_id=$this->ProspectoAviso->usu_alta_id;
        $h->usu_mod_id=$this->ProspectoAviso->usu_mod_id;

        //dd($h);
        $h->save();
        
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
     public function deleting(Seguimiento $Seguimiento){
        
     }

    /*public function updated(Seguimiento $Seguimiento)
    {
        $this->AsignacionTarea=$asignacionTarea;
        $seguimiento=Seguimiento::where('cliente_id', '=', $this->AsignacionTarea->cliente_id)->first();
        $h=new Hactividade();
        
        $h->cliente_id=$this->AsignacionTarea->cliente_id;  
        $h->seguimiento_id=$seguimiento->id;
        $h->tarea=$this->AsignacionTarea->tarea->name;
        $h->fecha=Carbon::now();
        $h->hora=Carbon::now();
        $h->asunto=$this->AsignacionTarea->asunto->name;
        $h->detalle=$this->AsignacionTarea->detalle;
        $h->usu_alta_id=$this->Seguimiento->usu_alta_id;
        $h->usu_mod_id=$this->Seguimiento->usu_mod_id;

        //dd($hactividad);
        
        $h->save();
    }*/

}