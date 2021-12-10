<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BsBaja;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateBsBaja;
use App\Http\Requests\createBsBaja;
use App\Adeudo;
use App\Cliente;
use App\Param;
use App\Plantel;
use App\Seguimiento;
use Carbon\Carbon;
use DB;
use Log;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Exception;
use Throwable;
use App\valenceSdk\samples\BasicSample\UsoApi;

class BsBajasController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$bsBajas = BsBaja::getAllData($request);

		return view('bsBajas.index', compact('bsBajas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('bsBajas.create')
			->with('list', BsBaja::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createBsBaja $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		BsBaja::create($input);

		return redirect()->route('bsBajas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, BsBaja $bsBaja)
	{
		$bsBaja = $bsBaja->find($id);
		return view('bsBajas.show', compact('bsBaja'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, BsBaja $bsBaja)
	{
		$bsBaja = $bsBaja->find($id);
		return view('bsBajas.edit', compact('bsBaja'))
			->with('list', BsBaja::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, BsBaja $bsBaja)
	{
		$bsBaja = $bsBaja->find($id);
		return view('bsBajas.duplicate', compact('bsBaja'))
			->with('list', BsBaja::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, BsBaja $bsBaja, updateBsBaja $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$bsBaja = $bsBaja->find($id);
		$bsBaja->update($input);

		return redirect()->route('bsBajas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, BsBaja $bsBaja)
	{
		$bsBaja = $bsBaja->find($id);
		$bsBaja->delete();

		return redirect()->route('bsBajas.index')->with('message', 'Registro Borrado.');
	}

	public function prospectosBajas()
	{
		$planteles = Plantel::pluck('razon', 'id');
		return view('bsBajas.prospectosBajas', compact('planteles'));
	}

	public function prospectosBajasR(Request $request)
	{
		$datos = $request->all();
		$fechaActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
		$registros = Adeudo::select(DB::raw('adeudos.cliente_id, c.matricula, combinacion_cliente_id, count(adeudos.cliente_id) as adeudos_cantidad'))
			->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
			->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
			->join('plantels as p', 'p.id', 'cc.plantel_id')
			->join('especialidads as e', 'e.id', 'cc.especialidad_id')
			->join('nivels as n', 'n.id', 'cc.nivel_id')
			->join('grados as g', 'g.id', 'cc.grado_id')
			->where('cc.plantel_id', '>', 0)
			->where('cc.especialidad_id', '>', 0)
			->where('cc.nivel_id', '>', 0)
			->where('cc.grado_id', '>', 0)
			->where('cc.turno_id', '>', 0)
			->whereColumn('adeudos.combinacion_cliente_id', 'cc.id')
			->join('caja_conceptos as caj_con', 'caj_con.id', '=', 'adeudos.caja_concepto_id')
			->where('caj_con.bnd_mensualidad', 1)
			->where('c.plantel_id', $datos['plantel_f'])
			->where('fecha_pago', '<', $fechaActual)
			->where('pagado_bnd', 0)
			->whereNull('cc.deleted_at')
			->whereNull('c.deleted_at')
			->where('c.st_cliente_id', '<>', 25)
			->where('c.st_cliente_id', '<>', 3)
			->orderBy('c.ape_paterno')
			->orderBy('c.ape_materno')
			->orderBy('c.nombre')
			->orderBy('c.nombre2')
			->groupBy('adeudos.cliente_id')
			->groupBy('c.matricula')
			->groupBy('combinacion_cliente_id')
			->having('adeudos_cantidad', '>=', $datos['cantidad_adeudos_f'])
			->get();
		$registros2 = array();
		foreach ($registros->toArray() as $registro) {
			//Log::info($registro['matricula']);
			$estatusBs = $this->consultaBs($registro['matricula']);
			//Log::info($estatusBs);
			if($estatusBs=="N/A"){
				$resultado = array_merge($registro, array('estatusBs' => "N/A"));
			//dd($estatusBs['Activation']['IsActive']);
			array_push($registros2, $resultado);
			//dd($resultado);

			}else{
				$resultado = array_merge($registro, array('estatusBs' => $estatusBs['Activation']['IsActive']));
			//dd($estatusBs['Activation']['IsActive']);
			array_push($registros2, $resultado);
			//dd($resultado);
			}
			
		}
		//dd($registros2);	
		return view('bsBajas.prospectosBajasR', compact('registros2'));
	}

	public function consultaBs($matricula)
	{
		$bs_activo = $param = Param::where('llave', 'api_brightSpace_activa')->first();
		if ($bs_activo->valor == 1) {
			$apiBs = new UsoApi();

			//Se busca la version de uso de la API
			$param = Param::where('llave', 'apiVersion_bSpace')->first();
			try {
				$resultado = $apiBs->doValence2('GET', '/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId=' . $matricula);
				//Muestra resultado
				$r = $resultado[0];
				return $r;
				//dd($r);
			} catch (Exception $e) {
				//Log::info("cliente no encontrado en Brigth Space u otro error: ".$alumno->matricula." - ".$e->getMessage());
				return "N/A";
			}
		}
	}

	public function apiAutenticar()
	{
		//dd(session()->all());
		if (isset($_GET['x_a']) && isset($_GET['x_b'])) {
			if (session()->has('userId') and session()->has('userKey')) {
				return redirect()->route('bsBajas.prospectosBajas');
			}
			session(['userId' => $_GET['x_a']]);
			session(['userKey' => $_GET['x_b']]);
			//dd(Param::all()->toArray());
			$userId = Param::where('llave', 'idUser_bSpace')->first();
			//dd($userId);
			if ($userId->valor == 0) {
				$userId->valor = $_GET['x_a'];
			}
			$userId->save();
			$userKey = Param::where('llave', 'keyUser_bSpace')->first();
			if ($userKey->valor == 0) {
				$userKey->valor = $_GET['x_b'];
			}
			$userKey->save();
			return redirect()->route('bsBajas.prospectosBajas');
		} else {
			$apiBs = new UsoApi();
			$url = $apiBs->authenticate();
		}
	}
	/*
	public function apiDesautenticar(){
		if(session()->has('userId') and session()->has('userKey')){
			$apiBs=new UsoApi();
			$url=$apiBs->deauthenticate();	
			return redirect()->route('bsBajas.prospectosBajas');
		}
	}
*/



	public function bajasBs(Request $request)
	{
		//Se reciben datos del form
		$datos = $request->all();

		//Se crea instancia de la clase que controla la API
		$bs_activo = $param = Param::where('llave', 'api_brightSpace_activa')->first();
		if ($bs_activo->valor == 1) {
			$apiBs = new UsoApi();

			//Se busca la version de uso de la API
			$param = Param::where('llave', 'apiVersion_bSpace')->first();

			//Lineas comentadas para ejecutar la url de Whoami
			//$resultado=$apiBs->doValence2('GET','/d2l/api/lp/' . $param->valor . '/users/whoami');
			//dd($resultado);

			//Se recorren los clientes para obtener datos de brigthspace
			foreach ($datos['bajasBs'] as $c) {
				try {
					$alumno = Cliente::find($c);
					$fechaActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
					$adeudos = Adeudo::select(DB::raw('adeudos.cliente_id, count(adeudos.cliente_id) as adeudos_cantidad'))
						->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
						->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
						->where('cc.plantel_id', '>', 0)
						->where('cc.especialidad_id', '>', 0)
						->where('cc.nivel_id', '>', 0)
						->where('cc.grado_id', '>', 0)
						->where('cc.turno_id', '>', 0)
						->whereColumn('adeudos.combinacion_cliente_id', 'cc.id')
						->join('caja_conceptos as caj_con', 'caj_con.id', '=', 'adeudos.caja_concepto_id')
						->where('caj_con.bnd_mensualidad', 1)
						->where('fecha_pago', '<', $fechaActual)
						->where('pagado_bnd', 0)
						->whereNotIn('c.plantel_id', array(17, 49, 74))
						->whereNull('cc.deleted_at')
						->whereNull('c.deleted_at')
						->where('c.id', $alumno->id)
						->where('c.st_cliente_id', '<>', 3)
						->groupBy('adeudos.cliente_id')
						->having('adeudos_cantidad', '>=', 2)
						->first();
					//dd($registros)	
					//dd($alumno->matricula);

					if ($alumno->matricula <> "") {
						//Se invoca el metodo doValence con los parametros del verbo y la url igual que en el ejemplo del SDK
						//$resultado=$apiBs->doValence('GET','/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId='.$alumno->matricula);
						$resultado = $apiBs->doValence2('GET', '/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId=' . $alumno->matricula);

						//Muestra resultado
						$r = $resultado[0];
						//dd($r['UserId']);

						$datos = ['isActive' => False];
						//dd($datos);
						if (isset($r['UserId'])) {
							$resultado2 = $apiBs->doValence2('PUT', '/d2l/api/lp/' . $param->valor . '/users/' . $r['UserId'] . '/activation', $datos);
							//dd($resultado2);
							if (isset($resultado2['IsActive']) and !$resultado2['IsActive']) {
								$input['cliente_id'] = $alumno->id;
								$input['fecha_baja'] = Date('Y-m-d');
								$input['bnd_baja'] = 1;
								$input['usu_alta_id'] = Auth::user()->id;
								$input['usu_mod_id'] = Auth::user()->id;
								BsBaja::create($input);
								if ($adeudos->adeudos_cantidad == 2) {
									//echo $registro->cliente_id . '-';
									//$cliente = Cliente::find($registro->cliente_id);
									//Log::info("cliente-" . $cliente->id . "-st" . $cliente->st_cliente_id);
									$alumno->st_cliente_id = 25;
									$alumno->save();

									$seguimiento = Seguimiento::where('cliente_id', $alumno->id)->first();
									//Log::info("seguimiento-" . $seguimiento->id . "-st" . $seguimiento->st_seguimiento_id);
									$seguimiento->st_seguimiento_id = 2;
									$seguimiento->save();
								} elseif ($alumno->adeudos_cantidad >= 3) {
									//$cliente = Cliente::find($registro->cliente_id);
									$alumno->st_cliente_id = 26;
									$alumno->save();

									$adeudos = Adeudo::where('cliente_id', $alumno->cliente_id)
										->where('caja_id', 0)
										->where('pagado_bnd', 0)
										->whereDate('adeudos.fecha_pago', '>', Date('Y-m-d'))
										->get();
									//dd($adeudos->toArray());
									foreach ($adeudos as $adeudo) {
										$adeudo->delete();
									}

									$seguimiento = Seguimiento::where('cliente_id', $alumno->id)->first();
									$seguimiento->st_seguimiento_id = 6;
									$seguimiento->save();
								}
							} else {
								$input['cliente_id'] = $alumno->id;
								$input['fecha_baja'] = Date('Y-m-d');
								$input['bnd_baja'] = 0;
								$input['usu_alta_id'] = Auth::user()->id;
								$input['usu_mod_id'] = Auth::user()->id;
								BsBaja::create($input);
							}
						}
						//dd($resultado2['IsActive']);
					}
				} catch (Exception $e) {
					Log::info("cliente no encontrado en Brigth Space u otro error: " . $alumno->matricula . " - " . $e->getMessage());
					//return false;
				}
			}
		}
		return redirect()->route('bsBajas.prospectosBajas');
	}

	public function bajasCreadas()
	{
		$planteles = Plantel::pluck('razon', 'id');
		return view('bsBajas.bajasCreadas', compact('planteles'));
	}

	public function bajasCreadasR(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		$registros = BsBaja::select(
			'p.razon',
			'c.id',
			'c.matricula',
			'stc.name as estatus',
			'bs_bajas.fecha_baja',
			'bs_bajas.fecha_baja',
			'bs_bajas.bnd_baja',
			'bs_bajas.fecha_reactivar',
			'bs_bajas.bnd_reactivar'
		)
			->join('clientes as c', 'c.id', '=', 'bs_bajas.cliente_id')
			->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
			->join('plantels as p', 'p.id', '=', 'c.plantel_id')
			->where('c.plantel_id', $datos['plantel_f'])
			->whereDate('bs_bajas.fecha_baja', '>=', $datos['fecha_f'])
			->whereDate('bs_bajas.fecha_baja', '<=', $datos['fecha_t'])
			->get();
		//dd($registros);
		return view('bsBajas.bajasCreadasR', compact('registros'));
	}
}
