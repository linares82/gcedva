<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

use App\Adeudo;
use App\Cliente;
use App\Caja;
use App\CajaLn;
use App\CombinacionCliente;
use App\CajaConcepto;
use App\Empleado;
use App\Pago;
use App\Plantel;
use App\PlanPago;
use App\PlanPagoLn;
use App\PromoPlanLn;
use App\ReglaRecargo;
use App\StCaja;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateAdeudo;
use App\Http\Requests\createAdeudo;
use PDF;
use Illuminate\Support\Facades\Cache;
use DB;
use Log;

class AdeudosController extends Controller {
        public $plantel=0;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$adeudos = Adeudo::getAllData($request);

		return view('adeudos.index', compact('adeudos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('adeudos.create')
			->with( 'list', Adeudo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createAdeudo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Adeudo::create( $input );

		return redirect()->route('adeudos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Adeudo $adeudo)
	{
		$adeudo=$adeudo->find($id);
		return view('adeudos.show', compact('adeudo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Adeudo $adeudo)
	{
		$adeudo=$adeudo->find($id);
		return view('adeudos.edit', compact('adeudo'))
			->with( 'list', Adeudo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Adeudo $adeudo)
	{
		$adeudo=$adeudo->find($id);
		return view('adeudos.duplicate', compact('adeudo'))
			->with( 'list', Adeudo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Adeudo $adeudo, updateAdeudo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$adeudo=$adeudo->find($id);
		$adeudo->update( $input );

		return redirect()->route('adeudos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Adeudo $adeudo)
	{
		$adeudo=$adeudo->find($id);
		$adeudo->delete();

                $cliente=Cliente::find($adeudo->cliente_id);
                $combinaciones=CombinacionCliente::where('cliente_id', '=', $cliente->id)->get();
                
		return view('cajas.caja', compact('cliente', 'combinaciones'))
                        ->with( 'list', Caja::getListFromAllRelationApps() )
                        ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
	}
        
        public function imprimirInicial(Request $request){
            $data=$request->all();
            //dd($data);
            $cliente=Cliente::find($data['cliente']);
            $cliente->st_cliente_id=22;
            $cliente->save();
            $plantel=Plantel::find($cliente->plantel_id);
            $combinacion=CombinacionCliente::find($data['combinacion']);
            if($combinacion->cuenta_ticket_pago==0){
                foreach($combinacion->planPago->Lineas as $adeudo){
                    $registro['cliente_id']=$cliente->id;
                    $registro['caja_id']=0;
                    $registro['combinacion_cliente_id']=$combinacion->id;
                    $registro['caja_concepto_id']=$adeudo->caja_concepto_id;
                    $registro['cuenta_contable_id']=$adeudo->cuenta_contable_id;
                    $registro['cuenta_recargo_id']=$adeudo->cuenta_recargo_id;
                    $registro['fecha_pago']=$adeudo->fecha_pago;
                    $registro['monto']=$adeudo->monto;
                    $registro['inicial_bnd']=$adeudo->inicial_bnd;
                    $registro['pagado_bnd']=0;
                    $registro['plan_pago_ln_id']=$adeudo->id;
                    $registro['usu_alta_id']=Auth::user()->id;
                    $registro['usu_mod_id']=Auth::user()->id;
                    //dd($registro);
                    Adeudo::create( $registro );
                }
            }
            $combinacion->cuenta_ticket_pago=$combinacion->cuenta_ticket_pago+1;
            $combinacion->save();
            
            $adeudos=Adeudo::where('cliente_id', '=', $cliente->id)->where('combinacion_cliente_id', '=', $combinacion->id)->get();
            $empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();
            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y h:i:s');
            
            //dd($adeudo->toArray());
            return view('adeudos.ticket_adeudo_inicial', array('cliente'=>$cliente, 
                                                               'adeudos'=>$adeudos, 
                                                               'empleado'=>$empleado, 
                                                               'fecha'=>$date,
                                                               'combinacion'=>$combinacion,
                                                               'plantel'=>$plantel ));
            
            /*PDF::setOptions(['defaultFont' => 'arial']);
            $paper58mm100 = array(0,0,164.4,283.46);
            
            $pdf = PDF::loadView('adeudos.ticket_adeudo_inicial', array('cliente'=>$cliente, 'adeudos'=>$adeudos))
                    //->setPaper('A8', 'portrait');
                    ->setPaper($paper58mm100, 'portrait');
            return $pdf->download('reporte.pdf');
            */
        }

        public function reporteAdeudosPendientes(){
            
            $planteles=Plantel::pluck('razon','id');
            return view('adeudos.reportes.adeudosXPlantel',compact('planteles'));
        }
        
        public function reporteAdeudosPendientesr(Request $request){
            $datos=$request->all();
            
            
            $fecha=date('Y/m/d');
            //dd($fecha);
            //$empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();
            
            $plantel=Plantel::find($datos['plantel_f']);
            //dd($plantel);
            /*$adeudosPendientes=Adeudo::select('esp.name as especialidad','n.name as nivel','g.name as grado','c.id as cliente','c.nombre','c.nombre2',
                                              'c.ape_paterno','c.ape_materno','adeudos.fecha_pago','adeudos.monto')
                                     ->join('combinacion_clientes as cc','cc.id',"=",'adeudos.combinacion_cliente_id')
                                     ->join('especialidads as esp','esp.id','=','cc.especialidad_id')
                                     ->join('nivels as n','n.id','=','cc.nivel_id')
                                     ->join('grados as g','g.id','=','cc.grado_id')
                                     ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                                     ->where('pagado_bnd', '=', 0)  
                                     ->whereDate('fecha_pago', '<', $fecha)
                                     ->where('c.plantel_id', '=', session('plantel'))
                                     ->orderBy('c.id', 'asc')
                                     ->orderBy('adeudos.combinacion_cliente_id', 'asc')
                                     //->get();
                                     ->paginate(100);
             * 
             */
            
            $adeudosPendientes=Adeudo::select('esp.name as especialidad','n.name as nivel','g.name as grado','c.id as cliente','c.nombre','c.nombre2',
                                              'c.ape_paterno','c.ape_materno',DB::raw('sum(adeudos.monto) as deuda'))
                                     ->join('combinacion_clientes as cc','cc.id',"=",'adeudos.combinacion_cliente_id')
                                     ->join('especialidads as esp','esp.id','=','cc.especialidad_id')
                                     ->join('nivels as n','n.id','=','cc.nivel_id')
                                     ->join('grados as g','g.id','=','cc.grado_id')
                                     ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                                     //->where('pagado_bnd', '=', 0)  
                                     ->whereDate('adeudos.fecha_pago', '<=', $fecha)
                                     ->where('c.plantel_id', '=', $datos['plantel_f'])
                                     ->groupBy('esp.name')->groupBy('n.name')->groupBy('g.name')->groupBy('c.id')
                                     ->groupBy('c.nombre')->groupBy('c.nombre2')->groupBy('c.ape_paterno')->groupBy('c.ape_materno')
                                     ->orderBy('c.id', 'asc')
                                     ->get();
            
            //dd($adeudosPendientes);
            return view('adeudos.reportes.adeudos_pendientes', array('adeudos'=>$adeudosPendientes, 'plantel'=>$plantel));
            
            /*$pdf = PDF::loadView('adeudos.adeudos_pendientes', array('adeudos'=>$adeudosPendientes, 'plantel'=>$plantel))
                    ->setPaper('Letter', 'portrait');
            return $pdf->download('AdeudosPendientes.pdf');
            */
        }
        
        public function reporteAdeudosPlan(){
            
            $planteles=Plantel::pluck('razon','id');
            $planes= PlanPago::pluck('name','id');
            $conceptos=CajaConcepto::pluck('name','id');
            //dd($conceptos);
            $estatus=StCaja::pluck('name','id');
            return view('adeudos.reportes.adeudosXPlan',compact('planteles','planes','estatus','conceptos'));
        }
        
        public function reporteAdeudosPlanr(Request $request){
            $datos=$request->all();
            //dd($datos);
            
            $fecha=date('Y/m/d');
            //dd($fecha);
            //$empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();
            
            $plantel=Plantel::find($datos['plantel_f']);
            
            $cajas= PlanPago::select('plan_pagos.name as plan','caj.id as caja','caj.consecutivo','c.id as cliente','c.nombre','c.nombre2',
                                     'c.ape_paterno','c.ape_materno','st.name as estatus', 'st.id as estatus_caja','p.razon')
                              ->join('combinacion_clientes as cc','cc.plan_pago_id','=','plan_pagos.id')
                              ->join('clientes as c','c.id','=','cc.cliente_id')
                              ->join('cajas as caj','caj.cliente_id','=','c.id')
                              ->join('plantels as p','p.id','=','c.plantel_id')
                              ->join('st_cajas as st','st.id','=','caj.st_caja_id')
                              ->whereIn('plan_pagos.id',$datos['plan_f'])
                              //->where('plan_pagos.id','<=',$datos['plan_t'])
                              ->where('c.plantel_id', '=', $datos['plantel_f'])
                              ->where('caj.st_caja_id', '=', $datos['estatus_f'])
                              //->where('st.id','<>',2)
                              ->whereNull('cc.deleted_at')
                              ->orderBy('c.plantel_id','plan_pagos.id','c.id')
                              ->get();
            //dd($cajas->toArray());
            return view('adeudos.reportes.adeudosPlanr', 
                    array('cajas'=>$cajas, 'plantel'=>$plantel, 'plan'=>$datos['plan_f'],'datos'=>$datos));
            
            /*$pdf = PDF::loadView('adeudos.adeudos_pendientes', array('adeudos'=>$adeudosPendientes, 'plantel'=>$plantel))
                    ->setPaper('Letter', 'portrait');
            return $pdf->download('AdeudosPendientes.pdf');
            */
        }
        
        public function destroyAll(Request $request)
	{
                $datos=$request->all();
                $combinacion= CombinacionCliente::find($datos['combinacion']);
                $combinacion->cuenta_ticket_pago=0;
                $combinacion->save();
		$adeudos=Adeudo::where('cliente_id',$datos['cliente'])
                               ->where('combinacion_cliente_id', $datos['combinacion'])
                               ->get();
                if(count($adeudos)>0){
                    foreach($adeudos as $adeudo){
                        $adeudo->delete();
                    }
                }
		return redirect()->route('clientes.edit',array('id'=>$datos['cliente']))->with('message', 'Registro Borrado.');
	}
        
        public function editMonto(Request $request){
            $datos=$request->all();
            //dd($datos);
            $adeudo=Adeudo::find($datos['id']);
            $adeudo->monto=$datos['monto'];
            $adeudo->save();
            echo json_encode(array('monto'=>$datos['monto']));
        }
        
        public function cambiarPlanPagos(Request $request){
            $data=$request->all();
            $adeudos_sin_pagar=Adeudo::where('cliente_id',$data['cliente'])
                                     ->where('pagado_bnd',0)
                                     ->delete();
            $mensualidades_pagadas=Adeudo::where('cliente_id',$data['cliente'])
                                         ->where('pagado_bnd',1)
                                         ->join('caja_conceptos as cc','cc.id','=','adeudos.caja_concepto_id')
                                         ->where('cc.bnd_mensualidad',1)
                                         ->get();
            
            $cliente=Cliente::find($data['cliente']);
            //$cliente->st_cliente_id=22;
            //$cliente->save();
            $plantel=Plantel::find($cliente->plantel_id);
            $combinacion=CombinacionCliente::find($data['combinacion']);
            $combinacion->cuenta_ticket_pago=1;
            $combinacion->save();
            $i=0;
            $descarte_inicial=0;
            foreach($combinacion->planPago->Lineas as $adeudo){
                //conceptos diferentes de mensualidad, se ignoran los ´primeros 3
                //if($adeudo->cajaConcepto->bnd_mensualidad<>1 and $descarte_inicial>3){
                    $registro['cliente_id']=$cliente->id;
                    $registro['caja_id']=0;
                    $registro['combinacion_cliente_id']=$combinacion->id;
                    $registro['caja_concepto_id']=$adeudo->caja_concepto_id;
                    $registro['cuenta_contable_id']=$adeudo->cuenta_contable_id;
                    $registro['cuenta_recargo_id']=$adeudo->cuenta_recargo_id;
                    $registro['fecha_pago']=$adeudo->fecha_pago;
                    $registro['monto']=$adeudo->monto;
                    $registro['inicial_bnd']=$adeudo->inicial_bnd;
                    $registro['pagado_bnd']=0;
                    $registro['plan_pago_ln_id']=$adeudo->id;
                    $registro['usu_alta_id']=Auth::user()->id;
                    $registro['usu_mod_id']=Auth::user()->id;
                    //dd($registro);
                    Adeudo::create( $registro );
                    //$descarte_inicial++;
                    //Mensualidadaes se descarta la misma cantidad que ya se haya pagado en el plan anterior
                /*}elseif($adeudo->cajaConcepto->bnd_mensualidad==1 and $i>count($mensualidades_pagadas)){
                    $registro['cliente_id']=$cliente->id;
                    $registro['caja_id']=0;
                    $registro['combinacion_cliente_id']=$combinacion->id;
                    $registro['caja_concepto_id']=$adeudo->caja_concepto_id;
                    $registro['cuenta_contable_id']=$adeudo->cuenta_contable_id;
                    $registro['cuenta_recargo_id']=$adeudo->cuenta_recargo_id;
                    $registro['fecha_pago']=$adeudo->fecha_pago;
                    $registro['monto']=$adeudo->monto;
                    $registro['inicial_bnd']=$adeudo->inicial_bnd;
                    $registro['pagado_bnd']=0;
                    $registro['plan_pago_ln_id']=$adeudo->id;
                    $registro['usu_alta_id']=Auth::user()->id;
                    $registro['usu_mod_id']=Auth::user()->id;
                    //dd($registro);
                    Adeudo::create( $registro );
                    $i++;
                } */                   
            }
            
            //$combinacion->cuenta_ticket_pago=$combinacion->cuenta_ticket_pago+1;
            $combinacion->save();
            
            //$adeudos=Adeudo::where('cliente_id', '=', $cliente->id)->where('combinacion_cliente_id', '=', $combinacion->id)->get();
            //$empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();
            //$carbon = new \Carbon\Carbon();
            //$date = $carbon->now();
            //$date = $date->format('d-m-Y h:i:s');
            
            //dd($adeudo->toArray());
            /*return view('adeudos.ticket_adeudo_inicial', array('cliente'=>$cliente, 
                                                               'adeudos'=>$adeudos, 
                                                               'empleado'=>$empleado, 
                                                               'fecha'=>$date,
                                                               'combinacion'=>$combinacion,
                                                               'plantel'=>$plantel ));
            */
            return redirect()->route('clientes.edit', $cliente->id)->with('message', 'Registro Creado.')->with('list', Cliente::getListFromAllRelationApps());
        }
        
        public function ajustarAdeudosSegunPlan(){
            $planes=PlanPagoLn::whereIn('plan_pago_id',array(2,3,5,8,23,24,29))
                    ->where('caja_concepto_id',46)
                    ->orderBy('plan_pago_id')
                    ->get();
            
            $csvDatos=array('id, cliente_id, caja_concepto_id, cuenta_contable_id, cuenta_recargo_id, fecha_pago, monto, inicial_bnd, pagado_bnd, '
                        . 'plan_pago_ln_id, usu_alta_id, usu_mod_id, created_at, update_at, deleted_at, combinacion_cliente_id, caja_id');
            foreach($planes as $plan){
                $combinaciones=CombinacionCliente::where('plan_pago_id',$plan->plan_pago_id)
                               ->where('combinacion_clientes.especialidad_id','<>',0)
                                ->where('combinacion_clientes.nivel_id','<>',0)
                                ->where('combinacion_clientes.grado_id','<>',0)
                                ->where('combinacion_clientes.turno_id','<>',0)
                                ->whereNull('combinacion_clientes.deleted_at')
                                ->get();
                foreach($combinaciones as $combinacion){
                    $adeudos=Adeudo::where('cliente_id',$combinacion->cliente_id)
                            ->where('caja_concepto_id',46)
                            ->where('combinacion_cliente_id',$combinacion->id)
                            ->first();
                    //dd($adeudos);
                    if(!is_object($adeudos)){
                        
                        $adeudo_nuevo['cliente_id']=$combinacion->cliente_id;
                        $adeudo_nuevo['caja_concepto_id']=$plan->caja_concepto_id;
                        $adeudo_nuevo['cuenta_contable_id']=$plan->cuenta_contable_id;
                        $adeudo_nuevo['cuenta_recargo_id']=$plan->cuenta_recargo_id;
                        $adeudo_nuevo['fecha_pago']=$plan->fecha_pago;
                        $adeudo_nuevo['monto']=$plan->monto;
                        $adeudo_nuevo['inicial_bnd']=$plan->inicial_bnd;
                        $adeudo_nuevo['pagado_bnd']=0;
                        $adeudo_nuevo['plan_pago_ln_id']=$plan->id;
                        $adeudo_nuevo['usu_alta_id']=1;
                        $adeudo_nuevo['usu_mod_id']=1;
                        $adeudo_nuevo['created_t']='2019-06-07 00:00:00';
                        $adeudo_nuevo['update_at']='2019-06-07 00:00:00';
                        $adeudo_nuevo['combinacion_cliente_id']=$combinacion->id;
                        $adeudo_nuevo['caja_id']=0;
                        $a=Adeudo::create($adeudo_nuevo);
                        
                        $csvDatos[]=$a->id.','.$combinacion->cliente_id.','.$plan->caja_concepto_id.','.$plan->cuenta_contable_id.','.$plan->cuenta_recargo_id.','.
                                $plan->fecha_pago.','.$plan->monto.','.$plan->inicial_bnd.','.'0'.','.$plan->id.','.'1'.','.'1'.','.'NULL'.','.'NULL'.','.
                                'NULL'.','.$combinacion->id.','.'0';
                        
                        
                    }
                    
                }
            }
            //dd($csvDatos);
            $filename=date('Y-m-d').".csv";
            $file_path=public_path().'/'.$filename;   
            $file = fopen($file_path,"w+");
            foreach ($csvDatos as $exp_data){
              fputcsv($file,explode(',',$exp_data));
            }   
            fclose($file);          

            $headers = ['Content-Type' => 'application/csv'];
            return response()->download($file_path,$filename,$headers );
        }
        
        public function adeudosPagos(){
            $planteles=Plantel::pluck('razon','id');
            $conceptos=CajaConcepto::pluck('name','id');
            $stCajas=StCaja::pluck('name','id');
            //dd($stCajas);
            return view('adeudos.reportes.adeudosPagos', compact('planteles','conceptos','stCajas'));
        }
        
        public function adeudosPagosR(Request $request){
            
            $datos=$request->all(); 
            //dd($datos);
            $fecha_reporte=date('Y-m-d');
            $reglas=ReglaRecargo::where('porcentaje','>',0)->get();
                       
            
                $adeudos=Adeudo::select(DB::raw('adeudos.id, p.razon, concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as nombre_cliente, '
                    . 'c.id as cliente, pp.name as plan_pago, adeudos.monto as monto_planeado, adeudos.fecha_pago as fecha_pago_planeada,'
                    . 'con.name as concepto, caj.fecha as fecha_caja, adeudos.pagado_bnd, adeudos.caja_id, adeudos.caja_concepto_id, caj.consecutivo,'
                    . 'adeudos.plan_pago_ln_id'))
                            ->join('clientes as c','c.id','=','adeudos.cliente_id')
                            ->join('seguimientos as s','s.cliente_id','=','c.id')
                            ->join('plantels as p','p.id','=','c.plantel_id')
                            ->join('plan_pago_lns as ppln','ppln.id','=','adeudos.plan_pago_ln_id')
                            ->join('plan_pagos as pp','pp.id','=','ppln.plan_pago_id')
                            ->leftJoin('cajas as caj','caj.id','=','adeudos.caja_id')
                            //->leftJoin('pagos as pag','pag.caja_id','=','caj.id')
                            //->leftJoin('forma_pagos as fp','fp.id','=','pag.forma_pago_id')
                            ->join('caja_conceptos as con','con.id','=','adeudos.caja_concepto_id')
                            ->join('combinacion_clientes as cc','cc.id','=','adeudos.combinacion_cliente_id')
                            ->where('cc.especialidad_id','<>',0)
                            ->where('cc.nivel_id','<>',0)
                            ->where('cc.grado_id','<>',0)
                            ->where('cc.turno_id','<>',0)
                            ->where('adeudos.fecha_pago','>=',$datos['fecha_f'])
                            ->where('adeudos.fecha_pago','<=',$datos['fecha_t'])
                            ->where('c.plantel_id','>=',$datos['plantel_f'])
                            ->where('c.plantel_id','<=',$datos['plantel_t'])
                            ->whereIn('adeudos.caja_concepto_id',$datos['concepto_f'])
                            //->whereColumn('adeudos.caja_concepto_id','ln.caja_concepto_id')
                            ->where('s.st_seguimiento_id','<>',3)
                            //->where('caj.st_caja_id', $datos['st_caja_f'])
                            ->whereNull('adeudos.deleted_at')
                            ->whereNull('cc.deleted_at')
                            ->whereNull('c.deleted_at')
                            ->whereNull('caj.deleted_at')
                            ->whereNull('ppln.deleted_at')
                            //->whereNull('pag.deleted_at')
                            ->orderBy('p.razon')
                            ->orderBy('adeudos.caja_id')
                            ->orderBy('c.id')
                            ->orderBy('caj.st_caja_id')
                            ->orderBy('adeudos.id')
                            ->get();
                    
            
            //dd($adeudos);
            
            $registros=array();
            $vcaja=0;
            $vconcepto=0;
            foreach($adeudos as $adeudo){
                $adeudo_monto=0;
                $pago_monto=0;
                if($adeudo->caja_id>0){
                    $linea_caja=CajaLn::select('caja_lns.*','st.name as estatus')
                                      ->join('cajas as c','c.id','=','caja_lns.caja_id')
                                      ->join('st_cajas as st','st.id','=','c.st_caja_id')  
                                      ->where('caja_id',$adeudo->caja_id)
                                      ->where('caja_concepto_id',$adeudo->caja_concepto_id)
                                      ->whereNull('caja_lns.deleted_at')
                                      ->first();
                    $pagos=Pago::where('caja_id',$linea_caja->caja_id)->get();
                    $monto_pago_suma=0;
                    foreach($pagos as $pago){
                        $monto_pago_suma=$monto_pago_suma+$pago->monto;
                    }
                    
                    $vadeudo=0;
                    $vpago=0;
                    $pago_monto=$linea_caja->total;
                    if($linea_caja->estatus=='Pago Parcial' and $vcaja<>$adeudo->caja_id){
                        $vadeudo=$linea_caja->total-$monto_pago_suma;
                        $vpago=$monto_pago_suma;
                    }else{
                        $vadeudo=$adeudo_monto;
                        $vpago=$pago_monto;
                    }
                    
                    $vcaja=$adeudo->caja_id;
                    $vconcepto=$adeudo->caja_concepto_id;
                    
                    $row=array('id'=>$adeudo->id,
                              'razon'=>$adeudo->razon,
                              'cliente'=>$adeudo->cliente,
                              'nombre_cliente'=>$adeudo->nombre_cliente,
                              'plan_pago'=>$adeudo->plan_pago,  
                              'monto_planeado'=>$adeudo->monto_planeado,
                              'concepto'=>$adeudo->concepto,
                              'fecha_pago_planeada'=>$adeudo->fecha_pago_planeada,
                              'fecha_caja'=>$adeudo->fecha_caja,
                              'monto_descuento'=>$linea_caja->descuento,
                              'monto_recargo'=>$linea_caja->recargo,
                              'pago'=>$vpago,
                              'adeudo'=>$vadeudo,
                              'caja_id'=>$adeudo->caja_id,
                              'st_caja'=>$linea_caja->estatus,
                              'consecutivo'=>$adeudo->consecutivo,
                              'plan_pago_ln'=>$adeudo->plan_pago_ln_id,
                              'monto_pago_suma'=>$monto_pago_suma,
                               );
                    array_push($registros,$row);
                }else{
                    $caja_ln_calculada=$this->calculaAdeudo($adeudo->id, $adeudo->cliente);
                    $row=array('id'=>$adeudo->id,
                              'razon'=>$adeudo->razon,
                              'cliente'=>$adeudo->cliente,
                              'nombre_cliente'=>$adeudo->nombre_cliente,
                              'plan_pago'=>$adeudo->plan_pago,  
                              'monto_planeado'=>$adeudo->monto_planeado,
                              'concepto'=>$adeudo->concepto,
                              'fecha_pago_planeada'=>$adeudo->fecha_pago_planeada,
                              'fecha_caja'=>$adeudo->fecha_caja,
                              'monto_descuento'=>$caja_ln_calculada['descuento'],
                              'monto_recargo'=>$caja_ln_calculada['recargo'],
                              'pago'=>0,
                              'adeudo'=>$caja_ln_calculada['total'],
                              'caja_id'=>$adeudo->caja_id,
                              'st_caja'=>'',
                              'consecutivo'=>'',
                              'plan_pago_ln'=>$adeudo->plan_pago_ln_id,
                              'monto_pago_suma'=>0,
                               );
                    array_push($registros,$row);
                }
                
            }
            //$c=Collection::make($registros);
            
            //dd(Collection::make($registros));
            return view('adeudos.reportes.adeudosPagosR', array('fecha_reporte'=>$fecha_reporte,
                                                                'registros'=>$registros,
                                                                'adeudos'=>$adeudos,    
                                                                'reglas'=>$reglas));
        }
        
        public function calculaAdeudo($adeudo_tomado, $vcliente){
            //foreach($data['adeudos_tomados'] as $adeudo_tomado){
                $adeudos=Adeudo::where('id', '=', $adeudo_tomado)->get();
                //$caja=Caja::find(); 
                $cliente=Cliente::find($vcliente);
                
                //dd($adeudos->toArray());
                $subtotal=0;
                $recargo=0;
                $descuento=0;
                //dd($adeudos->toArray());

                foreach($adeudos as $adeudo){
                    $existe_linea=CajaLn::where('adeudo_id','=',$adeudo->id)->first();
                    if(!is_object($existe_linea)){
                        
                        //$caja_ln['caja_id']=$caja->id;
                        $caja_ln['caja_concepto_id']=$adeudo->caja_concepto_id;
                        $caja_ln['subtotal']=$adeudo->monto;
    //                    dd($adeudo->planPagoLn->reglaRecargos);
                        $caja_ln['total']=0;
                        $caja_ln['recargo']=0;
                        $caja_ln['descuento']=0;
                        foreach($adeudo->planPagoLn->reglaRecargos as $regla){
                            $fecha_caja=Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                            $fecha_adeudo=Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                            $dias=$fecha_caja->diffInDays($fecha_adeudo);
                            if($fecha_caja < $fecha_adeudo){
                                $dias=$dias*-1;
                            }
                            //dd($dias);
                            //$dia=$dias->format('%R%a')*-1;

                            //calcula recargo o descuento segun regla y aplica
                            if($dias>=$regla->dia_inicio and $dias<=$regla->dia_fin){
                                if($regla->tipo_regla_id==1){
                                    //dd($regla->porcentaje);
                                    if($regla->porcentaje>0){
                                        //dd($regla->porcentaje);
                                        $caja_ln['recargo']=$adeudo->monto*$regla->porcentaje;
                                        //echo $caja_ln['recargo'];
                                    }else{
                                        $caja_ln['descuento']=$adeudo->monto*$regla->porcentaje*-1;
                                        //echo $caja_ln['descuento'];
                                    }

                                }elseif($regla->tipo_regla_id==2){
                                    if($regla->monto>0){
                                        $caja_ln['recargo']=$regla->monto;
                                    }else{
                                        $caja_ln['descuento']=$regla->monto*-1;
                                    }

                                }
                            }

                        }
                        $caja_ln['total']=0;
                        $caja_ln['total']=$caja_ln['subtotal']+$caja_ln['recargo']-$caja_ln['descuento'];

                        //calcula descuento segun promocion ligada a la linea del plan considerando la fecha de pago de la
                        //inscripcion del cliente
                        //dd($adeudo);
                        try{
                            $promociones= PromoPlanLn::where('plan_pago_ln_id',$adeudo->plan_pago_ln_id)->get();
                            $caja_ln['promo_plan_ln_id']=0;
                            Log::info($cliente->id."FLC:".$cliente->beca_bnd."-".$adeudo->combinacionCliente->bnd_beca);
                            if($cliente->beca_bnd<>1 and $adeudo->combinacionCliente->bnd_beca<>1){
                                foreach($promociones as $promocion){
                                    $inscripcion=Adeudo::where('cliente_id',$adeudo->cliente_id)
                                                        //->where('plan_pago_ln_id',$adeudo->plan_pago_ln_id)
                                                        ->where('caja_concepto_id',1)
                                                        ->where('combinacion_cliente_id',$adeudo->combinacion_cliente_id)
                                                        ->where('pagado_bnd',1)
                                                        ->first();

//dd($inscripcion);
                                    if(is_object($inscripcion)){
                                        $inicio=Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                                        $fin=Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);

                                        //$hoy=date('Y-m-d');
                                        //$hoy=Carbon::now();
                                        //La caja tiene la fecha de pago de un solo concepto que debe ser la inscripcion
                                        $caja_inscripcion=Caja::find($inscripcion->caja_id);
//dd($caja);
                                        $hoy=Carbon::createFromFormat('Y-m-d', $caja_inscripcion->fecha);
                                        //$hoy=Carbon::createFromFormat('Y-m-d', $adeudo->caja->fecha);  
//dd($hoy);
                                        $monto_promocion=0;
                                        //dd($hoy);
                                        if($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id']==0){

                                            $monto_promocion=$promocion->descuento*$caja_ln['total'];
                                            $caja_ln['descuento']=$caja_ln['descuento']+$monto_promocion;
                                            $caja_ln['promo_plan_ln_id']=$promocion->id;
                                        }
                                    }else{
                                        $inicio=Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                                        $fin=Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);

                                        //$hoy=date('Y-m-d');
                                        //$hoy=Carbon::now();
                                        //La caja tiene la fecha de pago de un solo concepto que debe ser la inscripcion
                                        //dd($inscripcion);
                                        //$caja_inscripcion=Caja::find($caja->id);
                                        $hoy=Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                                        $monto_promocion=0;
                                        //dd($hoy);
                                        if($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id']==0){

                                            $monto_promocion=$promocion->descuento*$caja_ln['total'];
                                            $caja_ln['descuento']=$caja_ln['descuento']+$monto_promocion;
                                            $caja_ln['promo_plan_ln_id']=$promocion->id;
                                        }
                                    }

                                }
                            }elseif($cliente->beca_bnd==1 and $adeudo->combinacionCliente->bnd_beca==1){
                                if($cliente->monto_mensualidad>0 and is_int(strpos($adeudo->cajaConcepto->name,'MENSUALIDAD'))){
                                    $caja_ln['descuento']=$caja_ln['descuento']+$cliente->monto_mensualidad;
                                }
                                if($cliente->beca_porcentaje>0 and is_int(strpos($adeudo->cajaConcepto->name,'INSCRIP'))){
                                    $caja_ln['descuento']=$caja_ln['descuento']+$cliente->beca_porcentaje;
                                }
                            }
                            //dd($promocion);
                            //if(is_object($promocion)){

                            //dd($monto_promocion);
                            //dd($caja_ln);
                        }catch(Exception $e){
                            dd($e);
                        }
                        $caja_ln['total']=$caja_ln['subtotal']+$caja_ln['recargo']-$caja_ln['descuento'];


                        $caja_ln['adeudo_id']=$adeudo->id;
                        $caja_ln['usu_alta_id']=Auth::user()->id;
                        $caja_ln['usu_mod_id']=Auth::user()->id;
                        /*if($cliente->beca_bnd==1 and $caja_ln['caja_concepto_id']==1){
                            $caja_ln['descuento']=$caja_ln['descuento']+($caja_ln['subtotal']*$cliente->beca_porcentaje);
                            $caja_ln['total']=$caja_ln['total']-($caja_ln['subtotal']-$caja_ln['descuento']);
                        }*/
                        //dd($caja_ln);
                        return $caja_ln;
                    }

                }
                
            //}

        }
                    
}
