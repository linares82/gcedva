<?php

namespace App\Observers;

use App\CuentasEfectivo;
use App\HCuentasEfectivo;

class CuentasEfectivoObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
     public $cuentasEfectivo;
    public function updating(CuentasEfectivo $cuentasEfectivo)
    {
        $this->cuentasEfectivo=$cuentasEfectivo;
        $cf_anterior=CuentasEfectivo::find($this->cuentasEfectivo->id);
        if($cf_anterior->saldo_inicial<>$this->cuentasEfectivo->saldo_inicial or  
           $cf_anterior->fecha_saldo_inicial<>$this->cuentasEfectivo->fecha_saldo_inicial){
            $inpu=array();
            $input['cuentas_efectivo_id']=$this->cuentasEfectivo->id;
            $input['saldo_inicial']=$this->cuentasEfectivo->saldo_inicial;
            $input['saldo_actualizado']=$this->cuentasEfectivo->saldo_actualizado;
            $input['fecha_saldo_inicial']=$this->cuentasEfectivo->fecha_saldo_inicial;
            $input['usu_alta_id']=$this->cuentasEfectivo->usu_mod_id;
            $input['usu_mod_id']=$this->cuentasEfectivo->usu_mod_id;
            HCuentasEfectivo::create($input);
           }
    }

    
}