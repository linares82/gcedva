<?php

namespace App\Observers;

use Auth;
use App\Prospecto;
use Carbon\Carbon;
use App\ProspectoStSeg;
use App\ProspectoHEstatuse;
use App\ProspectoHactividad;
use App\ProspectoHactividade;
use App\ProspectoSeguimiento;

class ProspectoSeguimientoObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public $ProspectoSeguimiento;
    public function created(ProspectoSeguimiento $prospectoSeguimiento)
    {
        $this->ProspectoSeguimiento = $prospectoSeguimiento;
        $h = new ProspectoHactividad();

        $h->prospecto_id = $this->ProspectoSeguimiento->prospecto_id;
        $h->prospecto_seguimiento_id = $this->ProspectoSeguimiento->id;
        $h->tarea = 'Seguimiento';
        $h->fecha = Carbon::now();
        $h->hora = Carbon::now();
        $h->asunto = 'Creacion';
        $h->detalle = $this->ProspectoSeguimiento->prospectoStSeg->name;
        $h->usu_alta_id = $this->ProspectoSeguimiento->usu_alta_id;
        $h->usu_mod_id = $this->ProspectoSeguimiento->usu_mod_id;

        //dd($hactividad);

        $h->save();
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(ProspectoSeguimiento $Seguimiento)
    {
        /*$this->Seguimiento=$Seguimiento;
    $s=Seguimiento::find($this->Seguimiento->id);
    //dd($s->toArray());
    if($this->Seguimiento->st_seguimiento_id<>$s->st_seguimiento_id){
    $hs['seguimiento_id']=$this->Seguimiento->id;
    $hs['cliente_id']=$this->Seguimiento->cliente_id;
    $hs['st_seguimiento_id']=$this->Seguimiento->st_seguimiento_id;
    $hs['st_anterior_id']=$s->st_seguimiento_id;
    $hs['mes']=$this->Seguimiento->mes;
    $hs['usu_alta_id']=$this->Seguimiento->usu_alta_id;
    $hs['usu_mod_id']=$this->Seguimiento->usu_mod_id;
    $hs['created_at']=$this->Seguimiento->created_at;
    $hs['updated_at']=$this->Seguimiento->updated_at;
    $hs['deleted_at']=$this->Seguimiento->deleted_at;
    $h=new HsSeguimiento();
    $h->save($hs);
    }
     *
     */
    }

    public function updating(ProspectoSeguimiento $prospectoSeguimiento)
    {
        $this->ProspectoSeguimiento = $prospectoSeguimiento;
        $vprospectoSeguimiento = ProspectoSeguimiento::find($prospectoSeguimiento->id);
        //dd($vprospectoSeguimiento);
        if ($vprospectoSeguimiento->prospecto_st_seg_id != $this->ProspectoSeguimiento->prospecto_st_seg_id) {
            $st_seguimiento = ProspectoStSeg::find($this->ProspectoSeguimiento->prospecto_st_seg_id);
            $input['tabla'] = 'seguimientos';
            $input['prospecto_id'] = $vprospectoSeguimiento->prospecto_id;
            $input['prospecto_seguimiento_id'] = $vprospectoSeguimiento->id;
            $input['estatus'] = $st_seguimiento->name;
            $input['estatus_id'] = $st_seguimiento->id;
            $input['fecha'] = Date('Y-m-d');
            $input['usu_alta_id'] = isset(Auth::user()->id) ? Auth::user()->id : 1;
            $input['usu_mod_id'] = isset(Auth::user()->id) ? Auth::user()->id : 1;
            //dd($input);
            ProspectoHEstatuse::create($input);
        }
    }

    public function updated(ProspectoSeguimiento $prospectoSeguimiento)
    {
        $this->ProspectoSeguimiento = $prospectoSeguimiento;
        $h = new ProspectoHactividad();

        $h->prospecto_id = $this->ProspectoSeguimiento->prospecto_id;
        $h->prospecto_seguimiento_id = $this->ProspectoSeguimiento->id;
        $h->tarea = 'Seguimiento';
        $h->fecha = Carbon::now();
        $h->hora = Carbon::now();
        $h->asunto = 'Cambio estatus ';
        $h->detalle = $this->ProspectoSeguimiento->prospectoStSeg->name;
        $h->usu_alta_id = $this->ProspectoSeguimiento->usu_alta_id;
        $h->usu_mod_id = $this->ProspectoSeguimiento->usu_mod_id;

        //dd($hactividad);

        $h->save();

    }
}
