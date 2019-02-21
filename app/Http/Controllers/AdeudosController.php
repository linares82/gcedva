<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Adeudo;
use App\Cliente;
use App\Empleado;
use App\Plantel;
use App\CombinacionCliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateAdeudo;
use App\Http\Requests\createAdeudo;
use PDF;
use Illuminate\Support\Facades\Cache;
use DB;

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

		return redirect()->route('adeudos.index')->with('message', 'Registro Borrado.');
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
                                              'c.ape_paterno','c.ape_materno',DB::raw('sum(adeudos.monto) as monto'))
                                     ->join('combinacion_clientes as cc','cc.id',"=",'adeudos.combinacion_cliente_id')
                                     ->join('especialidads as esp','esp.id','=','cc.especialidad_id')
                                     ->join('nivels as n','n.id','=','cc.nivel_id')
                                     ->join('grados as g','g.id','=','cc.grado_id')
                                     ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                                     ->where('pagado_bnd', '=', 0)  
                                     ->whereDate('fecha_pago', '<', $fecha)
                                     ->where('c.plantel_id', '=', $datos['plantel_f'])
                                     ->groupBy('esp.name')->groupBy('n.name')->groupBy('g.name')->groupBy('c.id')
                                     ->groupBy('c.nombre')->groupBy('c.nombre2')->groupBy('c.ape_paterno')->groupBy('c.ape_materno')
                                     ->orderBy('c.id', 'asc')
                                     ->orderBy('adeudos.combinacion_cliente_id', 'asc')
                                     ->get();
                                     //->paginate(100);
            
            //dd($adeudosPendientes);
            return view('adeudos.reportes.adeudos_pendientes', array('adeudos'=>$adeudosPendientes, 'plantel'=>$plantel));
            
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
}
