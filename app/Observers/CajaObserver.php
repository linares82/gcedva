<?php

namespace App\Observers;

use App\Adeudo;
use App\BsBaja;
use App\Caja;
use App\Cliente;
use App\HCambiosCaja;
use App\Param;
use App\Seguimiento;
use Log;
use Mail;
use App\Inscripcion;
use Auth;
use Exception;
use Carbon\Carbon;

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

    public function created(Caja $caja){
        
    }

    public function updating(Caja $caja){
        $caja_anterior=Caja::find($caja->id);
        $this->caja=$caja;
        //dd($this->caja);
        
        //dd($caja_anterior->toArray());
        foreach($caja_anterior->toArray() as $campo=>$valor){
            //Log::info("Par: ".$campo."-".$valor);
            if($caja->$campo<>$caja_anterior->$campo){
                $input=array();
                //Log::info("Par2: ".$campo."-".$valor);
                $input['caja_id']=$this->caja->id;
                $input['campo']=$campo;
                $input['valor_anterior']=$caja_anterior->$campo;
                $input['valor_nuevo']=$caja->$campo;
                $input['user_id']=isset(Auth::user()->id) ? Auth::user()->id : 1;
                $input['usu_mod_id']=$this->caja->usu_mod_id;
                $input['usu_alta_id']=$this->caja->usu_alta_id;
                //dd($input);
                try{
                    HCambiosCaja::create($input);
                }catch(Exception $e){
                    dd($input);
                }
                
            }
        }
        
    }


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
            $adeudos = Adeudo::where('cliente_id', $this->caja->cliente_id)->where('pagado_bnd', 0)
                ->whereDate('fecha_pago','<=', Date('Y-m-d'))
                ->whereNull('deleted_at')
                ->count();
            $mensualidades = Adeudo::where('cliente_id', $this->caja->cliente_id)
                ->join('caja_conceptos as caj_con', 'caj_con.id', '=', 'adeudos.caja_concepto_id')
                ->where('pagado_bnd', 0)
                ->where('caj_con.bnd_mensualidad', 1)
                ->whereDate('fecha_pago','<=', Date('Y-m-d'))
                ->whereNull('adeudos.deleted_at')
                ->count();
            
            if($inscripcions->isEmpty() and $this->caja->cliente->st_cliente_id == 1 and $seguimiento->st_seguimiento_id ==5){
                $cliente->st_cliente_id = 5;
                $cliente->save();    
                $seguimiento->st_seguimiento_id = 2;
                $seguimiento->save();
            }elseif ($inscripcions->isEmpty() and $mensualidades==0 and $this->caja->cliente->st_cliente_id <> 3 /*and $this->caja->cliente->seguimiento->st_seguimiento_id==2*/) {
            //if ($inscripcions->isEmpty()) {
                $cliente->st_cliente_id = 22;
                $cliente->save();
                $seguimiento->st_seguimiento_id = 2;
                $seguimiento->save();
            }elseif ($this->caja->cliente->st_cliente_id <> 3) {
                $diaFechaActual=Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->day;
                $aux=Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
                if($diaFechaActual<=10 and $diaFechaActual>=1){
                    $aux->month=Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->month-1;
                    $aux->day=$aux->daysInMonth;
                }
                $fechaActual = $aux->toDateString();
                $adeudos = Adeudo::where('cliente_id', $this->caja->cliente_id)->where('pagado_bnd', 0)
                ->whereNull('deleted_at')
                ->whereDate('fecha_pago','<=', $fechaActual)
                ->count();
                if ($adeudos == 0 and $cliente->st_cliente<>20){
                    if ($adeudos == 0) {
                        $cliente->st_cliente_id = 4;
                        $cliente->save();

                        $seguimiento->st_seguimiento_id = 2;
                        $seguimiento->save();

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
                                            
                                        }
                                    }
                                }
                            } catch (Exception $e) {
                                $this->enviarMailFallaBs($e->getMessage(), 'Error al activar cliente en BS desde pago de caja');
                                Log::info("cliente no encontrado en Brigth Space u otro error: " . $cliente->matricula . " - " . $e->getMessage());
                                //return false;
                            }
                        }
                    }
                }elseif($this->caja->cliente->st_cliente_id == 27){
                    if ($mensualidades == 3) {
                        $cliente->st_cliente_id = 26;
                        $cliente->save();

                        $seguimiento->st_seguimiento_id = 2;
                        $seguimiento->save();

                        $param = Param::where('llave', 'apiVersion_bSpace')->first();
                        $bs_activo = Param::where('llave', 'api_brightSpace_activa')->first();
                        if ($bs_activo->valor == 1) {
                            try {
                                $apiBs = new UsoApi();

                                //dd($datos);
                                $resultado = $apiBs->doValence2('GET', '/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId=' . $cliente->matricula);
                                //Muestra resultado
                                $r = $resultado[0];
                                $datos = ['isActive' => False];
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
                                            
                                        }
                                    }
                                }
                            } catch (Exception $e) {
                                $this->enviarMailFallaBs($e->getMessage(), 'Error al activar cliente en BS desde pago de caja');
                                Log::info("cliente no encontrado en Brigth Space u otro error: " . $cliente->matricula . " - " . $e->getMessage());
                                //return false;
                            }
                        }
                    }
                }elseif ($this->caja->cliente->st_cliente_id == 26) {
                    //dd($adeudos);
                    if ($adeudos == 2) {
                        $cliente->st_cliente_id = 25;
                        $cliente->save();

                        $seguimiento->st_seguimiento_id = 2;
                        $seguimiento->save();

                        $param = Param::where('llave', 'apiVersion_bSpace')->first();
                        $bs_activo = Param::where('llave', 'api_brightSpace_activa')->first();
                        if ($bs_activo->valor == 1) {
                            try {
                                $apiBs = new UsoApi();

                                //dd($datos);
                                $resultado = $apiBs->doValence2('GET', '/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId=' . $cliente->matricula);
                                //Muestra resultado
                                $r = $resultado[0];
                                $datos = ['isActive' => False];
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
                                            
                                        }
                                    }
                                }
                            } catch (Exception $e) {
                                $this->enviarMailFallaBs($e->getMessage(), 'Error al activar cliente en BS desde pago de caja');
                                Log::info("cliente no encontrado en Brigth Space u otro error: " . $cliente->matricula . " - " . $e->getMessage());
                                //return false;
                            }
                        }
                    }
                //} elseif($adeudos==0) {
                }elseif ($this->caja->cliente->st_cliente_id == 25){
                    if ($adeudos == 1) {
                        $cliente->st_cliente_id = 17;
                        $cliente->save();

                        $seguimiento->st_seguimiento_id = 2;
                        $seguimiento->save();

                        $param = Param::where('llave', 'apiVersion_bSpace')->first();
                        $bs_activo = Param::where('llave', 'api_brightSpace_activa')->first();
                        if ($bs_activo->valor == 1) {
                            try {
                                $apiBs = new UsoApi();

                                //dd($datos);
                                $resultado = $apiBs->doValence2('GET', '/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId=' . $cliente->matricula);
                                //Muestra resultado
                                $r = $resultado[0];
                                $datos = ['isActive' => False];
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
                                            
                                        }
                                    }
                                }
                            } catch (Exception $e) {
                                $this->enviarMailFallaBs($e->getMessage(), 'Error al activar cliente en BS desde pago de caja');
                                Log::info("cliente no encontrado en Brigth Space u otro error: " . $cliente->matricula . " - " . $e->getMessage());
                                //return false;
                            }
                        }
                    }
                }elseif ($this->caja->cliente->st_cliente_id == 17){
                    if ($adeudos == 0) {
                        $cliente->st_cliente_id = 4;
                        $cliente->save();

                        $seguimiento->st_seguimiento_id = 2;
                        $seguimiento->save();

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
                                            
                                        }
                                    }
                                }
                            } catch (Exception $e) {
                                $this->enviarMailFallaBs($e->getMessage(), 'Error al activar cliente en BS desde pago de caja');
                                Log::info("cliente no encontrado en Brigth Space u otro error: " . $cliente->matricula . " - " . $e->getMessage());
                                //return false;
                            }
                        }
                    }
                }
                
                /*else {
                    
                    $cliente->st_cliente_id = 4;
                    $cliente->save();

                    $seguimiento->st_seguimiento_id = 2;
                    $seguimiento->save();

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
                            //dd($r);
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
                            //$this->enviarMailFallaBs($e->getMessage(), 'Error al activar cliente en BS desde pago de caja');
                            Log::info("cliente no encontrado en Brigth Space u otro error: " . $cliente->matricula . " - " . $e->getMessage());
                            //dd($e->getMessage());
                            //return false;
                        }
                    }
                }*/
            }
        }
        //dd("pasa Bs y cambia estatus de cja");
        if ($this->caja->st_caja_id == 1) {
            $adeudos = Adeudo::where('cliente_id', $this->caja->cliente_id)->where('pagado_bnd', 0)
                ->whereNull('deleted_at')
                ->count();
            //->get();
            //dd($adeudos->toArray());
            //Log::info('Adeudos:' . $adeudos);
            if ($adeudos == 0 and $cliente->st_cliente<>20) {
                if ($cliente->st_cliente_id <> 3) {
                    $cliente->st_cliente_id = 20;
                    $cliente->save();
                    $seguimiento->st_seguimiento_id = 7;
                    $seguimiento->save();
                }
            }
        }
    }

    public function enviarMailFallaBs($msj, $asunto)
    {
        $from = "ohpelayo@gmail.com";
        $destinatario = "linares82@gmail.com";
        $contenido = $msj;
        $n = Auth::user()->name;
        
        //dd(env('MAIL_FROM_ADDRESS'));

        $data = array('contenido' => $msj, 'nombre' => $n, 'correo' => $from);
        $r = \Mail::send('correos.errorBs', $data, function ($message)
        use ($asunto, $destinatario, $n, $from) {
            $message->from(env('MAIL_FROM_ADDRESS', 'hola@grupocedva.com'), env('MAIL_FROM_NAME', 'Grupo CEDVA'));
            $message->to($destinatario, $n)->subject($asunto);
            $message->replyTo($from);
        });
    }

}
