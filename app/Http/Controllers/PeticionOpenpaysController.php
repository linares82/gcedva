<?php
namespace App\Http\Controllers;

use Log;
use Auth;
use DB;

use App\Caja;
use App\Pago;
use App\Param;
use Exception;
use App\Adeudo;
use App\CajaLn;
use App\Cliente;
use App\Plantel;
use App\Empleado;
use Carbon\Carbon;
use App\Http\Requests;
use App\CuentasEfectivo;
use App\PeticionOpenpay;
use Openpay\Data\Openpay;
use App\PeticionMultipago;
use App\CombinacionCliente;
use Illuminate\Http\Request;
use App\SerieFolioSimplificado;
use App\Http\Controllers\Controller;
use App\Http\Requests\createPeticionMultipago;
use App\Http\Requests\updatePeticionMultipago;

class PeticionOpenpaysController extends Controller
{
    public function buscarOpenpay($peticion, $plantel)
    {
        $ip = Param::where('llave', 'ip_localhost')->first();
        $openpay = Openpay::getInstance($plantel->oid, $plantel->oprivada, 'MX', $ip->valor);
        //dd($openpay);
        $openpay_productivo = Param::where('llave', 'openpay_productivo')->first();

        $url_open_pay = "";
        if ($openpay_productivo->valor == 1) {
            //$openpay->setProductionMode(true);
            Openpay::setProductionMode(true);
            $url_open_pay = Param::where('llave', 'url_openpay_productivo')->value('valor');
        } else {
            //$openpay->setProductionMode(false);
            Openpay::setProductionMode(false);
            $url_open_pay = Param::where('llave', 'url_openpay_sandbox')->value('valor');
        }

        $findDataRequest = array(
            'order_id' => $peticion->porder_id
        );
        //dd($findDataRequest);

        $chargeList = $openpay->charges->getList($findDataRequest);
        //dd($chargeList);
        if($peticion->pmethod=="bank_account"){
            $peticion->rid = $chargeList[0]->id;
            $peticion->rauthorization = $chargeList[0]->authorization;
            $peticion->rmethod = $chargeList[0]->method;
            $peticion->roperation_type = $chargeList[0]->operation_type;
            $peticion->rtransaction_type = $chargeList[0]->transaction_type;
            $peticion->rstatus = $chargeList[0]->status;
            $peticion->rconciliated = $chargeList[0]->conciliated;
            $peticion->rcreation_date = Carbon::parse($chargeList[0]->creation_date)->format('Y-m-d H:i:s');
            //$peticionOpenpay->roperation_date=Carbon::parse($charge->operation_date)->format('Y-m-d H:i:s');
            $peticion->rdescription = $chargeList[0]->description;
            $peticion->rerror_message = $chargeList[0]->error_message;
            $peticion->ramount = $chargeList[0]->amount;
            $peticion->rcurrency = $chargeList[0]->currency;
            $peticion->rpayment_method_type = $chargeList[0]->payment_method->type;
            //$peticionOpenpay->rpayment_method_url=$charge->payment_method->url;
            $peticion->rpayment_method_bank = $chargeList[0]->payment_method->bank;
            $peticion->rpayment_method_agreement = $chargeList[0]->payment_method->agreement;
            $peticion->rpayment_method_clabe = $chargeList[0]->payment_method->clabe;
            $peticion->rpayment_method_name = $chargeList[0]->payment_method->name;
            $peticion->rorder_id = $chargeList[0]->order_id;
        }elseif($peticion->pmethod=="card"){
            $peticion->rid = $chargeList[0]->id;
            $peticion->rauthorization = $chargeList[0]->authorization;
            $peticion->rmethod = $chargeList[0]->method;
            $peticion->roperation_type = $chargeList[0]->operation_type;
            $peticion->rtransaction_type = $chargeList[0]->transaction_type;
            $peticion->rstatus = $chargeList[0]->status;
            $peticion->rconciliated = $chargeList[0]->conciliated;
            $peticion->rcreation_date = Carbon::parse($chargeList[0]->creation_date)->format('Y-m-d H:i:s');
            $peticion->roperation_date = Carbon::parse($chargeList[0]->operation_date)->format('Y-m-d H:i:s');
            $peticion->rdescription = $chargeList[0]->description;
            $peticion->rerror_message = $chargeList[0]->error_message;
            $peticion->ramount = $chargeList[0]->amount;
            $peticion->rcurrency = $chargeList[0]->currency;
            $peticion->rpayment_method_type = $chargeList[0]->payment_method->type;
            $peticion->rpayment_method_url = $chargeList[0]->payment_method->url;
            $peticion->rorder_id = $chargeList[0]->order_id;
        }elseif($peticion->pmethod=="store"){
            $peticion->rid = $chargeList[0]->id;
            $peticion->rauthorization = $chargeList[0]->authorization;
            $peticion->rmethod = $chargeList[0]->method;
            $peticion->roperation_type = $chargeList[0]->operation_type;
            $peticion->rtransaction_type = $chargeList[0]->transaction_type;
            $peticion->rstatus = $chargeList[0]->status;
            $peticion->rconciliated = $chargeList[0]->conciliated;
            $peticion->rcreation_date = Carbon::parse($chargeList[0]->creation_date)->format('Y-m-d H:i:s');
            $peticion->roperation_date = Carbon::parse($chargeList[0]->operation_date)->format('Y-m-d H:i:s');
            $peticion->rdescription = $chargeList[0]->description;
            $peticion->rerror_message = $chargeList[0]->error_message;
            $peticion->ramount = $chargeList[0]->amount;
            $peticion->rcurrency = $chargeList[0]->currency;
            $peticion->rpayment_method_type = $chargeList[0]->payment_method->type;
            //$peticion->rpayment_method_url = $chargeList[0]->payment_method->url;
            $peticion->rpayment_method_reference = $chargeList[0]->payment_method->reference;
            $peticion->rpayment_method_barcode_url = $chargeList[0]->payment_method->barcode_url;
            $peticion->rorder_id = $chargeList[0]->order_id;
        }
        $peticion->save();
        return $peticion;
    }

    public function successOpenpay(Request $request)
    {
        $id=$request->input('id');
        $limite=$request->input('limite');
        $peticion = PeticionOpenpay::where('rid', $id)->where('fecha_limite',$limite)->first();
        //dd($peticion);
        $plantel =Cliente::find($peticion->cliente_id)->plantel;

        $peticion=$this->buscarOpenpay($peticion, $plantel);
        try {
        
            if (!is_null($peticion) and $peticion->rstatus=="completed") {
                //$peticion->bnd_pagado = 1;
                //$peticion->notificacion_pagado = date('Y-m-d H:i:s');
                //$peticion->save();
                $pago = Pago::find($peticion->pago_id);
                $caja = Caja::find($pago->caja_id);
                $cajaLn = CajaLn::where('caja_id', $caja->id)->first();
                //dd($cajaLn);
                $adeudo = Adeudo::where('id', $cajaLn->adeudo_id)->first();

                //dd($peticion->toArray());


                $pago->bnd_pagado = 1;
                $pago->save();
                $caja = $pago->caja;
                $caja->st_caja_id = 1;
                $caja->save();
                $adeudo->pagado_bnd = 1;
                $adeudo->save();

                //Generar consecutivo pago simplificado
                $plantel = Plantel::find($caja->plantel_id);
                $pago_final = Pago::where('caja_id', '=', $caja->id)->orderBy('id', 'desc')->first();
                $pagos = Pago::where('caja_id', '=', $caja->id)->orderBy('id', 'desc')->get();

                $mes = Carbon::createFromFormat('Y-m-d', $pago_final->fecha)->month;
                $anio = Carbon::createFromFormat('Y-m-d', $pago_final->fecha)->year;

                if ($cajaLn->cajaConcepto->bnd_mensualidad == 1 and is_null($pago_final->csc_simplificado)) {
                    $serie_folio_simplificado = SerieFolioSimplificado::where('cuenta_p_id', $plantel->cuenta_p_id)
                        ->where('anio', $anio)
                        ->where('mese_id', 13)
                        ->where('bnd_activo', 1)
                        ->where('bnd_fiscal', 1)
                        ->first();
                    $serie_folio_simplificado->folio_actual = $serie_folio_simplificado->folio_actual + 1;
                    $folio_actual = $serie_folio_simplificado->folio_actual;
                    $serie = $serie_folio_simplificado->serie;
                    $serie_folio_simplificado->save();

                    $relleno = "0000";
                    $consecutivo = substr($relleno, 0, 4 - strlen($folio_actual)) . $folio_actual;
                    foreach ($pagos as $pago) {
                        $pago->csc_simplificado = $serie . "-" . $consecutivo;
                        $pago->save();
                    }
                } elseif ($cajaLn->cajaConcepto->bnd_mensualidad == 0 and is_null($pago_final->csc_simplificado)) {
                    $serie_folio_simplificado = SerieFolioSimplificado::where('cuenta_p_id', $plantel->cuenta_p_id)
                        ->where('anio', $anio)
                        ->where('mese_id', $mes)
                        ->where('bnd_activo', 1)
                        ->where('bnd_fiscal', 0)
                        ->first();
                    $serie_folio_simplificado->folio_actual = $serie_folio_simplificado->folio_actual + 1;
                    $serie_folio_simplificado->save();
                    $folio_actual = $serie_folio_simplificado->folio_actual;
                    $mes_prefijo = $serie_folio_simplificado->mes1->abreviatura;
                    $anio_prefijo = $anio - 2000;
                    $serie = $serie_folio_simplificado->serie;


                    $relleno = "0000";
                    $consecutivo = substr($relleno, 0, 4 - strlen($folio_actual)) . $folio_actual;
                    foreach ($pagos as $pago) {
                        $pago->csc_simplificado = $serie . "-" . $mes_prefijo . $anio_prefijo . "-" . $consecutivo;
                        $pago->save();
                    }
                }
                //Fin crear consecutivo simplificado

            }

        } catch (Exception $e) {
            dd($e);
            Log::info($e->getMessage());
        }

        $planteles = Empleado::where('user_id', '=', Auth::user()->id)->where('st_empleado_id','<>',3)->first()->plantels->pluck('id');
        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');
        $caja=$peticion->pago->caja;
        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus', 'ln.adeudo_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $caja->cliente->id)
            ->where('ln.adeudo_id', '0')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();
        $cuentasEfectivo = CuentasEfectivo::pluck('name', 'id');
        $cliente=$peticion->cliente;
        
        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas', 'cuentasEfectivo', 'empleados'))
                ->with('list', Caja::getListFromAllRelationApps())
                ->with('list1', CajaLn::getListFromAllRelationApps());
    }

}
