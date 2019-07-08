<?php

namespace App\Observers;

use App\Caja;
use App\Cliente;
use App\Seguimiento;
use App\Plantel;

class CajaObserver
{
    /**
     * Listen to the Caja created event.
     *
     * @param  User  $user
     * @return void
     */
     public $cajas;
     public $caja;
    

    /**
     * Listen to the Caja updated event.
     *
     * @param  User  $user
     * @return void
     */
    public function updated(Caja $caja)
    {
        $this->caja=$caja;
        //$cajas=Caja::where('cliente_id',$this->caja->cliente_id)->where('id','<>',$this->caja->id)->get();
        //dd($this->caja);
        if($this->caja->st_caja_id==1 or $this->caja->st_caja_id==3){
            $seguimiento=Seguimiento::where('cliente_id',$this->caja->cliente_id)->first();
            $seguimiento->st_seguimiento_id=2;
            $seguimiento->save();
            $cliente=Cliente::find($this->caja->cliente_id);
            $cliente->st_cliente_id=4;
            $cliente->save();
        }
    }
}