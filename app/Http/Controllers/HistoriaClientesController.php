<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use App\Mese;
use App\Param;
use Exception;

use App\Adeudo;
use App\BsBaja;
use App\Cliente;
use App\Plantel;
use App\Empleado;
use App\StCliente;
use Carbon\Carbon;
use File as Archi;
use App\Inscripcion;
use App\Seguimiento;
use App\EventoCliente;
use App\Http\Requests;
use App\HistoriaCliente;
use App\StHistoriaCliente;
use Illuminate\Http\Request;
use App\RegistroHistoriaCliente;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\createHistoriaCliente;
use App\Http\Requests\updateHistoriaCliente;
use App\valenceSdk\samples\BasicSample\UsoApi;

class HistoriaClientesController extends Controller
{

	protected $historiaCliente;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index(Request $request)
	{
		$historiaClientes = HistoriaCliente::getAllData($request);
		$stHistoriaClientes = StHistoriaCliente::where('id', '>', 1)->pluck('name', 'id');

		return view('historiaClientes.index', compact('historiaClientes', 'stHistoriaClientes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$data = $request->all();
		$cliente = $data['cliente'];

		$cliente_actual = Cliente::find($data['cliente']);
		$bajas_existentes = HistoriaCliente::where('cliente_id', $data['cliente'])
			->where('evento_cliente_id', 2)
			->where('st_historia_cliente_id', '<>', 2)
			->whereNull('deleted_at')
			->get();
		//dd($bajas_existentes);
		$hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->day;
		$dias_habiles_aux = Param::where('llave', 'dias_para_bajas')->value('valor');
		$dias_habiles = explode(',', $dias_habiles_aux);
		if (in_array($hoy, $dias_habiles) and $cliente_actual->st_cliente_id <> 3) {
			$eventos = EventoCliente::pluck('name', 'id');
		} else {
			$eventos = EventoCliente::where('id', '<>', 2)->pluck('name', 'id');
		}

		$inscripcions = Inscripcion::select(DB::raw('inscripcions.id, concat(p.razon," / ",e.name," / ",n.name," / ",g.name," / ",gru.name," / ",l.name," / ",pe.name) as inscripcion'))
			->join('plantels as p', 'p.id', '=', 'inscripcions.plantel_id')
			->join('especialidads as e', 'e.id', '=', 'inscripcions.especialidad_id')
			->join('nivels as n', 'n.id', '=', 'inscripcions.nivel_id')
			->join('grados as g', 'g.id', '=', 'inscripcions.grado_id')
			->join('grupos as gru', 'gru.id', '=', 'inscripcions.grupo_id')
			->join('lectivos as l', 'l.id', '=', 'inscripcions.lectivo_id')
			->join('periodo_estudios as pe', 'pe.id', '=', 'inscripcions.periodo_estudio_id')
			->where('cliente_id', $data['cliente'])
			->where('st_inscripcion_id', '<>', 3)
			->whereNull('inscripcions.deleted_at')
			->pluck('inscripcion', 'id');
		//dd($inscripcions);
		return view('historiaClientes.create', compact('cliente', 'inscripcions', 'bajas_existentes', 'eventos'))
			->with('list', HistoriaCliente::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHistoriaCliente $request)
	{

		$input = $request->all();

		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		if (!isset($input['st_historia_cliente_id'])) {
			$input['st_historia_cliente_id'] = 1;
		}
		//dd($input);

		$primer_adeudo = Adeudo::where('cliente_id', $input['cliente_id'])->first();
		$mes_primer_adeudo = Carbon::createFromFormat('Y-m-d', $primer_adeudo->fecha_pago)->month;
		$mes_actual = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->month;
		if ($mes_primer_adeudo == $mes_actual) {
			$input['bnd_prematuro'] = 1;
		}

		$r = $request->hasFile('archivo_file');
		//dd($r);
		if ($r) {
			$archivo_file = $request->file('archivo_file');
			$input['archivo'] = $archivo_file->getClientOriginalName();
		}

		//create data
		$e = HistoriaCliente::create($input);

		$registroHistoriaCliente['historia_cliente_id'] = $e->id;
		$registroHistoriaCliente['st_historia_cliente_id'] = $e->st_historia_cliente_id;
		$registroHistoriaCliente['comentario'] = $e->descripcion;
		$registroHistoriaCliente['usu_alta_id'] = Auth::user()->id;
		$registroHistoriaCliente['usu_mod_id'] = Auth::user()->id;
		//dd($registroHistoriaCliente);
		RegistroHistoriaCliente::create($registroHistoriaCliente);

		if ($e->evento_cliente_id == 6) {
			$cliente = Cliente::find($e->cliente_id);
			$cliente->st_cliente_id = 4;
			$cliente->save();

			$seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
			$seguimiento->st_seguimiento_id = 2;
			$seguimiento->save();
		}

		/*              
                if($e->evento_cliente_id==4){
                    $cliente=Cliente::find($e->cliente_id);
                    $cliente->st_cliente_id=24;
                    $cliente->save();
                }elseif($e->evento_cliente_id==2){
					$inscripcion=Inscripcion::find($e->inscripcion_id);
					$inscripcion->st_inscripcion_id=3;
					$inscripcion->save();

					$adeudos=Adeudo::where('combinacion_cliente_id', $inscripcion->combinacion_cliente_id)
											  ->where('caja_id',0)
											  ->where('pagado_bnd',0)
											  ->get();
					foreach($adeudos as $adeudo){
						$adeudo->delete();
					}

					$inscripcions=Inscripcion::where('cliente_id',$e->cliente_id)->where('st_inscripcion_id','<>',3)->whereNull('deleted_at')->count();
				
					if($inscripcions==0){
						$cliente = Cliente::find($e->cliente_id);
						$cliente->st_cliente_id = 3;
						$cliente->save();

						$seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
						$seguimiento->st_seguimiento_id = 6;
						$seguimiento->save();
					}

                    
                     //dd("echo");     
                }elseif($e->evento_cliente_id==6){
                    $cliente=Cliente::find($e->cliente_id);
                    $cliente->st_cliente_id=4;
                    $cliente->save();
                    
                    $seguimiento=Seguimiento::where('cliente_id',$cliente->id)->first();
                    $seguimiento->st_seguimiento_id=2;
                    $seguimiento->save();
                }
*/
		if ($e) {
			$ruta = public_path() . "/imagenes/historia_clientes/" . $e->id . "/";
			if (!file_exists($ruta)) {
				Archi::makedirectory($ruta, 0777, true, true);
			}

			if ($request->file('archivo_file')) {
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('archivo_file')->move($ruta, $input['archivo']);
			}
		}

		if ($input['st_historia_cliente_id'] == 2) {
			$cliente = Cliente::select('id', 'st_cliente_id')->find($input['cliente_id']);
			$cliente->st_cliente_id = 3;
			$cliente->save();
			//dd($cliente);
			return redirect()->route('home');
		}

		return redirect()->route('clientes.indexEventos')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, HistoriaCliente $historiaCliente)
	{
		$historiaCliente = $historiaCliente->find($id);
		return view('historiaClientes.show', compact('historiaCliente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, HistoriaCliente $historiaCliente)
	{
		$historiaCliente = $historiaCliente->find($id);
		$cliente = $historiaCliente->cliente_id;
		$hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->day;
		$dias_habiles_aux = Param::where('llave', 'dias_para_bajas')->value('valor');
		$dias_habiles = explode(',', $dias_habiles_aux);
		if (in_array($hoy, $dias_habiles) and $cliente->st_cliente_id <> 3) {
			$eventos = EventoCliente::pluck('name', 'id');
		} else {
			$eventos = EventoCliente::where('id', '<>', 2)->pluck('name', 'id');
		}
		$inscripcions = Inscripcion::select(DB::raw('inscripcions.id, concat(p.razon," / ",e.name," / ",n.name," / ",g.name," / ",gru.name," / ",l.name," / ",pe.name) as inscripcion'))
			->join('plantels as p', 'p.id', '=', 'inscripcions.plantel_id')
			->join('especialidads as e', 'e.id', '=', 'inscripcions.especialidad_id')
			->join('nivels as n', 'n.id', '=', 'inscripcions.nivel_id')
			->join('grados as g', 'g.id', '=', 'inscripcions.grado_id')
			->join('grupos as gru', 'gru.id', '=', 'inscripcions.grupo_id')
			->join('lectivos as l', 'l.id', '=', 'inscripcions.lectivo_id')
			->join('periodo_estudios as pe', 'pe.id', '=', 'inscripcions.periodo_estudio_id')
			->where('cliente_id', $historiaCliente->cliente_id)
			->whereNull('inscripcions.deleted_at')
			->pluck('inscripcion', 'id');

		return view('historiaClientes.edit', compact('historiaCliente', 'cliente', 'inscripcions', 'eventos'))
			->with('list', HistoriaCliente::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, HistoriaCliente $historiaCliente)
	{
		$historiaCliente = $historiaCliente->find($id);
		return view('historiaClientes.duplicate', compact('historiaCliente'))
			->with('list', HistoriaCliente::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, HistoriaCliente $historiaCliente, updateHistoriaCliente $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;

		$r = $request->hasFile('archivo_file');
		//dd($input);
		if ($r) {
			$archivo_file = $request->file('archivo_file');
			$input['archivo'] = $archivo_file->getClientOriginalName();
		}

		//update data
		$historiaCliente = $historiaCliente->find($id);
		$historiaCliente->update($input);

		$e = $historiaCliente;
		/*
		if ($e->evento_cliente_id == 4) {
			$cliente = Cliente::find($e->cliente_id);
			$cliente->st_cliente_id = 24;
			$cliente->save();
		} elseif ($e->evento_cliente_id == 2) {
			$inscripcion = Inscripcion::find($e->inscripcion_id);
			$inscripcion->st_inscripcion_id = 3;
			$inscripcion->save();

			$adeudos = Adeudo::where('combinacion_cliente_id', $inscripcion->combinacion_cliente_id)
				->where('caja_id', 0)
				->where('pagado_bnd', 0)
				->get();
			foreach ($adeudos as $adeudo) {
				$adeudo->delete();
			}

			$inscripcions = Inscripcion::where('cliente_id', $e->cliente_id)->where('st_inscripcion_id', '<>', 3)->whereNull('deleted_at')->count();
			//dd($inscripcions);
			if ($inscripcions == 0) {
				$cliente = Cliente::find($e->cliente_id);
				$cliente->st_cliente_id = 3;
				$cliente->save();

				$seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
				$seguimiento->st_seguimiento_id = 6;
				$seguimiento->save();
			}


			//dd("echo");     
		} elseif ($e->evento_cliente_id == 6) {
			$cliente = Cliente::find($e->cliente_id);
			$cliente->st_cliente_id = 4;
			$cliente->save();

			$seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
			$seguimiento->st_seguimiento_id = 2;
			$seguimiento->save();
		}
  */
		if ($e) {
			$ruta = public_path() . "/imagenes/historia_clientes/" . $e->id . "/";

			if (!file_exists($ruta)) {
				Archi::makedirectory($ruta, 0777, true, true);
			}

			if ($request->file('archivo_file')) {
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('archivo_file')->move($ruta, $input['archivo']);
			}
		}

		return redirect()->route('historiaClientes.index', array('q[cliente_id_lt]' => $historiaCliente->cliente_id))->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, HistoriaCliente $historiaCliente)
	{
		$historiaCliente = $historiaCliente->find($id);
		$cliente = $historiaCliente->cliente_id;
		$historiaCliente->delete();

		return redirect()->route('historiaClientes.index', array('q[cliente_id_lt]' => $cliente))->with('message', 'Registro Borrado.');
	}

	public function reactivar(Request $request)
	{
		$input = $request->all();
		$historiaCliente = HistoriaCliente::find($input['id']);
		$historiaCliente->descripcion = $historiaCliente->descripcion . " - Reactivado";
		$historiaCliente->reactivado = $historiaCliente->reactivado + 1;
		$historiaCliente->fec_reactivado = Date('Y-m-d');
		$historiaCliente->save();

		$cliente = Cliente::find($historiaCliente->cliente_id);
		$cliente->st_cliente_id = 4;
		$cliente->save();

		$seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
		$seguimiento->st_seguimiento_id = 2;
		$seguimiento->save();

		$inscripcion = Inscripcion::find($historiaCliente->inscripcion_id);
		if (!is_null($inscripcion)) {
			$inscripcion->st_inscripcion_id = 1;
			$inscripcion->save();
		}

		$param = Param::where('llave', 'apiVersion_bSpace')->first();
		$bs_activo = Param::where('llave', 'api_brightSpace_activa')->first();
		if ($bs_activo->valor == 1) {
			try {
				$apiBs = new UsoApi();

				//dd($datos);
				$resultado = $apiBs->doValence2('GET', '/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId=' . $cliente->matricula);
				//Muestra resultado
				$r = $resultado[0];
				$datos = ['isActive' => True];
				if (isset($r['UserId'])) {
					$resultado2 = $apiBs->doValence2('PUT', '/d2l/api/lp/' . $param->valor . '/users/' . $r['UserId'] . '/activation', $datos);
					$bsBaja = BsBaja::where('cliente_id', $cliente->id)
						->where('bnd_baja', 1)
						->where('bnd_reactivar', '<>', 1)
						->first();
					if (!is_null($bsBaja)) {
						if (isset($resultado2['IsActive']) and $resultado2['IsActive'] and !is_null($bsBaja)) {
							$input['cliente_id'] = $cliente->id;
							$input['fecha_reactivar'] = Date('Y-m-d');
							$input['bnd_reactivar'] = 1;
							$input['usu_mod_id'] = Auth::user()->id;
							$bsBaja->update($input);
						} else {
							$input['cliente_id'] = $cliente->id;
							$input['fecha_reactivar'] = Date('Y-m-d');
							$input['bnd_reactivar'] = 0;
							$input['usu_mod_id'] = Auth::user()->id;
							$bsBaja->update($input);
						}
					}
				}
			} catch (Exception $e) {
				Log::info("cliente no encontrado en Brigth Space u otro error: " . $cliente->matricula . " - " . $e->getMessage());
				//return false;
			}
		}


		return redirect()->route('historiaClientes.index', array('q[cliente_id_lt]' => $cliente->id))->with('message', 'Registro Borrado.');
	}

	public function widgetSeguimiento()
	{
		$registros = HistoriaCliente::where('evento_cliente_id', 2);
		if (Auth::user()->can('aut_ser_esc')) {
			$registros->aut_user_esc <> 2;
		}
		if (Auth::user()->can('aut_caja')) {
			$registros->aut_caja <> 2;
		}
		if (Auth::user()->can('aut_ser_esc_corp')) {
			$registros->aut_user_esc_corp <> 2;
		}
		$registros->get();
		return $registros;
	}

	public function wdBajas(Request $request)
	{
		$datos = $request->all();
		$inscripciones_clientes_activos = Inscripcion::select(
			'c.id as cliente',
			'e.name as especialidad',
			'n.name as nivel',
			'g.name as grado'
		)
			->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
			->join('especialidads as e', 'e.id', '=', 'inscripcions.especialidad_id')
			->join('nivels as n', 'n.id', '=', 'inscripcions.nivel_id')
			->join('grados as g', 'g.id', '=', 'inscripcions.grado_id')
			->where('c.st_cliente_id', 4)
			->where('inscripcions.plantel_id', $datos['plantel'])
			->get();
		//dd($inscripciones_clientes_activos->toArray());
		$hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
		$fec_aux = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));

		$hoy->subMonth();
		//dd($hoy->year);

		$bajas = HistoriaCliente::select(
			'c.id as cliente',
			'c.st_cliente_id',
			'e.name as especialidad',
			'n.name as nivel',
			'g.name as grado'
		)
			->join('clientes as c', 'c.id', '=', 'historia_clientes.cliente_id')
			->join('inscripcions as i', 'i.cliente_id', '=', 'c.id')
			->join('especialidads as e', 'e.id', '=', 'i.especialidad_id')
			->join('nivels as n', 'n.id', '=', 'i.nivel_id')
			->join('grados as g', 'g.id', '=', 'i.grado_id')
			->where('historia_clientes.evento_cliente_id', 2)
			->where('c.st_cliente_id', 3)
			->whereMonth('historia_clientes.fecha', $hoy->month)
			->whereYear('historia_clientes.fecha', $hoy->year)
			->where('i.plantel_id', $datos['plantel'])
			->whereNull('i.deleted_at')
			->get();
		//dd(count($inscripciones_clientes_activos) . "-" . count($bajas->toArray()));
		$total = count($bajas) + count($inscripciones_clientes_activos);
		//dd($total);
		$porcentaje_bajas = 0;
		if ($total <> 0) {
			$porcentaje_bajas = round(((count($bajas) * 100) / $total), 2);
		}


		//dd($porcentaje_bajas);
		return response()->json(['porcentaje_bajas' => $porcentaje_bajas]);
	}

	public function wdBajasDetalle(Request $request)
	{
		$datos = $request->all();
		$inscripciones_clientes_activos = Inscripcion::select(
			//	'c.id as cliente',
			//'c.st_cliente_id',
			'e.id as id',
			'e.name as especialidad',
			DB::raw('count(e.name) as total_especialidad')
			//'n.name as nivel',
			//'g.name as grado'
		)
			->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
			->join('especialidads as e', 'e.id', '=', 'inscripcions.especialidad_id')
			->join('nivels as n', 'n.id', '=', 'inscripcions.nivel_id')
			->join('grados as g', 'g.id', '=', 'inscripcions.grado_id')
			->where('c.st_cliente_id', 4)
			->where('inscripcions.plantel_id', $datos['plantel'])
			->groupBy('e.id')
			->groupBy('e.name')
			->get();
		//dd($inscripciones_clientes_activos->toArray());
		$hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
		$fec_aux = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));

		$hoy->subMonth();
		//dd($hoy->year);
		$resumen = array();
		foreach ($inscripciones_clientes_activos as $ica) {
			$linea = array();
			$linea['especialidad'] = $ica->especialidad;
			$linea['activos'] = $ica->total_especialidad;
			$bajas = HistoriaCliente::select(
				'c.id as cliente'
				//'c.st_cliente_id',
				//'e.name as especialidad',
				//'n.name as nivel',
				//'g.name as grado'
			)
				->join('clientes as c', 'c.id', '=', 'historia_clientes.cliente_id')
				->join('inscripcions as i', 'i.cliente_id', '=', 'c.id')
				->join('especialidads as e', 'e.id', '=', 'i.especialidad_id')
				->join('nivels as n', 'n.id', '=', 'i.nivel_id')
				->join('grados as g', 'g.id', '=', 'i.grado_id')
				->where('historia_clientes.evento_cliente_id', 2)
				->where('c.st_cliente_id', 3)
				->whereMonth('historia_clientes.fecha', $hoy->month)
				->whereYear('historia_clientes.fecha', $hoy->year)
				->where('i.plantel_id', $datos['plantel'])
				->where('i.especialidad_id', $ica->id)
				->whereNull('i.deleted_at')
				->get();
			$linea['bajas'] = count($bajas);
			array_push($resumen, $linea);
		}
		//dd($resumen);

		//dd(count($inscripciones_clientes_activos) . "-" . count($bajas->toArray()));
		$total = count($bajas) + count($inscripciones_clientes_activos);
		$porcentaje_bajas = round(((count($bajas) * 100) / $total), 2);
		$mese = Mese::find($hoy->month);

		return view('historiaClientes.reportes.wdBajasDetalle', compact('mese', 'resumen'));
	}

	public function clientesEstatus()
	{
		$eventos = EventoCliente::pluck('name', 'id');
		$stClientes = StCliente::pluck('name', 'id');
		return view('historiaClientes.reportes.clientesEstatus', compact('eventos', 'stClientes'))
			->with('list', Cliente::getListFromAllRelationApps());;
	}

	public function clientesEstatusR(Request $request)
	{
		$datos = $request->all();
		//dd($datos);

		$historia_clientes = HistoriaCliente::select(
			'c.id as cliente',
			'c.nombre',
			'c.nombre2',
			'c.ape_paterno',
			'historia_clientes.descripcion',
			'c.ape_materno',
			'p.razon',
			'stc.name as estatus',
			'historia_clientes.fecha',
			'c.tel_cel',
			'ec.name as evento',
			'g.seccion',
			'g.name as grado',
			'c.calle',
			'c.no_interior',
			'c.colonia',
			'muni.name as municipio',
			'est.name as estado',
			'c.cp',
			'c.tel_cel',
			'c.tel_fijo',
			'historia_clientes.reactivado',
			'historia_clientes.fec_reactivado',
			'historia_clientes.fec_autorizacion'
		)
			->join('clientes as c', 'c.id', '=', 'historia_clientes.cliente_id')
			->join('estados as est', 'est.id', 'c.estado_id')
			->join('municipios as muni', 'muni.id', 'c.municipio_id')
			->join('plantels as p', 'p.id', '=', 'c.plantel_id')
			->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
			->join('evento_clientes as ec', 'ec.id', '=', 'historia_clientes.evento_cliente_id')
			->join('combinacion_clientes as cc', 'cc.cliente_id', 'c.id')
			->join('grados as g', 'g.id', 'cc.grado_id')
			->whereDate('fecha', '>=', $datos['fecha_f'])
			->whereDate('fecha', '<=', $datos['fecha_t'])
			->whereIn('evento_cliente_id', $datos['evento'])
			->whereIn('p.id', $datos['plantel'])
			->where('c.st_cliente_id', $datos['st_cliente_f'])
			->whereNull('cc.deleted_at')
			->orderBy('p.id')
			->orderBy('g.id')
			->orderBy('c.id')
			->get();
		//dd($historia_clientes->toArray());

		return view('historiaClientes.reportes.clientesEstatusR', array(
			'registros' => $historia_clientes,
			'datos' => $datos
		))
			->with('list', Cliente::getListFromAllRelationApps());;
	}

	public function bajasSegementado()
	{
		$planteles_activos = Empleado::where('user_id', Auth::user()->id)->first()->plantels()->pluck('id');
		//dd($planteles_activos);
		$plantels = Plantel::whereIn('id', $planteles_activos)->pluck('razon', 'id');
		//dd($plantels);

		return view('historiaClientes.reportes.bajasSegmentado', compact('plantels'))
			->with('list', Cliente::getListFromAllRelationApps());;
	}

	public function bajasSegementadoR(Request $request)
	{
		$datos = $request->all();
		//dd($datos);

		$historia_clientes = HistoriaCliente::select(
			'c.id as cliente',
			'c.id as id_cliente',
			'c.nombre',
			'c.nombre2',
			'c.ape_paterno',
			'historia_clientes.descripcion',
			'c.ape_materno',
			'p.razon',
			'stc.name as estatus',
			'historia_clientes.fecha',
			'c.tel_cel',
			'ec.name as evento',
			'g.seccion',
			'g.name as grado',
			'c.calle',
			'c.no_interior',
			'c.colonia',
			'muni.name as municipio',
			'est.name as estado',
			'c.cp',
			'c.tel_cel',
			'c.tel_fijo',
			'historia_clientes.reactivado',
			'historia_clientes.fec_reactivado',
			'historia_clientes.fec_autorizacion',
			DB::raw('(select monto from adeudos as a where a.cliente_id=c.id and a.deleted_at is null and pagado_bnd=0 order by fecha_pago asc limit 1) as adeudo_pendiente')
		)
			->join('clientes as c', 'c.id', '=', 'historia_clientes.cliente_id')
			->join('estados as est', 'est.id', 'c.estado_id')
			->join('municipios as muni', 'muni.id', 'c.municipio_id')
			->join('plantels as p', 'p.id', '=', 'c.plantel_id')
			->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
			->join('evento_clientes as ec', 'ec.id', '=', 'historia_clientes.evento_cliente_id')
			->join('combinacion_clientes as cc', 'cc.cliente_id', 'c.id')
			->join('grados as g', 'g.id', 'cc.grado_id')
			->whereDate('fecha', '>=', $datos['fecha_f'])
			->whereDate('fecha', '<=', $datos['fecha_t'])
			->where('evento_cliente_id', 2)
			->whereIn('p.id', $datos['plantel_f'])
			//->where('c.st_cliente_id', $datos['st_cliente_f'])
			->whereNull('cc.deleted_at')
			->orderBy('p.id')
			->orderBy('g.id')
			->orderBy('c.id')
			->get();
		//dd($historia_clientes->toArray());

		return view('historiaClientes.reportes.bajasSegmentadoR', array(
			'registros' => $historia_clientes,
			'datos' => $datos
		))
			->with('list', Cliente::getListFromAllRelationApps());
	}
}
