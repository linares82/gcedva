<?php

namespace App\Observers;

use App\Egreso;
use App\CuentasEfectivo;
use App\IngresoEgreso;

class EgresoObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
     public $egreso;
    public function created(Egreso $egreso)
    {
        $this->egreso=$egreso;
        if($this->egreso->cuentas_efectivo_id>0){
            $cuentas_efectivo=CuentasEfectivo::where('id',$this->egreso->cuentas_efectivo_id)->first();
            if($cuentas_efectivo->saldo_inicial>0 and $this->egreso->fecha>=$cuentas_efectivo->fecha_saldo_inicial){
                //$cuentas_efectivo->saldo_actualizado=$cuentas_efectivo->saldo_actualizado-$this->egreso->monto;
                //$cuentas_efectivo->save();
                
                $egreso=array();
                $egreso['plantel_id']=$this->egreso->plantel_id;
                $egreso['cuenta_efectivo_id']=$this->egreso->cuentas_efectivo_id;
                $egreso['pago_id']=0;
                $egreso['consecutivo_caja']=0;
                $egreso['egreso_id']=$this->egreso->id;
                $egreso['concepto']=$this->egreso->egresosConcepto->name;
                $egreso['fecha']=$this->egreso->fecha;
                $egreso['monto']=$this->egreso->monto;
                $egreso['usu_alta_id']=$this->egreso->usu_alta_id;
                $egreso['usu_mod_id']=$this->egreso->usu_mod_id;
                $egreso['transference_id']=0;
                IngresoEgreso::create($egreso);
            }
            
        }
        
        
    }
    
    public function deleting(Egreso $egreso){
        $this->egreso=$egreso;
        if($this->egreso->cuentas_efectivo_id>0){
            $cuentas_efectivo=CuentasEfectivo::where('id',$this->egreso->cuentas_efectivo_id)->first();
            if($cuentas_efectivo->saldo_inicial>0 and $this->egreso->fecha>=$cuentas_efectivo->fecha_saldo_inicial){
                //$cuentas_efectivo->saldo_actualizado=$cuentas_efectivo->saldo_actualizado+$this->egreso->monto;
                //$cuentas_efectivo->save();
                
                $egreso= IngresoEgreso::where('egreso_id',$this->egreso->id)->where('pago_id',0)->first();
                //$egreso->delete();
            }
        }
    }

    
}