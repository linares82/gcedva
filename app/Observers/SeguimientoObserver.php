<?php

namespace App\Observers;

use App\Seguimiento;
use App\HsSeguimiento;
use App\Cliente;
use App\Plantel;

class SeguimientoObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public $Seguimiento;
    public function created(Seguimiento $Seguimiento)
    {
        /*$this->Seguimiento=$Seguimiento;
        
        //dd($this->Seguimiento->st_seguimiento_id."-".$s->st_seguimiento_id);
        
            $hs['seguimiento_id']=$this->Seguimiento->id;
            $hs['cliente_id']=$this->Seguimiento->cliente_id;  
            $hs['st_seguimiento_id']=$this->Seguimiento->st_seguimiento_id;
            $hs['st_anterior_id']=0;
            $hs['mes']=$this->Seguimiento->mes;
            $hs['usu_alta_id']=$this->Seguimiento->usu_alta_id;
            $hs['usu_mod_id']=$this->Seguimiento->usu_mod_id;
            $hs['created_at']=$this->Seguimiento->created_at;
            $hs['updated_at']=$this->Seguimiento->updated_at;
            $hs['deleted_at']=$this->Seguimiento->deleted_at;
            $h=new HsSeguimiento();
            $h->save($hs);
        */
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
     public function deleting(Seguimiento $Seguimiento){
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

    public function updating(Seguimiento $Seguimiento)
    {
        /*
        $this->Seguimiento=$Seguimiento;
        $s=Seguimiento::find($this->Seguimiento->id);
        //dd($this->Seguimiento->st_seguimiento_id."-".$s->st_seguimiento_id);
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

    public function updated(){

    }
}