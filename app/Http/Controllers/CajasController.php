<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Caja;
use App\CajaLn;
use App\Adeudo;
use App\Cliente;
use App\Pago;
use App\Plantel;
use App\PromoPlanLn;
use App\Empleado;
use App\CombinacionCliente;
use App\CajaConcepto;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCaja;
use App\Http\Requests\createCaja;
use DB;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Session;

class CajasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cajas = Caja::getAllData($request);

		return view('cajas.index', compact('cajas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cajas.create')
			->with( 'list', Caja::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCaja $request)
	{
		$input = $request->all();
                //dd($input);
                $cliente=Cliente::find($input['cliente_id']);
                
                $caja=Caja::where('st_caja_id',0)->where('plantel_id',$cliente->plantel_id)->get();
                
                $cajas=Caja::select('cajas.consecutivo as caja','ln.caja_concepto_id as concepto_id','cc.name as concepto', 'ln.total','st.name as estatus')
                    ->join('caja_lns as ln','ln.caja_id','=','cajas.id')
                    ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
                    ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                    ->where('cliente_id',$cliente->id)
                    ->get();
                 /*$validator = Validator::make($request->all(), [
                        'st_caja_id' => 'unique:cajas',
                    ],
                    [
                        'st_caja_id.unique' => 'Estatus de caja exitente e invalido, se debe pagar parcialmente, cancelar o pagar',
                    ]);
                 
                 
                 
                 if ($validator->fails()) {*/
                //dd($caja);
                if(count($caja)>0){
                    $ids_invalidos=Caja::select('cajas.consecutivo','p.cve_plantel','cajas.cliente_id')
                                       ->join('plantels as p','p.id','=','cajas.plantel_id')
                                       ->where('plantel_id',$cliente->plantel_id)
                                       ->where('cajas.st_caja_id','=',0)->where('cajas.id','>',0)->get(); 
                    //dd($ids_invalidos);
                    Session::flash('ids_invalidos', $ids_invalidos->toArray());
                    //dd(session('ids_invalidos'));
                    return redirect()->route('cajas.caja')
                        //->withErrors($validator)
                        ->withInput();
                }
                //}
                
                $empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();
                
                
                $cliente=Cliente::find($input['cliente_id']);
                $plantel=Plantel::find($cliente->plantel_id);
                
                $caja_r['cliente_id']=$cliente->id;
                $caja_r['plantel_id']=$cliente->plantel_id;
                $caja_r['forma_pago_id']=0;
                $caja_r['fecha']=$input['fecha'];
                $caja_r['subtotal']=0;
                $caja_r['descuento']=0;
                $caja_r['recargo']=0;

                $caja_r['total']=0;
                $caja_r['st_caja_id']=0;
                $caja_r['usu_alta_id']=Auth::user()->id;
                $caja_r['usu_mod_id']=Auth::user()->id;
                $caja_r['consecutivo']=$plantel->consecutivo+1;
                
                $caja=Caja::create($caja_r);
                
                $plantel->consecutivo=$plantel->consecutivo+1;
                $plantel->save();
                
                
                $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
		
		return view('cajas.caja', compact('cliente', 'caja','combinaciones','cajas'))
                        ->with( 'list', Caja::getListFromAllRelationApps() )
                        ->with( 'list1', CajaLn::getListFromAllRelationApps() );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Caja $caja)
	{
		$caja=$caja->find($id);
		return view('cajas.show', compact('caja'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Caja $caja)
	{
		$caja=$caja->find($id);
                $cliente=Cliente::find($caja->cliente_id);
                $cajas=Caja::select('cajas.consecutivo as caja','ln.caja_concepto_id as concepto_id','cc.name as concepto', 'ln.total','st.name as estatus')
                    ->join('caja_lns as ln','ln.caja_id','=','cajas.id')
                    ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
                    ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                    ->where('cliente_id',$cliente->id)
                    ->get();
                $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
		return view('cajas.caja', compact('caja', 'cliente','combinaciones','cajas'))
			->with( 'list', Caja::getListFromAllRelationApps() )
                        ->with( 'list1', CajaLn::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Caja $caja)
	{
		$caja=$caja->find($id);
		return view('cajas.duplicate', compact('caja'))
			->with( 'list', Caja::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Caja $caja, updateCaja $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$caja=$caja->find($id);
		$caja->update( $input );

		return redirect()->route('cajas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Caja $caja)
	{
		$caja=$caja->find($id);
		$caja->delete();

		return redirect()->route('cajas.index')->with('message', 'Registro Borrado.');
	}

        public function getCaja(){
            return view('cajas.caja')->with( 'list', Caja::getListFromAllRelationApps() )->with( 'list1', CajaLn::getListFromAllRelationApps() );           
        }
        
        public function buscarCliente(Request $request){
            $empleado= Empleado::where('user_id', Auth::user()->id)->first();
            $cliente=Cliente::find($request->cliente_id);
            if(!is_object($cliente)){
                Session::flash('msj', 'Cliente no existe');
                return view('cajas.caja')->with( 'list', Caja::getListFromAllRelationApps() )->with( 'list1', CajaLn::getListFromAllRelationApps() );           
            }
            //$adeudos=Adeudo::where('cliente_id', '=', $cliente->id)->get();
            //dd($cliente);
            $combinaciones=CombinacionCliente::where('cliente_id', '=', $cliente->id)->get();
            $cajas=Caja::select('cajas.consecutivo as caja','ln.caja_concepto_id as concepto_id','cc.name as concepto', 'ln.total','st.name as estatus')
                    ->join('caja_lns as ln','ln.caja_id','=','cajas.id')
                    ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
                    ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                    ->where('cliente_id',$cliente->id)
                    ->get();
            /*foreach($combinaciones as $c){
                dd($c->adeudos);
            }*/
            //dd($combinaciones);
            //dd(Caja::getListFromAllRelationApps());
            //dd("fil");
            $permiso_caja_buscarCliente=Auth::user()->can('permiso_caja_buscarCliente');
            if(is_object($cliente) and count($combinaciones)>0 and $cliente->plantel_id==$empleado->plantel_id){
                
                return view('cajas.caja', compact('cliente', 'combinaciones','cajas'))
                        ->with( 'list', Caja::getListFromAllRelationApps() )
                        ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
            }elseif(is_object($cliente) and count($combinaciones)>0 and $cliente->plantel_id<>$empleado->plantel_id and $permiso_caja_buscarCliente){
                return view('cajas.caja', compact('cliente', 'combinaciones','cajas'))
                        ->with( 'list', Caja::getListFromAllRelationApps() )
                        ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
            }
            Session::flash('msj', 'Cliente buscado pertenece a otro plantel');
            return view('cajas.caja')->with( 'list', Caja::getListFromAllRelationApps() )->with( 'list1', CajaLn::getListFromAllRelationApps() );           
                  
        }
        
        public function buscarVenta(Request $request){
            $data=$request->all();
            //dd($data);
            $empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();
            //dd($empleado->toArray());
            $caja=Caja::where('consecutivo', '=', $data['consecutivo'])->where('plantel_id', '=', $data['plantel_id'])->first();
            if(!is_object($caja)){
                Session::flash('msj', 'Caja no existe');
                return view('cajas.caja')->with( 'list', Caja::getListFromAllRelationApps() )->with( 'list1', CajaLn::getListFromAllRelationApps() );           
            }
            //dd($caja);
            $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
            $cajas=Caja::select('cajas.consecutivo as caja','ln.caja_concepto_id as concepto_id','cc.name as concepto', 'ln.total','st.name as estatus')
                    ->join('caja_lns as ln','ln.caja_id','=','cajas.id')
                    ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
                    ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                    ->where('cliente_id',$caja->cliente->id)
                    ->get();
            //dd($cajas->toArray());
            $permiso_caja_buscarVenta=Auth::user()->can('permiso_caja_buscarVenta');
            //dd($permiso_caja_buscarVenta);
            if(is_object($caja) and $caja->plantel_id==$empleado->plantel_id){
                //Apliacion de recargos
                if($caja->st_caja_id==0 and $caja->descuento==0){
                    //dd($caja->st_caja_id);
                    $recargo=0;
                    foreach($caja->cajaLns as $ln){
                        //dd($ln->adeudo->planPagoLn->reglaRecargos);
                        if(isset($ln->adeudo->planPagoLn->reglaRecargos) and count($ln->adeudo->planPagoLn->reglaRecargos)>0){
                            foreach($ln->adeudo->planPagoLn->reglaRecargos as $regla){
                                $dias=date_diff(date_create(date_format(date_create(date('Y/m/d')),'Y/m/d')), date_create($ln->adeudo->fecha_pago));
                                $dia=$dias->format('%R%a')*-1;
                                //dd($dia);
                                if($dia >= $regla->dia_inicio and $dia <= $regla->dia_fin){
                                    
                                    if($regla->tipo_regla_id==1){
                                        //dd($regla->porcentaje);
                                        if($regla->porcentaje>0){
                                            //dd($regla->porcentaje);
                                            $ln['recargo']=$ln->adeudo->monto*$regla->porcentaje;
                                            //echo $caja_ln['recargo'];
                                        }else{
                                            $ln['descuento']=$ln->adeudo->monto*$regla->porcentaje*-1;
                                            //echo $caja_ln['descuento'];
                                        }

                                    }elseif($regla->tipo_regla_id==2){
                                        if($regla->monto>0){
                                            $ln['recargo']=$regla->monto;
                                        }else{
                                            $ln['descuento']=$regla->monto*-1;
                                        }

                                    }
                                }
                                $ln->save();
                            }
                        }
                        $recargo=$recargo+$ln['recargo'];
                    }
                    $caja->recargo=$recargo;
                    $caja->total=$caja->subtotal+$caja->recargo;
                    $caja->save();
                }
                
                $cliente=Cliente::find($caja->cliente_id);
                return view('cajas.caja', compact('cliente', 'caja', 'combinaciones','cajas'))
                        ->with( 'list', Caja::getListFromAllRelationApps() )
                        ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
            }elseif(is_object($caja) and $caja->plantel_id<>$empleado->plantel_id and $permiso_caja_buscarVenta){
                //Apliacion de recargos
                if($caja->st_caja_id==0 and $caja->descuento==0){
                    //dd($caja->st_caja_id);
                    $recargo=0;
                    foreach($caja->cajaLns as $ln){
                        //dd($ln->adeudo->planPagoLn->reglaRecargos);
                        if(isset($ln->adeudo->planPagoLn->reglaRecargos) and count($ln->adeudo->planPagoLn->reglaRecargos)>0){
                            foreach($ln->adeudo->planPagoLn->reglaRecargos as $regla){
                                $dias=date_diff(date_create(date_format(date_create(date('Y/m/d')),'Y/m/d')), date_create($ln->adeudo->fecha_pago));
                                $dia=$dias->format('%R%a')*-1;
                                //dd($dia);
                                if($dia >= $regla->dia_inicio and $dia <= $regla->dia_fin){
                                    
                                    if($regla->tipo_regla_id==1){
                                        //dd($regla->porcentaje);
                                        if($regla->porcentaje>0){
                                            //dd($regla->porcentaje);
                                            $ln['recargo']=$ln->adeudo->monto*$regla->porcentaje;
                                            //echo $caja_ln['recargo'];
                                        }else{
                                            $ln['descuento']=$ln->adeudo->monto*$regla->porcentaje*-1;
                                            //echo $caja_ln['descuento'];
                                        }

                                    }elseif($regla->tipo_regla_id==2){
                                        if($regla->monto>0){
                                            $ln['recargo']=$regla->monto;
                                        }else{
                                            $ln['descuento']=$regla->monto*-1;
                                        }

                                    }
                                }
                                $ln->save();
                            }
                        }
                        $recargo=$recargo+$ln['recargo'];
                    }
                    $caja->recargo=$recargo;
                    $caja->total=$caja->subtotal+$caja->recargo;
                    $caja->save();
                }
                
                $cliente=Cliente::find($caja->cliente_id);
                return view('cajas.caja', compact('cliente', 'caja', 'combinaciones','cajas'))
                        ->with( 'list', Caja::getListFromAllRelationApps() )
                        ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
            }
            Session::flash('msj', 'Informacion buscada pertenece a otro plantel');
            
            return view('cajas.caja')->with( 'list', Caja::getListFromAllRelationApps() )->with( 'list1', CajaLn::getListFromAllRelationApps() );           
        }
        
        
        
        //Lineas de la caja con adeudos predefinidos
        public function guardaAdeudoPredefinido(Request $request){
            //dd($request->get('adeudo'));
            $data=$request->all();
            //dd($data['inicial_bnd']);
            /*if($data['inicial_bnd']==1){
                //dd('1');
                $adeudos=Adeudo::where('cliente_id', '=', $data['cliente_id'])
                              ->where('fecha_pago', '=', $data['fecha_pago'])
                              ->where('inicial_bnd', '=', 1)
                              ->where('combinacion_cliente_id', '=', $data['combinacion'])
                              ->get();
            }else{
                
                $adeudos=Adeudo::where('id', '=', $data['adeudo'])->get();
            }*/
            //dd($data[]);
	    $caja=Caja::find($data['caja']); 
            foreach($data['adeudos_tomados'] as $adeudo_tomado){
                $adeudos=Adeudo::where('id', '=', $adeudo_tomado)->get();
                
                $cliente=Cliente::find($data['cliente_id']);
                $cajas=Caja::select('cajas.consecutivo as caja','ln.caja_concepto_id as concepto_id','cc.name as concepto', 'ln.total','st.name as estatus')
                    ->join('caja_lns as ln','ln.caja_id','=','cajas.id')
                    ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
                    ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                    ->where('cliente_id',$cliente->id)
                    ->get();
                //dd($adeudos->toArray());
                $subtotal=0;
                $recargo=0;
                $descuento=0;
                //dd($adeudos->toArray());

                foreach($adeudos as $adeudo){
                    $existe_linea=CajaLn::where('adeudo_id','=',$adeudo->id)->first();
                    if(!is_object($existe_linea)){
                        $adeudo->caja_id=$caja->id;
                        $adeudo->save();
                        $caja_ln['caja_id']=$caja->id;
                        $caja_ln['caja_concepto_id']=$adeudo->caja_concepto_id;
                        $caja_ln['subtotal']=$adeudo->monto;
    //                    dd($adeudo->planPagoLn->reglaRecargos);
                        $caja_ln['total']=0;
                        $caja_ln['recargo']=0;
                        $caja_ln['descuento']=0;
                        foreach($adeudo->planPagoLn->reglaRecargos as $regla){

                            $dias=date_diff(date_create($caja->fecha), date_create($adeudo->fecha_pago));
                            //dd($dias);
                            $dia=$dias->format('%R%a')*-1;

                            //calcula recargo o descuento segun regla y aplica
                            if($dia>=$regla->dia_inicio and $dia<=$regla->dia_fin){
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
                            if($cliente->beca_bnd<>1){
                                foreach($promociones as $promocion){
                                    $inscripcion=Adeudo::where('cliente_id',$adeudo->cliente_id)
                                                        //->where('plan_pago_ln_id',$adeudo->plan_pago_ln_id)
                                                        ->where('caja_concepto_id',1)
                                                        ->where('combinacion_cliente_id',$adeudo->combinacion_cliente_id)
                                                        ->where('pagado_bnd',1)
                                                        ->first();
                                    if(!is_object($inscripcion)){
                                        $inscripcion=Caja::join('caja_lns as ln','ln.caja_id','=','cajas.id')
                                                         ->join('adeudos as a','a.caja_concepto_id','=','ln.caja_concepto_id')
                                                         ->where('ln.caja_concepto_id','=',1)
                                                         ->where('cajas.cliente_id',$adeudo->cliente_id)
                                                         ->orderBy('ln.id','DESC')
                                                         ->first();
                                    }
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
                                        $hoy=Carbon::createFromFormat('Y-m-d', $caja->fecha);
                                        $monto_promocion=0;
                                        //dd($hoy);
                                        if($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id']==0){

                                            $monto_promocion=$promocion->descuento*$caja_ln['total'];
                                            $caja_ln['descuento']=$caja_ln['descuento']+$monto_promocion;
                                            $caja_ln['promo_plan_ln_id']=$promocion->id;
                                        }
                                    }

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
                        $caja_linea=CajaLn::create($caja_ln);
                        $subtotal=$subtotal+$caja_ln['subtotal'];
                        $recargo=$recargo+$caja_ln['recargo'];
                        $descuento=$descuento+$caja_ln['descuento'];
                    }

                }
                if($subtotal>0){
//dd($subtotal);
                    $caja->subtotal=$caja->subtotal+$subtotal;
                    $caja->recargo=$caja->recargo+$recargo;
                    $caja->descuento=$caja->descuento+$descuento;
                    $caja->total=$caja->subtotal+$caja->recargo-$caja->descuento;
//dd($caja); 
                    $caja->save();
                }
            }
            
            //Valida pagos y adeudos para establecer estatus en caja
            $pagos=0;
            foreach($caja->pagos as $pago){
                $pagos=$pagos->monto+$pagos;
            }
            if($caja->total>$pagos and $pagos>0){
                $caja->st_caja_id=3;
            }elseif($caja->total>=$pagos){
                $caja->st_caja_id=1;
            }
            $caja->save();
            
            $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
            
            return view('cajas.caja', compact('cliente', 'caja', 'combinaciones','cajas'))
                    ->with( 'list', Caja::getListFromAllRelationApps() )
                    ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
        }
        
        //Linea de la caja con conceptos existentes
        public function guardaAdeudo(Request $request){
            $data=$request->all();
            
            //$plantel=Plantel::find(Auth::user()->id);
            
            $cliente=Cliente::find($data['cliente']);
            $caja=Caja::find($data['caja']);
            $concepto=CajaConcepto::find($data['concepto']);
            $registro['caja_id']=$caja->id;
            $registro['caja_concepto_id']=$concepto->id;
            $registro['subtotal']=$concepto->monto;
            $registro['descuento']=0;
            $registro['recargo']=0;
            $registro['total']=$registro['subtotal'];
            $registro['autorizacion_descuento']="";
            $registro['adeudo_id']=0;
            $registro['usu_alta_id']=Auth::user()->id;
            $registro['usu_mod_id']=Auth::user()->id;
            $linea=CajaLn::create($registro);
            
            $caja->subtotal=$caja->subtotal+$linea->subtotal;
            $caja->recargo=$caja->recargo+$linea->recargo;
            $caja->descuento=$caja->descuento+$linea->descuento;
            $caja->total=$caja->subtotal+$caja->recargo-$caja->descuento;
            
            $caja->save();
            
            echo json_encode($linea);
        }
        
        public function pagar(Request $request){
            $caja=Caja::find($request->get('caja'));
            $caja->st_caja_id=1;
            $caja->referencia=$request->get('referencia');
            $caja->forma_pago_id=$request->get('forma_pago_id');
            $caja->save();
            $cliente=Cliente::find($caja->cliente_id);
            $cajas=Caja::select('cajas.consecutivo as caja','ln.caja_concepto_id as concepto_id','cc.name as concepto', 'ln.total','st.name as estatus')
                    ->join('caja_lns as ln','ln.caja_id','=','cajas.id')
                    ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
                    ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                    ->where('cliente_id',$cliente->id)
                    ->get();
            
            $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
            
            foreach($caja->cajaLns as $linea){
                $adeudo=Adeudo::find($linea->adeudo_id);
                $adeudo->pagado_bnd=1;
                $adeudo->caja_id=$caja->id;
                $adeudo->save();
            }
            return view('cajas.caja', compact('cliente', 'caja','combinaciones','cajas'))
                    ->with( 'list', Caja::getListFromAllRelationApps() )
                    ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
        }
        
        public function cancelar(Request $request){
            //dd($request->get('caja'));
            $caja=Caja::find($request->get('caja'));
            $caja->st_caja_id=2;
            $caja->save();
            foreach($caja->cajaLns as $ln){
                $ln->delete();
            }
            $adeudos=Adeudo::where('caja_id',$caja->id)->get();
            foreach($adeudos as $adeudo){
                $adeudo->caja_id=0;
                $adeudo->save();
            }
            return view('cajas.caja')->with( 'list', Caja::getListFromAllRelationApps() )->with( 'list1', CajaLn::getListFromAllRelationApps() );           
        }
        
        public function imprimir(Request $request){
            $data=$request->all();
            
            $caja=Caja::find($data['caja_id']);
            
            $adeudo=Adeudo::where('caja_id', '=', $caja->id)->first();
            
            if(!is_null($adeudo)){
                $combinacion=CombinacionCliente::find($adeudo->combinacion_cliente_id);
                
                $cliente=Cliente::find($caja->cliente_id);
                $empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();

                $carbon = new \Carbon\Carbon();
                $date = $carbon->now();
                $date = $date->format('d-m-Y h:i:s');

                //dd($adeudo->toArray());
                return view('cajas.imprimirTicket', array('cliente'=>$cliente, 
                                                                   'caja'=>$caja, 
                                                                   'empleado'=>$empleado, 
                                                                   'fecha'=>$date,
                                                                   'combinacion'=>$combinacion));
            }else{
                $combinacion=0;
            $cliente=Cliente::find($caja->cliente_id);
            $empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();
            
            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y h:i:s');
            
            //dd($adeudo->toArray());
            return view('cajas.imprimirTicket', array('cliente'=>$cliente, 
                                                               'caja'=>$caja, 
                                                               'empleado'=>$empleado, 
                                                               'fecha'=>$date,
                                                               'combinacion'=>$combinacion));    
            }
            
        }
        
    public function ingresosPlantelFormaPago(){
        
        return view('cajas.reportes.ingresosPlantelFormaPago')
             ->with('list', Cliente::getListFromAllRelationApps());
    }
    
    public function ingresosPlantelFormaPagoR(Request $request){
        $data = $request->all();
        
        $resultado=Caja::select(DB::raw('sum(cajas.total) as total_cajas, p.razon ,fm.name as forma_pago'))
                       ->join('forma_pagos as fm', 'fm.id', '=', 'cajas.forma_pago_id')
                       ->join('plantels as p', 'p.id', '=', 'cajas.plantel_id')
                       ->join('pagos as pag','pag.caja_id','=','cajas.id')
                       ->where('pag.fecha','>=', $data['fecha_f'])
                       ->where('pag.fecha','<=', $data['fecha_t'])
                       ->where('p.id','>=', $data['plantel_f'])
                       ->where('p.id','<=', $data['plantel_t'])
                       ->groupBy('p.razon')
                       ->groupBy('forma_pago')
                       ->get();
        //dd($resultado->toArray());
        /*
        PDF::setOptions(['defaultFont' => 'arial']);
        $pdf = PDF::loadView('cajas.reportes.ingresosPlantelFormaPagoR', array('resultado' => $resultado))
                ->setPaper('letter', 'portrait');
        return $pdf->download('reporte.pdf');*/
        return view('cajas.reportes.ingresosPlantelFormaPagoR', array('resultado' => $resultado, 'datos'=>$data));
    }
    
    public function eliminarRecargo(Request $request){
        $data=$request->all();
        
        $caja=Caja::find($data['caja_id']);
        if($caja->st_caja_id==0){
            $caja->recargo=0;
            $caja->total=$caja->recargo+$caja->subtotal;
            $caja->save();
        }
        
        $cliente=Cliente::find($caja->cliente_id);
        $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $cajas=Caja::select('cajas.consecutivo as caja','ln.caja_concepto_id as concepto_id','cc.name as concepto', 'ln.total','st.name as estatus')
                    ->join('caja_lns as ln','ln.caja_id','=','cajas.id')
                    ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
                    ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                    ->where('cliente_id',$cliente->id)
                    ->get();
        
        return view('cajas.caja', compact('cliente', 'caja','combinaciones','cajas'))
                    ->with( 'list', Caja::getListFromAllRelationApps() )
                    ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
        
    }

    public function becaInscripcion(Request $request){
        $datos=$request->all();
        
        $caja=Caja::find($datos['caja_id']);
        $cliente=Cliente::find($caja->cliente_id);
        if($caja->becado_bnd==0 and $cliente->beca_porcentaje>0){
            $caja->descuento=$caja->descuento+$cliente->beca_porcentaje;//monto para inscripcion
            $caja->total=$caja->total - $cliente->beca_porcentaje;
            $caja->becado_bnd=1;
            $caja->save();
        }
        $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $cajas=Caja::select('cajas.consecutivo as caja','ln.caja_concepto_id as concepto_id','cc.name as concepto', 'ln.total','st.name as estatus')
                    ->join('caja_lns as ln','ln.caja_id','=','cajas.id')
                    ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
                    ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                    ->where('cliente_id',$caja->cliente_id)
                    ->get();
        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones','cajas'))
                    ->with( 'list', Caja::getListFromAllRelationApps() )
                    ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
        
    }
    
    public function becaMensualidad(Request $request){
        $datos=$request->all();
        
        $caja=Caja::find($datos['caja_id']);
        $cliente=Cliente::find($caja->cliente_id);
        if($caja->becado_bnd==0 and $cliente->monto_mensualidad>0){
            $descuento_total=0;
            foreach($caja->cajaLns as $linea){
                if($linea->cajaConcepto->bnd_aplicar_beca==1){
                    $linea->descuento=$linea->descuento+$cliente->monto_mensualidad;
                    $linea->total=$linea->total-$cliente->monto_mensualidad;
                    $linea->save();
                    $descuento_total=$descuento_total+$cliente->monto_mensualidad;
                }
                
            }
            $caja->descuento=$caja->descuento+$descuento_total;//monto para inscripcion
            $caja->total=$caja->total - $descuento_total;
            $caja->becado_bnd=1;
            $caja->save();

        }
        
        $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $cajas=Caja::select('cajas.consecutivo as caja','ln.caja_concepto_id as concepto_id','cc.name as concepto', 'ln.total','st.name as estatus')
                    ->join('caja_lns as ln','ln.caja_id','=','cajas.id')
                    ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
                    ->join('st_cajas as st','st.id','=','cajas.st_caja_id')
                    ->where('cliente_id',$caja->cliente_id)
                    ->get();
        
        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones','cajas'))
                    ->with( 'list', Caja::getListFromAllRelationApps() )
                    ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
    }
    
        public function IngresosAdedudosXPeriodoXPlantel(){
            return view('cajas.reportes.IngresosAdedudosXPeriodoXPlantel')
                ->with( 'list', Pago::getListFromAllRelationApps())
                ->with( 'list2', Caja::getListFromAllRelationApps());
        }
        
        public function IngresosAdedudosXPeriodoXPlantelR(Request $request){
            $datos=$request->all();
            $plantel=Plantel::find($datos['plantel_f']);
            
            $resultado=array();
            
            $adeudosPendientes=Adeudo::select('esp.name as especialidad','n.name as nivel','g.name as grado','c.id as cliente','c.nombre','c.nombre2',
                                              'c.ape_paterno','c.ape_materno',DB::raw('sum(adeudos.monto) as deuda'))
                                     ->join('combinacion_clientes as cc','cc.id',"=",'adeudos.combinacion_cliente_id')
                                     ->join('especialidads as esp','esp.id','=','cc.especialidad_id')
                                     ->join('nivels as n','n.id','=','cc.nivel_id')
                                     ->join('grados as g','g.id','=','cc.grado_id')
                                     ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                                     //->where('pagado_bnd', '=', 0)  
                                     ->whereDate('adeudos.fecha_pago', '>=', $datos['fecha_f'])
                                     ->whereDate('adeudos.fecha_pago', '<=', $datos['fecha_t'])
                                     ->where('c.plantel_id', '=', $datos['plantel_f'])
                                     ->groupBy('esp.name')->groupBy('n.name')->groupBy('g.name')->groupBy('c.id')
                                     ->groupBy('c.nombre')->groupBy('c.nombre2')->groupBy('c.ape_paterno')->groupBy('c.ape_materno')
                                     ->orderBy('c.id', 'asc')
                                     ->get();
            
            //dd($registros->toArray());
            
            return view('cajas.reportes.IngresosAdedudosXPeriodoXPlantelR', 
                    array('adeudos'=>$adeudosPendientes, 
                          'plantel'=>$plantel,
                          'datos'=>$datos));
        }
    
 }
