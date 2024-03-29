<?php

namespace App\Observers;

use App\Pago;
use App\Grado;
use App\Param;
use App\Adeudo;
use App\Cliente;
use App\Lectivo;
use Carbon\Carbon;
use App\PlanPagoLn;
use App\IngresoEgreso;
use App\UsuarioCliente;
use App\CuentasEfectivo;
use App\CombinacionCliente;
use App\ConsecutivoMatricula;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class PagoObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public $pago;
    public function created(Pago $pago)
    {
        $this->pago = $pago;
        $caja=$pago->caja;
        //Crear un registro de ingreso de dinero en ingreso_egresos
        if ($this->pago->cuenta_efectivo_id > 0) {
            $cuentas_efectivo = CuentasEfectivo::where('id', $this->pago->cuenta_efectivo_id)->first();
            /*dd($cuentas_efectivo->saldo_inicial > 0 and
                $this->pago->fecha >= $cuentas_efectivo->fecha_saldo_inicial and
                $this->pago->bnd_pagado == 1 and
                $this->pago->bnd_referenciado <> 1);*/
            if (
                $cuentas_efectivo->saldo_inicial > 0 and
                $this->pago->fecha >= $cuentas_efectivo->fecha_saldo_inicial and
                $this->pago->bnd_pagado == 1 and
                $this->pago->bnd_referenciado <> 1
            ) {

                //Genera la matricula para un cliente si no la tiene.
                //Datos para matricula
                $cajaLn = $pago->caja->cajaLns->first();

                if($cajaLn->adeudo_id<>0){
                    $combinacion = CombinacionCliente::find($cajaLn->adeudo->combinacion_cliente_id);
                
                //dd($combinacion);
                $planPagoLn = PlanPagoLn::where('plan_pago_id', $combinacion->plan_pago_id)->orderBy('fecha_pago', 'asc')->first();
                //$adeudos = Adeudo::where('combinacion_cliente_id', $combinacion->id)->where('caja_concepto_id', 1)->first();
                //dd($adeudos);
                //$inscripcionConcepto = $adeudos->where('caja_concepto_id', 1);
                //$lectivo = Lectivo::find($combinacion->lectivo_id);
                //dd($planPagoLn);
                if (!is_null($planPagoLn)) {
                    $fecha = Carbon::createFromFormat('Y-m-d', $planPagoLn->fecha_pago);
                } else {
                    $fecha = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                }

                $param=Param::where('llave','prefijo_matricula_instalacion')->first();
                $grado = Grado::find($combinacion->grado_id);
                //dd($grado);
                $relleno = "000000";
                $rellenoPlantel = "00";
                $rellenoConsecutivo = "000";


                //dd($consecutivo);
                $cliente = Cliente::where('id', $combinacion->cliente_id)->first();
                //dd(($grado->seccion != "" or !is_null($grado->seccion)) and ($cliente->matricula == "" or $cliente->matricula == " "));
                /*if($cajaLn->caja_concepto_id==1 or 
                $cajaLn->caja_concepto_id==22 or 
                $cajaLn->caja_concepto_id==23 or 
                $cajaLn->caja_concepto_id==24 or 
                $cajaLn->caja_concepto_id==25){*/
                if($cajaLn->cajaConcepto->bnd_genera_matricula==1){
                    if (($grado->seccion != "" or !is_null($grado->seccion)) and ($cliente->matricula == "" or $cliente->matricula == " " or is_null($cliente->matricula))) {
                        $consecutivo = ConsecutivoMatricula::where('plantel_id', $combinacion->plantel_id)
                            ->where('anio', $fecha->year)
                            ->where('mes', $fecha->month)
                            ->where('seccion', $grado->seccion)
                            ->first();

                        if (is_null($consecutivo)) {
                            $consecutivo = ConsecutivoMatricula::create(array(
                                'plantel_id' => $combinacion->plantel_id,
                                'mes' => $fecha->month,
                                'anio' => $fecha->year,
                                'seccion' => $grado->seccion,
                                'consecutivo' => 1,
                                'usu_alta_id' => 1,
                                'usu_mod_id' => 1
                            ));
                        } else {
                            $consecutivo->consecutivo = $consecutivo->consecutivo + 1;
                            $consecutivo->save();
                        }
                        $mes = substr($rellenoPlantel, 0, 2 - strlen($fecha->month)) . $fecha->month;
                        $anio = $fecha->year - 2000;
                        $seccion = $grado->seccion;
                        $plantel = substr($rellenoPlantel, 0, 2 - strlen($combinacion->plantel_id)) . $combinacion->plantel_id;
                        $consecutivoCadena = substr($rellenoConsecutivo, 0, 3 - strlen($consecutivo->consecutivo)) . $consecutivo->consecutivo;

                        if($param->valor<>"0"){
                            $entrada['matricula'] = $param->valor.$mes . $anio . $seccion . $plantel . $consecutivoCadena;
                        }else{
                            $entrada['matricula'] = $mes . $anio . $seccion . $plantel . $consecutivoCadena;
                        }
                        //$i->update($entrada);

                        //dd($entrada['matricula']);
                        $cliente->matricula = $entrada['matricula'];
                        $cliente->save();
                        Log::info('matricula cliente:' . $cliente->id . "-" . $cliente->matricula);
                    }

                    if (!is_null($cliente->matricula)) {
                        $buscarMatricula = UsuarioCliente::where('name', $cliente->matricula)->where('email', $cliente->mail)->first();
                        /*
                        $buscarMail = UsuarioCliente::where('email', $cliente->mail)->first();
                        if(!is_null($buscarMail)){
                            $buscarMail->delete();
                        }*/

                        if (is_null($buscarMatricula)) {
                            $usuario_cliente['name'] = $cliente->matricula;
                            $usuario_cliente['email'] = $cliente->mail;
                            $usuario_cliente['password'] = Hash::make('123456');
                            UsuarioCliente::create($usuario_cliente);
                        }
                    }
                }
                
                }

                //$cuentas_efectivo->saldo_actualizado = $cuentas_efectivo->saldo_actualizado + $this->pago->monto;
                //$cuentas_efectivo->save();

                $ingreso = array();
                $ingreso['plantel_id'] = $this->pago->caja->plantel_id;
                $ingreso['cuenta_efectivo_id'] = $this->pago->cuenta_efectivo_id;
                $ingreso['pago_id'] = $this->pago->id;
                $ingreso['consecutivo_caja'] = $this->pago->caja->consecutivo;
                $ingreso['egreso_id'] = 0;
                $ingreso['concepto'] = "Pago";
                $ingreso['fecha'] = $this->pago->fecha;
                $ingreso['monto'] = $this->pago->monto;
                $ingreso['usu_alta_id'] = $this->pago->usu_alta_id;
                $ingreso['usu_mod_id'] = $this->pago->usu_mod_id;
                $ingreso['transference_id'] = 0;
                IngresoEgreso::create($ingreso);
            }
        }
    }

    public function updating(Pago $pago)
    {
        $this->pago = $pago;
        //Crear un registro de ingreso de dinero en ingreso_egresos
        $ingreso_egreso = IngresoEgreso::where('pago_id', $this->pago->id)->first();
        if ($this->pago->cuenta_efectivo_id > 0) {
            $cuentas_efectivo = CuentasEfectivo::where('id', $this->pago->cuenta_efectivo_id)->first();
            if (
                $cuentas_efectivo->saldo_inicial > 0 and
                $this->pago->fecha >= $cuentas_efectivo->fecha_saldo_inicial and
                $this->pago->bnd_pagado == 1 and
                $this->pago->bnd_referenciado == 1 and
                is_null($ingreso_egreso)
            ) {
                //$cuentas_efectivo->saldo_actualizado = $cuentas_efectivo->saldo_actualizado + $this->pago->monto;
                //$cuentas_efectivo->save();

                $ingreso = array();
                $ingreso['plantel_id'] = $this->pago->caja->plantel_id;
                $ingreso['cuenta_efectivo_id'] = $this->pago->cuenta_efectivo_id;
                $ingreso['pago_id'] = $this->pago->id;
                $ingreso['consecutivo_caja'] = $this->pago->caja->consecutivo;
                $ingreso['egreso_id'] = 0;
                $ingreso['concepto'] = "Pago";
                $ingreso['fecha'] = $this->pago->fecha;
                $ingreso['monto'] = $this->pago->monto;
                $ingreso['usu_alta_id'] = $this->pago->usu_alta_id;
                $ingreso['usu_mod_id'] = $this->pago->usu_mod_id;
                $ingreso['transference_id'] = 0;
                IngresoEgreso::create($ingreso);
            }
        }
    }

    public function deleting(Pago $pago)
    {
        $this->pago = $pago;
        //Eliminar un registro de ingreso de dinero en ingreso_egresos
        if ($this->pago->cuenta_efectivo_id > 0) {
            $cuentas_efectivo = CuentasEfectivo::where('id', $this->pago->cuenta_efectivo_id)->first();
            if ($cuentas_efectivo->saldo_inicial > 0 and $this->pago->fecha >= $cuentas_efectivo->fecha_saldo_inicial) {
                //$cuentas_efectivo->saldo_actualizado = $cuentas_efectivo->saldo_actualizado - $this->pago->monto;
                //$cuentas_efectivo->save();

                $pago = IngresoEgreso::where('pago_id', $this->pago->id)->where('egreso_id', 0)->whereNull('deleted_at')->first();
                if (!is_null($pago) and $pago->count() > 0) {
                    $pago->delete();
                }
            }
        }
    }
}
