<?php

namespace App\Http\Controllers;

use App\Adeudo;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use File as Archi;

use App\HistoriaCliente;
use App\Cliente;
use App\EventoCliente;
use App\Mese;
use App\Seguimiento;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHistoriaCliente;
use App\Http\Requests\createHistoriaCliente;
use App\Inscripcion;
use App\RegistroHistoriaCliente;
use App\StHistoriaCliente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
		$inscripcions = Inscripcion::select(DB::raw('inscripcions.id, concat(p.cve_plantel," / ",e.name," / ",n.name," / ",g.name," / ",gru.name," / ",l.name," / ",pe.name) as inscripcion'))
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
		return view('historiaClientes.create', compact('cliente', 'inscripcions'))
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
		$input['st_historia_cliente_id'] = 1;

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
		$inscripcions = Inscripcion::select(DB::raw('inscripcions.id, concat(p.cve_plantel," / ",e.name," / ",n.name," / ",g.name," / ",gru.name," / ",l.name," / ",pe.name) as inscripcion'))
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
		return view('historiaClientes.edit', compact('historiaCliente', 'cliente', 'inscripcions'))
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
		$historiaCliente->save();

		$cliente = Cliente::find($historiaCliente->cliente_id);
		$cliente->st_cliente_id = 4;
		$cliente->save();

		$seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
		$seguimiento->st_seguimiento_id = 2;
		$seguimiento->save();

		$inscripcion = Inscripcion::find($historiaCliente->inscripcion_id);
		$inscripcion->st_inscripcion_id = 1;
		$inscripcion->save();

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
		return view('historiaClientes.reportes.clientesEstatus', compact('eventos'))
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
			'ec.name as evento'
		)
			->join('clientes as c', 'c.id', '=', 'historia_clientes.cliente_id')
			->join('plantels as p', 'p.id', '=', 'c.plantel_id')
			->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
			->join('evento_clientes as ec', 'ec.id', '=', 'historia_clientes.evento_cliente_id')
			->whereDate('fecha', '>=', $datos['fecha_f'])
			->whereDate('fecha', '<=', $datos['fecha_t'])
			->whereIn('evento_cliente_id', $datos['evento'])
			->whereIn('p.id', $datos['plantel'])
			->orderBy('p.id')
			->orderBy('ec.id')
			->orderBy('c.id')
			->get();
		//dd($historia_clientes->toArray());

		return view('historiaClientes.reportes.clientesEstatusR', array(
			'registros' => $historia_clientes,
			'datos' => $datos
		))
			->with('list', Cliente::getListFromAllRelationApps());;
	}
}
