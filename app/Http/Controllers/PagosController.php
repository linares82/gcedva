<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Pago;
use App\Plantel;
use App\Caja;
use App\Adeudo;
use App\Cliente;
use App\CajaLn;
use App\CombinacionCliente;
use App\Empleado;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePago;
use App\Http\Requests\createPago;
use DB;

class PagosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$pagos = Pago::getAllData($request);

		return view('pagos.index', compact('pagos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('pagos.create')
			->with( 'list', Pago::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPago $request)
	{

		$input = $request->all();
                //dd($input);
		$caja=Caja::find($input['caja_id']);
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
                $plantel=Plantel::find($caja->plantel_id);
                $plantel->consecutivo_pago=$plantel->consecutivo_pago+1;
                $plantel->save();
                $input['consecutivo']=$plantel->consecutivo_pago;
		//create data
		$pago=Pago::create( $input );
                
                
                //dd($caja->cajaLns);
                
                foreach($caja->cajaLns as $ln){
                    if($ln->adeudo_id>0){
                        Adeudo::where('id', '=', $ln->adeudo_id)->update(['caja_id'=>$caja->id]);
                    }
                }
                
                $suma_pagos=Pago::select('monto')->where('caja_id','=',$pago->caja_id)->sum('monto');
                if($suma_pagos==$caja->total){
                    $caja->st_caja_id=1;
                    $caja->fecha=date_create(date_format(date_create(date('Y/m/d')),'Y/m/d'));
                    $caja->save();
                    
                    foreach($caja->cajaLns as $ln){
                        if($ln->adeudo_id>0){
                            Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd'=>1]);
                        }
                    }  
                }elseif($suma_pagos>0 and $suma_pagos<$caja->total){
                    $caja->st_caja_id=3;
                    $caja->save();
                    foreach($caja->cajaLns as $ln){
                        if($ln->adeudo_id>0){
                            Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd'=>0]);
                        }
                    }
                }else{
                    $caja->st_caja_id=0;
                    $caja->save();
                    
                    foreach($caja->cajaLns as $ln){
                        if($ln->adeudo_id>0){
                            Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd'=>0]);
                        }
                    }
                }
                //dd($suma_pagos);
		//return redirect()->route('cajas.caja')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Pago $pago)
	{
		$pago=$pago->find($id);
		return view('pagos.show', compact('pago'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Pago $pago)
	{
		$pago=$pago->find($id);
		return view('pagos.edit', compact('pago'))
			->with( 'list', Pago::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Pago $pago)
	{
		$pago=$pago->find($id);
		return view('pagos.duplicate', compact('pago'))
			->with( 'list', Pago::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Pago $pago, updatePago $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$pago=$pago->find($id);
		$pago->update( $input );

		return redirect()->route('pagos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Pago $pago)
	{
		$pago=$pago->find($id);
                
		$pago->delete();
                
                $caja=Caja::find($pago->caja_id);
                //dd($caja->toArray());
                $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
                //dd($combinaciones->toArray());
                $cliente=Cliente::find($caja->cliente_id);
                
                $suma_pagos=Pago::select('monto')->where('caja_id','=',$pago->caja_id)->sum('monto');
                if($suma_pagos==$caja->total){
                    $caja->st_caja_id=1;
                    $caja->save();
                    
                    foreach($caja->cajaLns as $ln){
                        if($ln->adeudo_id>0){
                            Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd'=>1]);
                        }
                    }  
                }elseif($caja->st_caja_id==1){
                    $caja->st_caja_id=0;
                    $caja->save();
                    
                    foreach($caja->cajaLns as $ln){
                        if($ln->adeudo_id>0){
                            Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd'=>0]);
                        }
                    }
                }
                
                if(count($caja->pagos)==0)
                foreach($caja->cajaLns as $ln){
                    if($ln->adeudo_id>0){
                        Adeudo::where('id', '=', $ln->adeudo_id)->update(['caja_id'=>0]);
                    }
                }
                
		return view('cajas.caja', compact('cliente', 'caja', 'combinaciones'))
                        ->with( 'list', Caja::getListFromAllRelationApps() )
                        ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
	}
    
    public function imprimir(Request $request){
        $data=$request->all();
        
        $pago=Pago::find($data['pago']);
        
        $caja=Caja::find($pago->caja_id);
        
        $acumulado=Pago::select('monto')->where('caja_id','=',$caja->id)->sum('monto');

        $adeudo=Adeudo::where('caja_id', '=', $caja->id)->first();

        if(!is_null($adeudo)){
            $combinacion=CombinacionCliente::find($adeudo->combinacion_cliente_id);
            //dd($combinacion);
            $cliente=Cliente::find($caja->cliente_id);
            $empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();

            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y h:i:s');

            //dd($adeudo->toArray());
            return view('cajas.imprimirTicketPago', array('cliente'=>$cliente, 
                                                               'caja'=>$caja, 
                                                               'empleado'=>$empleado, 
                                                               'fecha'=>$date,
                                                               'combinacion'=>$combinacion,
                                                               'pago'=>$pago,
                                                               'acumulado'=>$acumulado));
        }else{
            $combinacion=0;
        $cliente=Cliente::find($caja->cliente_id);
        $empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();

        $carbon = new \Carbon\Carbon();
        $date = $carbon->now();
        $date = $date->format('d-m-Y h:i:s');

        //dd($adeudo->toArray());
        return view('cajas.imprimirTicketPago', array('cliente'=>$cliente, 
                                                           'caja'=>$caja, 
                                                           'empleado'=>$empleado, 
                                                           'fecha'=>$date,
                                                           'combinacion'=>$combinacion,
                                                           'pago'=>$pago,
                                                           'acumulado'=>$acumulado));    
        }

    }
    
    public function pagosXPeriodoXPlantelXConcepto(){
        return view('pagos.reportes.pagosXplantelXPeriodoXConcepto')
                ->with( 'list', Pago::getListFromAllRelationApps())
                ->with( 'list2', Caja::getListFromAllRelationApps());
    }
    
    public function pagosXPeriodoXPlantelXConceptoR(Request $request){
        $datos=$request->all();
        $plantel=Plantel::find($datos['plantel_f']);
        
        $registros_pagados = Caja::select('cc.name as concepto',DB::raw('sum(cln.total) as total'))
                         ->join('pagos as p','p.caja_id','=','cajas.id')
                         ->join('caja_lns as cln','cln.caja_id','=','cajas.id')
                         ->join('caja_conceptos as cc','cc.id','=','cln.caja_concepto_id')
                         ->where('cajas.st_caja_id',1)
                         ->where('p.fecha','>=',$datos['fecha_f'])
                         ->where('p.fecha','<=',$datos['fecha_t'])
                         ->where('cajas.plantel_id','>=',$datos['plantel_f'])
                         //->where('cajas.plantel_id','<=',$datos['plantel_t'])
                         ->groupBy('cc.name')
                         ->get();
        //dd($registros_pagados->toArray());
        
        $registros_parciales = Caja::select(DB::raw('sum(p.monto) as total'))
                         ->join('pagos as p','p.caja_id','=','cajas.id')
                         ->join('caja_lns as cln','cln.caja_id','=','cajas.id')
                         ->join('caja_conceptos as cc','cc.id','=','cln.caja_concepto_id')
                         ->where('cajas.st_caja_id',3)
                         ->where('p.fecha','>=',$datos['fecha_f'])
                         ->where('p.fecha','<=',$datos['fecha_t'])
                         ->where('cajas.plantel_id','>=',$datos['plantel_f'])
                         //->where('cajas.plantel_id','<=',$datos['plantel_t'])
                         ->groupBy('cc.name')
                         ->value('total');
        //dd($registros_parciales->toArray());
        
        return view('pagos.reportes.pagosXplantelXPeriodoXConceptoR', array('registros_pagados'=>$registros_pagados, 
                                                                            'registros_parciales'=>$registros_parciales,
                                                                            'plantel'=>$plantel,
                                                                            'datos'=>$datos));
    }
}
