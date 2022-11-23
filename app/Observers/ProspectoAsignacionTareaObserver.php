<?php

namespace App\Observers;

use App\Plantel;
use App\Prospecto;
use Carbon\Carbon;
use App\ProspectoHactividad;
use App\ProspectoHactividade;
use App\ProspectoSeguimiento;
use App\ProspectoAsignacionTarea;

class ProspectoAsignacionTareaObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public $ProspectoAsignacionTarea;
    public function created(ProspectoAsignacionTarea $prospectoAsignacionTarea)
    {
        $this->ProspectoAsignacionTarea=$prospectoAsignacionTarea;
        
        $prospectoSeguimiento=ProspectoSeguimiento::where('prospecto_id', '=', $this->ProspectoAsignacionTarea->prospecto_id)->first();
        $h=new ProspectoHactividad();
        
        $h->prospecto_id=$this->ProspectoAsignacionTarea->prospecto_id;  
        $h->prospecto_seguimiento_id=$prospectoSeguimiento->id;
        $h->tarea=$this->ProspectoAsignacionTarea->prospectoTarea->name;
        $h->fecha=Carbon::now();
        $h->hora=Carbon::now();
        $h->asunto=$this->ProspectoAsignacionTarea->prospectoAsunto->name;
        $h->detalle=$this->ProspectoAsignacionTarea->detalle;
        $h->usu_alta_id=$this->ProspectoAsignacionTarea->usu_alta_id;
        $h->usu_mod_id=$this->ProspectoAsignacionTarea->usu_mod_id;

        //dd($hactividad);
        
        $h->save();
        
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
     //public function deleting(Seguimiento $Seguimiento){
        
     //}

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