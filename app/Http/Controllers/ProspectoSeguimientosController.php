<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Lead;
use Exception;
use App\StTarea;
use App\Empleado;
use App\Prospecto;
use App\Http\Requests;
use App\ProspectoAviso;
use App\ProspectoStSeg;
use App\ProspectoTarea;
use App\ProspectoAsunto;
use App\ProspectoInforme;
use App\ProspectoStTarea;
use App\ProspectoEtiquetum;
use App\ProspectoHactividad;
use Illuminate\Http\Request;
use App\ProspectoSeguimiento;
use App\ProspectoParteInforme;
use App\ProspectoAsignacionTarea;
use App\Http\Controllers\Controller;
use App\Http\Requests\createProspectoSeguimiento;
use App\Http\Requests\updateProspectoSeguimiento;

class ProspectoSeguimientosController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoSeguimientos = ProspectoSeguimiento::getAllData($request);

		return view('prospectoSeguimientos.index', compact('prospectoSeguimientos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoSeguimientos.create')
			->with('list', ProspectoSeguimiento::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoSeguimiento $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		ProspectoSeguimiento::create($input);

		return redirect()->route('prospectoSeguimientos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoSeguimiento $prospectoSeguimiento)
	{
		$prospectoSeguimiento = $prospectoSeguimiento->where('prospecto_id', $id)->first();
		//dd($prospectoSeguimiento);

		if (is_null($prospectoSeguimiento)) {
			$prospecto = Prospecto::find($id);
			$input['prospecto_id'] = $id;
			$input['mes'] = $prospecto->created_at->month;
			$input['contador_sms'] = 0;
			$input['prospecto_st_seg_id'] = 1;
			$input['usu_alta_id'] = Auth::user()->id;
			$input['usu_mod_id'] = Auth::user()->id;
			$prospectoSeguimiento = ProspectoSeguimiento::create($input);
		}
		//dd($prospectoSeguimiento);
		$prospectoAsignacionTareas = ProspectoAsignacionTarea::where('prospecto_id', '=', $prospectoSeguimiento->prospecto_id)->orderBy('created_at', 'desc')->get();
		//dd($prospectoAsignacionTareas->toArray());
		$prospectoAvisos = ProspectoAviso::select(
			'prospecto_avisos.id',
			'prospecto_avisos.activo',
			'a.name',
			'prospecto_avisos.detalle',
			'prospecto_avisos.fecha',
			DB::Raw('DATEDIFF(prospecto_avisos.fecha,CURDATE()) as dias_restantes')
		)
			->join('prospecto_asuntos as a', 'a.id', '=', 'prospecto_avisos.prospecto_asunto_id')
			->where('prospecto_seguimiento_id', '=', $prospectoSeguimiento->id)
			->get();

		$tareas = ProspectoTarea::pluck('name', 'id');
		$asuntos = ProspectoAsunto::pluck('name', 'id');
		$estatusTareas = ProspectoStTarea::pluck('name', 'id');
		$prospectoStSeg = ProspectoStSeg::pluck('name', 'id');
		$actividades = ProspectoHactividad::where('prospecto_seguimiento_id', '=', $prospectoSeguimiento->id)->orderBy('fecha')->orderBy('hora')->get();
		$partesInformes = ProspectoParteInforme::pluck('name', 'id');
		$etiquetas = ProspectoEtiquetum::pluck('name', 'id');
		$prospectoInformes = ProspectoInforme::where('prospecto_id', $prospectoSeguimiento->prospecto_id)->with(['parteInforme', 'etiqueta'])->get();
		//dd($prospectoInformes);

		return view(
			'prospectoSeguimientos.show',
			compact(
				'prospectoSeguimiento',
				'tareas',
				'asuntos',
				'estatusTareas',
				'prospectoAsignacionTareas',
				'prospectoAvisos',
				'prospectoStSeg',
				'actividades',
				'partesInformes',
				'etiquetas',
				'prospectoInformes'
			)
		);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoSeguimiento $prospectoSeguimiento)
	{
		$prospectoSeguimiento = $prospectoSeguimiento->find($id);
		return view('prospectoSeguimientos.edit', compact('prospectoSeguimiento'))
			->with('list', ProspectoSeguimiento::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoSeguimiento $prospectoSeguimiento)
	{
		$prospectoSeguimiento = $prospectoSeguimiento->find($id);
		return view('prospectoSeguimientos.duplicate', compact('prospectoSeguimiento'))
			->with('list', ProspectoSeguimiento::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoSeguimiento $prospectoSeguimiento, updateProspectoSeguimiento $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$prospectoSeguimiento = $prospectoSeguimiento->find($id);
		$prospectoSeguimiento->update($input);

		return redirect()->route('prospectoSeguimientos.show', $prospectoSeguimiento->prospecto_id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, ProspectoSeguimiento $prospectoSeguimiento)
	{
		$prospectoSeguimiento = $prospectoSeguimiento->find($id);
		$prospectoSeguimiento->delete();

		return redirect()->route('prospectoSeguimientos.index')->with('message', 'Registro Borrado.');
	}

	public function kpiRendimiento()
	{
		$planteles = Empleado::where('user_id', '=', Auth::user()->id)->where('st_empleado_id', '<>', 3)->first()->plantels->pluck('razon', 'id');
		return view('prospectoSeguimientos.reportes.kpiRendimiento', compact('planteles'));
	}

	public function kpiRendimientoR(Request $request)
	{
		$datos = $request->all();

		$empleados = Empleado::select(
			'empleados.id',
			'empleados.user_id',
			'empleados.nombre',
			'empleados.ape_paterno',
			'empleados.ape_materno',
			'p.razon as plantel',
			'p.id as plantel_id'
		)
			->join('plantels as p', 'p.id', 'empleados.plantel_id')
			->where('p.id', '>', 0)
			->where('empleados.st_prospecto_id', 2)
			->whereIn('p.id', $datos['plantel_id'])
			->orderBy('p.id')
			->orderBy('empleados.id')
			->get();
		//dd($empleados->toArray());
		$registros = array();

		foreach ($empleados as $empleado) {
			$leads = Lead::where('usu_alta_id', $empleado->user_id)
				->whereDate('created_at', '>=', $datos['fecha_f'])
				->whereDate('created_at', '<=', $datos['fecha_t'])
				->with([
					'stLead',
					'plantel',
					'prospecto',
					'prospecto.usu_alta',
					'prospecto.prospectoAsignacionTareas',
					'prospecto.prospectoAsignacionTareas.usu_alta',
					'prospecto.prospectoAsignacionTareas.prospectoTarea',
				])
				->orderBy('st_lead_id')
				->get();
			//dd('fil');
			foreach ($leads as $lead) {
				$prospecto = Prospecto::where('lead_id', $lead->id)->first();
				if (!is_null($prospecto)) {
					$tareas = ProspectoAsignacionTarea::where('prospecto_id', $prospecto->id)
						->orderBy('prospecto_st_tarea_id')
						->get();
					if (count($tareas) > 0) {
						foreach ($tareas as $tarea) {
							array_push($registros, array(
								"lead_id" => $lead->id,
								'lead_created_at' => $lead->created_at,
								"lead_st" => $lead->stLead->name,
								'lead_plantel' => optional($lead->plantel)->razon,
								'lead_creador' => $lead->usu_alta->name,
								'prospecto_id' => $lead->prospecto->id,
								'prospecto_creador' => $lead->prospecto->usu_alta->name,
								'prospecto_created_at' => $lead->prospecto->created_at,
								'tarea' => $tarea->prospectoTarea->name,
								'tarea_fecha' => $tarea->created_at,
								'tarea_estatus' => $tarea->prospectoStTarea->name,
								'tarea_creador' => $tarea->usu_alta->name,
								'cliente' => $prospecto->cliente_id
							));
						}
					} else {
						array_push($registros, array(
							"lead_id" => $lead->id,
							'lead_created_at' => $lead->created_at,
							"lead_st" => $lead->stLead->name,
							'lead_plantel' => optional($lead->plantel)->razon,
							'lead_creador' => $lead->usu_alta->name,
							'prospecto_id' => $lead->prospecto->id,
							'prospecto_creador' => $lead->prospecto->usu_alta->name,
							'prospecto_created_at' => $lead->prospecto->created_at,
							'tarea' => '',
							'tarea_fecha' => '',
							'tarea_estatus' => '',
							'tarea_creador' => '',
							'cliente' => $prospecto->cliente_id
						));
					}
				} else {
					array_push($registros, array(
						"lead_id" => $lead->id,
						'lead_created_at' => $lead->created_at,
						"lead_st" => $lead->stLead->name,
						'lead_plantel' => optional($lead->plantel)->razon,
						'lead_creador' => $lead->usu_alta->name,
						'prospecto_id' => '',
						'prospecto_creador' => '',
						'prospecto_created_at' => '',
						'tarea' => '',
						'tarea_fecha' => '',
						'tarea_estatus' => '',
						'tarea_creador' => '',
						'cliente' => ''
					));
				}
			}
		}
		//dd($registros);

		return view('prospectoSeguimientos.reportes.kpiRendimientoR', compact(
			'registros',
			'datos'
		));
	}
}
