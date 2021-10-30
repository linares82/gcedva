<?php

namespace App\Observers;

use Log;
use Auth;
use App\Param;
use Exception;
use Throwable;
use App\BsBaja;
use App\Cliente;
use App\HistoriaCliente;
use App\valenceSdk\samples\BasicSample\UsoApi;

class HistoriaClienteObserver
{
    public function updated(HistoriaCliente $historiaCliente)
    {
        //dd('fil');
        
        if($historiaCliente->evento_cliente_id==2 and $historiaCliente->st_historia_cliente_id==2){
            
            try {
                $param = Param::where('llave', 'apiVersion_bSpace')->first();
                $bs_activo = Param::where('llave', 'api_brightSpace_activa')->first();
                if ($bs_activo->valor == 1) {
                    $apiBs=new UsoApi();
                    $cliente=Cliente::find($historiaCliente->cliente_id);
                    //dd(!is_null($cliente->matricula) or $cliente->matricula<>"");
                    if(!is_null($cliente->matricula) or $cliente->matricula<>""){
                        //Se invoca el metodo doValence con los parametros del verbo y la url igual que en el ejemplo del SDK
                        //$resultado=$apiBs->doValence('GET','/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId='.$alumno->matricula);
                        $resultado=$apiBs->doValence2('GET','/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId='.$cliente->matricula);
                        //dd($resultado);
                        //Muestra resultado
                        $r=$resultado[0];
                        //dd($r['UserId']);

                        $datos=['isActive'=>False];
                        //dd($datos);
                        if(isset($r['UserId'])){
                            $resultado2=$apiBs->doValence2('PUT','/d2l/api/lp/' . $param->valor . '/users/'.$r['UserId'].'/activation',$datos);
                            Log::info('Baja por evento matricula: '.$cliente->matricula." - con id: ".$cliente->id);
                            //dd($resultado2);
                            /*
                            if(isset($resultado2['IsActive']) and !$resultado2['IsActive']){
                                $input['cliente_id']=$cliente->id;
                                $input['fecha_baja']=Date('Y-m-d');
                                $input['bnd_baja']=1;
                                $input['usu_alta_id']=Auth::user()->id;
                                $input['usu_mod_id']=Auth::user()->id;
                                BsBaja::create($input);
                                if ($adeudos->adeudos_cantidad == 2) {
                                    $cliente->st_cliente_id = 25;
                                    $cliente->save();

                                    $seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
                                    $seguimiento->st_seguimiento_id = 2;
                                    $seguimiento->save();
                                } elseif ($cliente->adeudos_cantidad >= 3) {
                                    //$cliente = Cliente::find($registro->cliente_id);
                                    $cliente->st_cliente_id = 26;
                                    $cliente->save();

                                    $adeudos = Adeudo::where('cliente_id', $cliente->cliente_id)
                                        ->where('caja_id', 0)
                                        ->where('pagado_bnd', 0)
                                        ->whereDate('adeudos.fecha_pago','>',Date('Y-m-d'))
                                        ->get();
                                    //dd($adeudos->toArray());
                                    foreach ($adeudos as $adeudo) {
                                        $adeudo->delete();
                                    }

                                    $seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
                                    $seguimiento->st_seguimiento_id = 6;
                                    $seguimiento->save();
                                }
                                
                            }else{
                                $input['cliente_id']=$cliente->id;
                                $input['fecha_baja']=Date('Y-m-d');
                                $input['bnd_baja']=0;
                                $input['usu_alta_id']=Auth::user()->id;
                                $input['usu_mod_id']=Auth::user()->id;
                                BsBaja::create($input);
                            }*/
                        }
                        //dd($resultado2['IsActive']);
                    }
                }
            } catch (Exception $e) {
                Log::info("cliente no encontrado en Brigth Space u otro error: ".$cliente->matricula." - ".$e->getMessage());
                //return false;
            }
        }
    }
}
