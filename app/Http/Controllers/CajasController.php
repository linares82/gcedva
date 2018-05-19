<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Caja;
use App\CajaLn;
use App\Adeudo;
use App\Cliente;
use App\Plantel;
use App\Empleado;
use App\CombinacionCliente;
use App\CajaConcepto;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCaja;
use App\Http\Requests\createCaja;

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
                
                $empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();
                $plantel=Plantel::find($empleado->plantel_id);
                $cliente=Cliente::find($input['cliente_id']);
                
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
		
		return view('cajas.caja', compact('cliente', 'caja','combinaciones'))
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
		return view('cajas.caja', compact('caja', 'cliente'))
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
            $cliente=Cliente::find($request->cliente_id);
            //$adeudos=Adeudo::where('cliente_id', '=', $cliente->id)->get();
            //dd($cliente);
            $combinaciones=CombinacionCliente::where('cliente_id', '=', $cliente->id)->get();
            /*foreach($combinaciones as $c){
                dd($c->adeudos);
            }*/
            //dd($combinaciones);
            if(is_object($cliente) and count($combinaciones)>0){
                return view('cajas.caja', compact('cliente', 'combinaciones'))
                        ->with( 'list', Caja::getListFromAllRelationApps() )
                        ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
            }
            return view('cajas.caja')->with('message','Sin coincidencias');           
        }
        
        public function buscarVenta(Request $request){
            $data=$request->all();
            $empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();
            $caja=Caja::where('consecutivo', '=', $data['consecutivo'])->where('plantel_id', '=', $empleado->plantel_id)->first();
            //dd($caja);
            $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
            if(is_object($caja)){
                $cliente=Cliente::find($caja->cliente_id);
                return view('cajas.caja', compact('cliente', 'caja', 'combinaciones'))
                        ->with( 'list', Caja::getListFromAllRelationApps() )
                        ->with( 'list1', CajaLn::getListFromAllRelationApps() );           
            }
            return view('cajas.caja')->with('message','Sin coincidencias');           
        }
        
        
        
        //Lineas de la caja con adeudos predefinidos
        public function guardaAdeudoPredefinido(Request $request){
            //dd($request->get('adeudo'));
            $data=$request->all();
            //dd($data['inicial_bnd']);
            if($data['inicial_bnd']==1){
                //dd('1');
                $adeudos=Adeudo::where('cliente_id', '=', $data['cliente_id'])
                              ->where('fecha_pago', '=', $data['fecha_pago'])
                              ->where('inicial_bnd', '=', 1)
                              ->where('combinacion_cliente_id', '=', $data['combinacion'])
                              ->get();
            }else{
                //dd('2');
                $adeudos=Adeudo::where('id', '=', $data['adeudo'])->get();
            }
            $caja=Caja::find($data['caja']);
            $cliente=Cliente::find($data['cliente_id']);
            //dd($adeudos->toArray());
            $subtotal=0;
            $recargo=0;
            $descuento=0;
            //dd($adeudos->toArray());
            foreach($adeudos as $adeudo){
                $existe_linea=CajaLn::where('adeudo_id','=',$adeudo->id)->first();
                if(!is_object($existe_linea)){
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
                        
                        if($dia>$regla->dia_inicio and $dia<$regla->dia_fin){
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
                    $caja_ln['adeudo_id']=$adeudo->id;
                    $caja_ln['usu_alta_id']=Auth::user()->id;
                    $caja_ln['usu_mod_id']=Auth::user()->id;
                    if($cliente->beca_bnd==1 and $caja_ln['caja_concepto_id']==1){
                        $caja_ln['descuento']=$caja_ln['descuento']+($caja_ln['subtotal']*$cliente->beca_porcentaje);
                        $caja_ln['total']=$caja_ln['total']-($caja_ln['subtotal']-$caja_ln['descuento']);
                    }
                    //dd($caja_ln);
                    $caja_linea=CajaLn::create($caja_ln);
                    $subtotal=$subtotal+$caja_ln['subtotal'];
                    $recargo=$recargo+$caja_ln['recargo'];
                    $descuento=$descuento+$caja_ln['descuento'];
                }
                
            }
            if($subtotal>0){
                $caja->subtotal=$caja->subtotal+$subtotal;
                $caja->recargo=$caja->recargo+$recargo;
                $caja->descuento=$caja->descuento+$descuento;
                $caja->total=$caja->subtotal+$caja->recargo-$caja->descuento;
                $caja->save();
            }
            
            $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
            
            return view('cajas.caja', compact('cliente', 'caja', 'combinaciones'))
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
            $caja->forma_pago_id=$request->get('forma_pago_id');
            $caja->save();
            $cliente=Cliente::find($caja->cliente_id);
            $combinaciones=CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
            
            foreach($caja->cajaLns as $linea){
                $adeudo=Adeudo::find($linea->adeudo_id);
                $adeudo->pagado_bnd=1;
                $adeudo->caja_id=$caja->id;
                $adeudo->save();
            }
            return view('cajas.caja', compact('cliente', 'caja','combinaciones'))
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
}
