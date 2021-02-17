<?php

namespace App\Observers;

use App\Adeudo;
use App\BsBaja;
use App\Caja;
use App\Cliente;
use App\Param;
use App\Seguimiento;
use Log;
use App\Inscripcion;
use Auth;
use Exception;

use App\valenceSdk\samples\BasicSample\UsoApi;

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
        $this->caja = $caja;
        $cliente = Cliente::find($this->caja->cliente_id);
        $seguimiento = Seguimiento::where('cliente_id', $this->caja->cliente_id)->first();

        //$cajas=Caja::where('cliente_id',$this->caja->cliente_id)->where('id','<>',$this->caja->id)->get();
        //dd($this->caja);
        if ($this->caja->st_caja_id == 1 or $this->caja->st_caja_id == 3) {
            

            $inscripcions = Inscripcion::where('cliente_id', $cliente->id)->whereNull('inscripcions.deleted_at')->get();
            if ($inscripcions->isEmpty()) {
                $cliente->st_cliente_id = 22;
                $cliente->save();
                $seguimiento->st_seguimiento_id = 2;
                $seguimiento->save();
            } elseif ($this->caja->cliente->st_cliente_id == 3) {

            } elseif ($this->caja->cliente->st_cliente_id <> 3) {
                
                $seguimiento->st_seguimiento_id = 2;
                $seguimiento->save();

                if ($this->caja->cliente->st_cliente_id == 26) {
                    $adeudos = Adeudo::where('cliente_id', $this->caja->cliente_id)->where('pagado_bnd', 0)
                        ->whereNull('deleted_at')
                        ->whereDate('fecha_pago','<=', date('Y-m-d'))
                        ->count();
                    //dd($adeudos);
                    if ($adeudos <= 1) {
                        $cliente->st_cliente_id = 4;
                        $cliente->save();

                        $param = Param::where('llave', 'apiVersion_bSpace')->first();
                        $bs_activo = Param::where('llave', 'api_brightSpace_activa')->first();
                        if ($bs_activo->valor == 1) {
                            try {
                                $apiBs = new UsoApi();

                                //dd($datos);
                                $resultado = $apiBs->doValence2('GET', '/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId=' . $cliente->matricula);
                                //Muestra resultado
                                $r = $resultado[0];
                                $datos = ['isActive' => True];
                                if (isset($r['UserId'])) {
                                    $resultado2 = $apiBs->doValence2('PUT', '/d2l/api/lp/' . $param->valor . '/users/' . $r['UserId'] . '/activation', $datos);
                                    $bsBaja = BsBaja::where('cliente_id', $cliente->id)
                                        ->where('bnd_baja', 1)
                                        ->where('bnd_reactivar', '<>', 1)
                                        ->first();
                                    if (!is_null($bsBaja)) {
                                        if (isset($resultado2['IsActive']) and $resultado2['IsActive'] and !is_null($bsBaja)) {
                                            $input['cliente_id'] = $cliente->id;
                                            $input['fecha_reactivar'] = Date('Y-m-d');
                                            $input['bnd_reactivar'] = 1;
                                            $input['usu_mod_id'] = Auth::user()->id;
                                            $bsBaja->update($input);
                                        } else {
                                            $input['cliente_id'] = $cliente->id;
                                            $input['fecha_reactivar'] = Date('Y-m-d');
                                            $input['bnd_reactivar'] = 0;
                                            $input['usu_mod_id'] = Auth::user()->id;
                                            $bsBaja->update($input);
                                            $bsBaja->update($input);
                                        }
                                    }
                                }
                            } catch (Exception $e) {
                                Log::info("cliente no encontrado en Brigth Space u otro error: " . $cliente->matricula . " - " . $e->getMessage());
                                //return false;
                            }
                        }
                    }
                } else {
                    $cliente->st_cliente_id = 4;
                    $cliente->save();

                    $param = Param::where('llave', 'apiVersion_bSpace')->first();
                    $bs_activo = Param::where('llave', 'api_brightSpace_activa')->first();
                    if ($bs_activo->valor == 1) {
                        try {
                            $apiBs = new UsoApi();

                            //dd($datos);
                            //Log::info('matricula bs reactivar en caja:'.$cliente->matricula);
                            $resultado = $apiBs->doValence2('GET', '/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId=' . $cliente->matricula);
                            //Muestra resultado
                            $r = $resultado[0];
                            $datos = ['isActive' => True];
                            if (isset($r['UserId'])) {
                                $resultado2 = $apiBs->doValence2('PUT', '/d2l/api/lp/' . $param->valor . '/users/' . $r['UserId'] . '/activation', $datos);
                                $bsBaja = BsBaja::where('cliente_id', $cliente->id)
                                    ->where('bnd_baja', 1)
                                    ->whereNull('bnd_reactivar')
                                    ->first();
                                //dd($bsBaja);
                                if (!is_null($bsBaja)) {
                                    if (isset($resultado2['IsActive']) and $resultado2['IsActive'] and !is_null($bsBaja)) {
                                        $input['cliente_id'] = $cliente->id;
                                        $input['fecha_reactivar'] = Date('Y-m-d');
                                        $input['bnd_reactivar'] = 1;
                                        $input['usu_mod_id'] = Auth::user()->id;
                                        $bsBaja->update($input);
                                    } else {
                                        $input['cliente_id'] = $cliente->id;
                                        $input['fecha_reactivar'] = Date('Y-m-d');
                                        $input['bnd_reactivar'] = 0;
                                        $input['usu_mod_id'] = Auth::user()->id;
                                        $bsBaja->update($input);
                                    }
                                }
                            }
                        } catch (Exception $e) {
                            Log::info("cliente no encontrado en Brigth Space u otro error: " . $cliente->matricula . " - " . $e->getMessage());
                            //return false;
                        }
                    }
                }
            }
        }
        if ($this->caja->st_caja_id == 1) {
            $adeudos = Adeudo::where('cliente_id', $this->caja->cliente_id)->where('pagado_bnd', 0)
                ->whereNull('deleted_at')
                ->count();
            //->get();
            //dd($adeudos->toArray());
            //Log::info('Adeudos:' . $adeudos);
            if ($adeudos == 0) {
                if ($cliente->st_cliente_id <> 3) {
                    $cliente->st_cliente_id = 20;
                    $cliente->save();
                    $seguimiento->st_seguimiento_id = 7;
                    $seguimiento->save();
                }
            }
        }
    }
}
