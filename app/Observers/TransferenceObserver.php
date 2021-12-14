<?php

namespace App\Observers;

use App\Transference;
use App\CuentasEfectivo;
use App\IngresoEgreso;

class TransferenceObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
     public $transference;
     
    public function created(Transference $transference)
    {
        $this->transference=$transference;
        if($this->transference->origen_id>0 and $this->transference->destino_id>0 and $this->transference->monto>0){
            $cuentas_efectivo=CuentasEfectivo::where('id',$this->transference->origen_id)->first();
            if($cuentas_efectivo->saldo_inicial>0 and $this->transference->fecha>=$cuentas_efectivo->fecha_saldo_inicial){
                //$cuentas_efectivo->saldo_actualizado=$cuentas_efectivo->saldo_actualizado-$this->transference->monto;
                //dd($cuentas_efectivo);
                //$cuentas_efectivo->save();
                
                $egreso=array();
                $egreso['plantel_id']=$this->transference->plantel_id;
                $egreso['cuenta_efectivo_id']=$this->transference->origen_id;
                $egreso['pago_id']=0;
                $egreso['consecutivo_caja']=0;
                $egreso['egreso_id']=0;
                $egreso['concepto']='Transferencia:egreso';
                $egreso['fecha']=$this->transference->fecha;
                $egreso['monto']=$this->transference->monto;
                $egreso['usu_alta_id']=$this->transference->usu_alta_id;
                $egreso['usu_mod_id']=$this->transference->usu_mod_id;
                $egreso['transference_id']=$this->transference->id;
                IngresoEgreso::create($egreso);
            }
            
            $cuentas_efectivo=CuentasEfectivo::where('id',$this->transference->destino_id)->first();
            if($cuentas_efectivo->saldo_inicial>0 and $this->transference->fecha>=$cuentas_efectivo->fecha_saldo_inicial){
                //$cuentas_efectivo->saldo_actualizado=$cuentas_efectivo->saldo_actualizado+$this->transference->monto;
                //$cuentas_efectivo->save();
                
                $ingreso=array();
                $ingreso['plantel_id']=$this->transference->plantel_destino_id;
                $ingreso['cuenta_efectivo_id']=$this->transference->destino_id;
                $ingreso['pago_id']=0;
                $ingreso['consecutivo_caja']=0;
                $ingreso['egreso_id']=0;
                $ingreso['concepto']="Transferencia:ingreso";
                $ingreso['fecha']=$this->transference->fecha;
                $ingreso['monto']=$this->transference->monto;
                $ingreso['usu_alta_id']=$this->transference->usu_alta_id;
                $ingreso['usu_mod_id']=$this->transference->usu_mod_id;
                $ingreso['transference_id']=$this->transference->id;
                IngresoEgreso::create($ingreso);
                
            }
            
        }
        
        
    }
    
    public function deleting(Transference $transference){
        $this->transference=$transference;
        if($this->transference->origen_id>0 and $this->transference->destino_id>0 and $this->transference->monto>0){
            $cuentas_efectivo=CuentasEfectivo::where('id',$this->transference->origen_id)->first();
            if($cuentas_efectivo->saldo_inicial>0 and $this->transference->fecha>=$cuentas_efectivo->fecha_saldo_inicial){
                //$cuentas_efectivo->saldo_actualizado=$cuentas_efectivo->saldo_actualizado+$this->transference->monto;
                //$cuentas_efectivo->save();
                
                $egreso= IngresoEgreso::where('transference_id',$this->transference->id)->where('concepto','transferencia:egreso')->first();
                $egreso->delete();
            }
            
            $cuentas_efectivo=CuentasEfectivo::where('id',$this->transference->destino_id)->first();
            if($cuentas_efectivo->saldo_inicial>0 and $this->transference->fecha>=$cuentas_efectivo->fecha_saldo_inicial){
                //$cuentas_efectivo->saldo_actualizado=$cuentas_efectivo->saldo_actualizado-$this->transference->monto;
                //$cuentas_efectivo->save();
                
                $pago= IngresoEgreso::where('transference_id',$this->transference->id)->where('concepto','transferencia:ingreso')->first();
                $pago->delete();
            }
        }
    }

    
}