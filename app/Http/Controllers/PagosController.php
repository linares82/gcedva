<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Pago;
use App\Plantel;
use App\Caja;
use App\CuentasEfectivo;
use App\Adeudo;
use App\Cliente;
use App\CajaLn;
use App\CombinacionCliente;
use App\Empleado;
use App\Inscripcion;
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
                
                if($input['forma_pago_id']==1){
                    $cuenta_efectivo= CuentasEfectivo::find($input['cuenta_efectivo_id']);
                    $cuenta_efectivo->csc_efectivo=$cuenta_efectivo->csc_efectivo+1;
                    $cuenta_efectivo->save();
                    $input['referencia']=$cuenta_efectivo->csc_efectivo;
                }
                
                
		//create data
                //dd($input);
		$pago=Pago::create( $input );
                
                
                //dd($caja->cajaLns);
                
                foreach($caja->cajaLns as $ln){
                    if($ln->adeudo_id>0){
                        Adeudo::where('id', '=', $ln->adeudo_id)->update(['caja_id'=>$caja->id]);
                    }
                }
                
                $suma_pagos=Pago::select('monto')->where('caja_id','=',$pago->caja_id)->sum('monto');
                if($suma_pagos>=$caja->total){
                    $caja->st_caja_id=1;
                    //$caja->fecha=date_create(date_format(date_create(date('Y/m/d')),'Y/m/d'));
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
                $cajas=Caja::select('cajas.consecutivo as caja','ln.caja_concepto_id as concepto_id','cc.name as concepto', 'ln.total','st.name as estatus')
                    ->join('caja_lns as ln','ln.caja_id','=','cajas.id')
                    ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
                    ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                    ->where('cliente_id',$cliente->id)
                    ->get();
                
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
                
		return view('cajas.caja', compact('cliente', 'caja', 'combinaciones','cajas'))
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
    
    public function validarReferencia(Request $request){
        if($request->ajax()){
            $datos=$request->all();
            //dd($datos);
            $registros=Pago::select('caja_id','plantel_id','p.cve_plantel','c.consecutivo')
                           ->join('cajas as c','c.id','=','pagos.caja_id')
                           ->join('plantels as p','p.id','=','c.plantel_id')
                           ->where('pagos.referencia',$datos['referencia'])
                           ->where('cuenta_efectivo_id',$datos['cuenta_efectivo_id'])
                           ->get();
            return $registros;
            /*$resultado=array();
            if(count($registros)>0){
                array_push($resultado, array('total_coincidencias'=>count($registros)));
                array_push($resultado,array('pagos_coincidentes'=>$registros->toArray()));
                
            }else{
                array_push($resultado, array('total_coincidencias'=>0));
                
            }
            return response()->json($resultado);
            */
        }
        
    }
    
    public function getRptPagos(){
        return view('pagos.reportes.inscritosPagos')
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
    }
    
    public function postRptPagos(Request $request){
        $data=$request->all();
                $plantel=Plantel::find($data['plantel_f']);
                //dd($data);
                
                
                $registros_pagados= Caja::select('pla.razon','c.id',
                        DB::raw(''
                        . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente, cajas.id as caja, cajas.consecutivo,'
                        . 'c.beca_bnd, st.name as estatus_caja, fp.id as forma_pago_id,'
                        . 'pag.monto as monto_pago, fp.name as forma_pago, pag.fecha as fecha_pago, cajas.fecha as fecha_caja'))
                            ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
                            ->join('plantels as pla','pla.id','=','c.plantel_id')
                            ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                            ->join('pagos as pag','pag.caja_id','=','cajas.id')
                            ->join('forma_pagos as fp','fp.id','=','pag.forma_pago_id')
                            ->where('cajas.plantel_id', '=', $data['plantel_f'])
                            ->where('pag.fecha','>=',$data['fecha_f'])
                            ->where('pag.fecha','<=',$data['fecha_t'])
                            ->whereNull('pag.deleted_at')
                            ->where('cajas.st_caja_id','=',1)
                            ->orderBy('cajas.st_caja_id')
                            ->distinct()
                            ->get();
                
                $registros_pagados1= Caja::select('pla.razon','c.id',
                        DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as colaborador, '
                        . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente, cajas.id as caja, cajas.consecutivo,'
                        . 'c.beca_bnd, st.name as estatus_caja,'
                        . 'pag.monto as monto_pago, fp.name as forma_pago, pag.fecha as fecha_pago, cajas.fecha as fecha_caja'))
                            ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
                            ->join('plantels as pla','pla.id','=','c.plantel_id')
                            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                            //->join('caja_lns as ln','ln.caja_id','=','caj.id')
                            //->join('caja_conceptos as conce','conce.id','=','ln.caja_concepto_id')
                            ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                            //->join('adeudos as a','a.id','=','ln.adeudo_id')
                            ->join('pagos as pag','pag.caja_id','=','cajas.id')
                            ->join('forma_pagos as fp','fp.id','=','pag.forma_pago_id')
                            ->where('cajas.plantel_id', '=', $data['plantel_f'])
                            ->where('cajas.fecha','=',$data['fecha_f'])
                            ->whereNull('pag.deleted_at')
                            ->where('cajas.st_caja_id','=',1)
                            ->orderBy('colaborador','cajas.st_caja_id')
                            ->distinct()
                            ->get();
                
                //dd($registros_pagados->toArray());
                
                $registros_parciales= Caja::select('pla.razon','c.id',
                        DB::raw(''
                        . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente, cajas.id as caja, cajas.consecutivo,'
                        . 'c.beca_bnd, st.name as estatus_caja, cajas.total as total_caja, fp.id as forma_pago_id, '
                        . 'pag.monto as monto_pago, fp.name as forma_pago, pag.fecha as fecha_pago, cajas.fecha as fecha_caja'))
                            ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
                            ->join('plantels as pla','pla.id','=','c.plantel_id')
                            ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                            ->join('pagos as pag','pag.caja_id','=','cajas.id')
                            ->join('forma_pagos as fp','fp.id','=','pag.forma_pago_id')
                            ->where('cajas.plantel_id', '=', $data['plantel_f'])
                            ->where('pag.fecha','>=',$data['fecha_f'])
                            ->where('pag.fecha','<=',$data['fecha_t'])
                            ->whereNull('pag.deleted_at')
                            ->where('cajas.st_caja_id','=',3)
                            ->orderBy('cajas.st_caja_id')
                            ->distinct()
                            ->get();
                
                //dd($registros_parciales->toArray());
                                        
                                        
                /*
                PDF::setOptions(['defaultFont' => 'arial']);

                $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
                        ->setPaper('legal', 'landscape');
                return $pdf->download('reporte.pdf');
                */
                return view('pagos.reportes.inscritosPagosR', array('registros_pagados'=>$registros_pagados,
                                                                           'registros_parciales'=>$registros_parciales,
                                                                           'registros_pagados1'=>'registros_pagados1',
                                                                                 'plantel'=>$plantel,
                                                                                 'data'=>$data));
    }
    
    public function getAlumnoBeca(){
        return view('pagos.reportes.getAlumnosBeca')
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
    }
    
    public function postAlumnoBeca(Request $request){
        $data=$request->all();
        $plantel=Plantel::find($data['plantel_f']);
        $registros=Cliente::select(DB::raw('clientes.id as cliente, '
                . 'concat(clientes.nombre," ",clientes.nombre2," ",clientes.ape_paterno," ",clientes.ape_materno) as cliente_nombre,'
                . 'clientes.beca_porcentaje as monto_inscripcion, clientes.monto_mensualidad, clientes.justificacion_beca,'
                . 'sts.name as estatus_seguimiento, stc.name as estatus_cliente, beca_bnd'))
                ->join('combinacion_clientes as cc','cc.cliente_id','=','clientes.id')
                ->join('seguimientos as s','s.cliente_id','=','clientes.id')
                ->join('st_seguimientos as sts','sts.id','=','s.st_seguimiento_id')
                ->join('st_clientes as stc','stc.id','=','clientes.st_cliente_id')
                ->where('beca_bnd',1)
                ->where('clientes.st_cliente_id',4)
                ->where('s.st_seguimiento_id',2)
                ->where('clientes.plantel_id',$data['plantel_f'])
                ->get();
        return view('pagos.reportes.postAlumnosBeca', array('registros'=>$registros,
                                                                  'plantel'=>$plantel,
                                                                  'data'=>$data));
    }
}
