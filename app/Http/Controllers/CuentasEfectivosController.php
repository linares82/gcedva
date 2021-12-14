<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Pago;
use App\Egreso;
use App\Plantel;
use App\Transference;
use App\Http\Requests;
use App\IngresoEgreso;
use App\CuentasEfectivo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createCuentasEfectivo;
use App\Http\Requests\updateCuentasEfectivo;

class CuentasEfectivosController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cuentasEfectivos = CuentasEfectivo::getAllData($request);
		$cuentas=CuentasEfectivo::where('id','>',0)->get();
		foreach($cuentas as $cuenta){
			$this->calculaSaldoCuenta($cuenta);
		}
		
		return view('cuentasEfectivos.index', compact('cuentasEfectivos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$plantels = Plantel::pluck('razon', 'id');
		$plantels_selected = array();
		return view('cuentasEfectivos.create', compact('plantels', 'plantels_selected'))
			->with('list', CuentasEfectivo::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCuentasEfectivo $request)
	{

		$input = $request->except('plantel_id');
		$plantels = $request->only('plantel_id');

		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		if (!isset($input['bnd_banco'])) {
			$input['bnd_banco'] = 0;
		}

		//create data
		$cuentasEfectivo = CuentasEfectivo::create($input);

		$cuentasEfectivo->plantels()->sync($plantels['plantel_id']);

		return redirect()->route('cuentasEfectivos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CuentasEfectivo $cuentasEfectivo)
	{
		$cuentasEfectivo = $cuentasEfectivo->find($id);

		return view('cuentasEfectivos.show', compact('cuentasEfectivo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CuentasEfectivo $cuentasEfectivo)
	{
		$cuentasEfectivo = $cuentasEfectivo->find($id);
		//dd($cuentasEfectivo->plantels->toArray());
		$plantels = Plantel::pluck('razon', 'id');
		//dd($plantels);
		$selected = $cuentasEfectivo->plantels;
		$plantels_selected = collect();
		foreach ($selected as $ps) {
			$plantels_selected->prepend($ps->id);
		}
		//  dd(optional($plantels_selected)->search(4));
		return view('cuentasEfectivos.edit', compact('cuentasEfectivo', 'plantels', 'plantels_selected'))
			->with('list', CuentasEfectivo::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CuentasEfectivo $cuentasEfectivo)
	{
		$cuentasEfectivo = $cuentasEfectivo->find($id);
		return view('cuentasEfectivos.duplicate', compact('cuentasEfectivo'))
			->with('list', CuentasEfectivo::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CuentasEfectivo $cuentasEfectivo, updateCuentasEfectivo $request)
	{
		$input = $request->except('plantel_id');
		$input['usu_mod_id'] = Auth::user()->id;
		$plantels = $request->only('plantel_id');
		if (!isset($input['bnd_banco'])) {
			$input['bnd_banco'] = 0;
		}

		//update data
		$cuentasEfectivo = $cuentasEfectivo->find($id);
		$cuentasEfectivo->update($input);
		//dd($plantels['plantel_id']);
		$cuentasEfectivo->plantels()->sync($plantels['plantel_id']);

		return redirect()->route('cuentasEfectivos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, CuentasEfectivo $cuentasEfectivo)
	{
		$cuentasEfectivo = $cuentasEfectivo->find($id);
		$cuentasEfectivo->delete();

		return redirect()->route('cuentasEfectivos.index')->with('message', 'Registro Borrado.');
	}

	public function getCuentasPlantelFormaPago(Request $request)
	{
		if ($request->ajax()) {
			$data = $request->all();
			$plantel = $data['plantel'];
			$forma_pago = $data['forma_pago'];

			$final = array();
			if ($forma_pago == 1) {
				$r = DB::table('cuentas_efectivos as ce')
					->select('ce.id', 'ce.name')
					->join('cuentas_efectivo_plantels as cep', 'cep.cuentas_efectivo_id', '=', 'ce.id')
					->where('cep.plantel_id', '=', $plantel)
					->where('ce.bnd_banco', 0)
					->where('ce.id', '>', '0')
					->get();

				return $r;
			} else {
				$r = DB::table('cuentas_efectivos as ce')
					->select('ce.id', 'ce.name')
					->join('cuentas_efectivo_plantels as cep', 'cep.cuentas_efectivo_id', '=', 'ce.id')
					->where('cep.plantel_id', '=', $plantel)
					->where('ce.bnd_banco', 1)
					->where('ce.id', '>', '0')
					->get();

				return $r;
			}
		}
	}

	public function getCuentasPlantel(Request $request)
	{
		if ($request->ajax()) {
			$data = $request->all();
			$plantel = $data['plantel'];
			//$forma_pago=$data['forma_pago'];

			$final = array();
			$r = DB::table('cuentas_efectivos as ce')
				->select('ce.id', 'ce.name')
				->join('cuentas_efectivo_plantels as cep', 'cep.cuentas_efectivo_id', '=', 'ce.id')
				->where('cep.plantel_id', '=', $plantel)
				//->where('ce.bnd_banco', 0)
				->where('ce.id', '>', '0')
				->get();

			return $r;
			//                if($forma_pago==1){
			//                    $r = DB::table('cuentas_efectivos as ce')
			//                                ->select('ce.id', 'ce.name')
			//                                ->join('cuentas_efectivo_plantels as cep','cep.cuentas_efectivo_id','=','ce.id')
			//                                ->where('cep.plantel_id', '=', $plantel)
			//                                ->where('ce.bnd_banco', 0)
			//                                ->where('ce.id', '>', '0')
			//                                ->get();
			//                
			//                    return $r;
			//                }else{
			//                    $r = DB::table('cuentas_efectivos as ce')
			//                                ->select('ce.id', 'ce.name')
			//                                ->join('cuentas_efectivo_plantels as cep','cep.cuentas_efectivo_id','=','ce.id')
			//                                ->where('cep.plantel_id', '=', $plantel)
			//                                ->where('ce.bnd_banco', 1)
			//                                ->where('ce.id', '>', '0')
			//                                ->get();
			//                
			//                    return $r;
			//                }


		}
	}

	public function getSaldo(Request $request)
	{
		if ($request->ajax()) {
			$data = $request->all();
			//dd($data);
			$cuenta = CuentasEfectivo::find($data['cuenta']);
			$resultado=$this->calculaSaldoCuenta($cuenta);
			
			return $resultado[4]['resultado'];
		}
	}

	public function comprobarSaldo(Request $request)
	{
		if ($request->ajax()) {
			$data = $request->all();
			//dd($data);
			$cuenta = CuentasEfectivo::find($data['cuenta']);
			$resultado=$this->calculaSaldoCuenta($cuenta);
			//dd($resultado);
			return number_format($resultado[0]['ingresos'],2)."+".
				number_format($resultado[1]['tingresos'],2)." - ".
				number_format($resultado[2]['egresos'],2)." - ".
				number_format($resultado[3]['tegresos'],2)." = ".
				number_format($resultado[4]['resultado'],2);
		}
	}

	public function calculaSaldoCuenta(CuentasEfectivo $cuenta){

		$ingresos= Pago::join('cajas as c','c.id','pagos.caja_id')
			->join('plantels as plan','plan.id','c.plantel_id')
			->join('cuentas_efectivo_plantels as cep','cep.plantel_id','plan.id')
			->join('cuentas_efectivos as ce','ce.id','cep.cuentas_efectivo_id')
			->where('cep.cuentas_efectivo_id',$cuenta->id)
			->whereDate('pagos.fecha','>', $cuenta->fecha_saldo_inicial)
			->whereNull('pagos.deleted_at')
			->where('c.st_caja_id',1)
			->whereNull('c.deleted_at')	
			->sum('pagos.monto');
			//->get();
			//dd($ingresos->toArray());

			//dd($ingreso);
			/*$tingreso = IngresoEgreso::where('cuenta_Efectivo_id', $cuenta->id)
				->where('transference_id', '>', 0)
				->where('concepto', 'Transferencia:ingreso')
				->whereDate('fecha', '>=', $cuenta->fecha_saldo_inicial)
				->sum('monto');*/
			$tingreso=Transference::where('destino_id', $cuenta->id)
			->whereDate('fecha', '>=', $cuenta->fecha_saldo_inicial)
			->sum('monto');
			//dd($tingreso);

			/*$egreso = IngresoEgreso::where('cuenta_Efectivo_id', $cuenta->id)
				->where('egreso_id', '>', 0)
				->whereDate('fecha', '>=', $cuenta->fecha_saldo_inicial)
				->sum('monto');*/
			$egresos=Egreso::join('cuentas_efectivos as ce','ce.id','egresos.cuentas_efectivo_id')
			->where('cuentas_efectivo_id',$cuenta->id)
			->whereNull('egresos.deleted_at')
			->whereDate('egresos.fecha','>', $cuenta->fecha_saldo_inicial)
			->sum('egresos.monto');

			//dd($egreso);
			/*$tegreso = IngresoEgreso::where('cuenta_Efectivo_id', $cuenta->id)
				->where('transference_id', '>', 0)
				->where('concepto', 'Transferencia:egreso')
				->whereDate('fecha', '>=', $cuenta->fecha_saldo_inicial)
				->sum('monto');*/
			$tegreso=Transference::where('origen_id', $cuenta->id)
				->whereDate('fecha', '>=', $cuenta->fecha_saldo_inicial)
				->sum('monto');

			$resultado=$ingresos + $tingreso - $egresos - $tegreso;
			$cuenta->saldo_actualizado=$resultado;
			$cuenta->save();
			
			$calculos=array();
			array_push($calculos, array('ingresos'=>$ingresos));
			array_push($calculos, array('tingresos'=>$tingreso));
			array_push($calculos, array('egresos'=>$egresos));
			array_push($calculos, array('tegresos'=>$tegreso));
			array_push($calculos, array('resultado'=>$resultado));
			//dd($calculos);
			return $calculos;
	}
}
